<?php

namespace App\Models;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Array_;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    protected $fillable = [
        'image',
        'album',
        'order',
        'user_id',
        'follow',
        'publish',
        'post_catalogue_id'
    ];

    public function post_catalogues()
    {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_post', 'post_id', 'post_catalogue_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'post_language', 'post_id', 'language_id')
            ->withPivot(
                'name',
                'canonical',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'description',
                'content'
            )
            ->withTimeStamps();
    }

    public function createPost(StorePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = $this->createPostFunc($request);
            if ($post->id > 0) {
                $this->uploadLanguageForPost($post, $request);
                $this->updateCatalogueForPost($post, $request);
                $this->createRouter($post, $request);
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function edit($id, UpdatePostRequest $request)
    {
        DB::beginTransaction();
        try {
            $post = $this->findById($id);

            if ($this->uploadPost($post, $request) == true) {
                $this->uploadLanguageForPost($post, $request);
                $this->updateCatalogueForPost($post, $request);
                $this->updateRouter($post, $request);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function findById($id, array $column = ['*'], array $relation = [])
    {
        return Post::select($column)->with($relation)->findOrFail($id);
    }

    public function findPostById($id, $language_id = 0, array $column = ["*"], array $join = [])
    {
        $query = Post::select($column);
        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $value) {
                $query->join($value[0], $value[1], $value[2], $value[3]);
            }
        }
        $query = $query->where('tb2.language_id', '=', $language_id)->with('post_catalogues')
            ->find($id);
        return $query;
    }



    public function deletePostById($id)
    {
        DB::beginTransaction();
        try {
            Post::find($id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function deleteForcePostById($id)
    {
        return  Post::find($id)->forceDelete();
    }

    public function pagination(array $column = ["*"], array $condition = [], array $join = [], int $perpage = 20, array $relations = [], array $orderBy = [], array $rawQuery = [], array $groupBy = [])
    {
        $query = Post::where(function ($query) use ($condition) {
            if (isset($condition['kw']) && !empty($condition['kw'])) {
                $query->where('name', 'like', '%' . $condition['kw'] . '%');
            }

            if (isset($condition['publish']) && !empty($condition['publish'])) {
                $query->where('publish', '=', $condition['publish'] - 1);
            }


            if (isset($condition['where']) && count($condition['where'])) {
                foreach ($condition['where'] as $key => $value) {
                    $query->where($value[0], $value[1], $value[2]);
                }
            }

            return $query;
        })->select($column);

        if (isset($rawQuery['whereRaw']) && count($rawQuery['whereRaw'])) {
            foreach ($rawQuery['whereRaw'] as $key => $val) {
                $query->whereRaw($val[0], $val[1]);
            }
        }
        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
                $query->with($relation);
            }
        }

        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $value) {
                $query->join($value[0], $value[1], $value[2], $value[3]);
            }
        }

        if (isset($groupBy) && !empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        if (isset($orderBy) && is_array($orderBy) && count($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }
        return $query->paginate($perpage)->withQueryString();
    }



    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            Post::where('id', $post['modelId'])->update([$post['field'] => $post['value'] == 1 ? 0 : 1]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }
    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];

            $this->updateByWhereIn('id', $post['id'], $payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }
    public function updateByWhereIn(string $whereInField = "", array $whereIn = [], array $payload = [])
    {
        DB::beginTransaction();
        try {
            Post::whereIn($whereInField, $whereIn)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    private function createPostFunc($request)
    {
        $payload = $request->only($this->payload());
        $payload['publish'] = $payload['publish'] == 2 ? 1 : 0;
        $payload['follow'] = $payload['follow'] == 2 ? 1 : 0;
        $payload['album'] = $this->formatAlbum($payload);
        $payload['user_id'] = Auth::id();
        $post = Post::create($payload);
        return $post;
    }


    private function uploadPost($post, $request)
    {
        $payload = $request->only($this->payload());
        $payload['publish'] = $payload['publish'] == 2 ? 1 : 0;
        $payload['follow'] = $payload['follow'] == 2 ? 1 : 0;
        $payload['album'] = $this->formatAlbum($payload);
        return Post::find($post->id)->update($payload);
    }

    private function uploadLanguageForPost($post, $request)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['language_id'] = 1;
        $payload['post_id'] = $post->id;
        $payload['canonical'] = Str::slug($payload['canonical']);
        $post->languages()->detach([$payload['language_id'], $post->id]);
        return $this->createPivot($post, $payload, 'languages');
    }
    private function updateCatalogueForPost($post, $request)
    {
        $post->post_catalogues()->sync($this->catalogue($request));
    }

    private function formatAlbum($payload)
    {
        return (isset($payload['album']) && !empty($payload['album'])) ? json_encode($payload['album']) : '';
    }

    public function createPivot($model, array $payload = [], string $relation = '')
    {
        return $model->{$relation}()->attach($model->id, $payload);
    }

    private function catalogue($request)
    {
        if ($request->input('catalogue') !== null) {
            return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
        }
        return $request->post_catalogue_id;
    }

    private function createRouter($postCatalogue, $request)
    {
        $router = $this->formatRouterPayload($postCatalogue, $request);
        return $this->router->createRouter($router);
    }
    private function updateRouter($postCatalogue, $request)
    {
        $payloadRouter = $this->formatRouterPayload($postCatalogue, $request);
        $condition = [
            ['module_id', '=', $postCatalogue->id],
            ['controller', '=', 'App\Http\Controllers\Frontend\PostCatalogueController']
        ];
        $router = $this->router->findByCondition($condition);
        return $this->router->edit($router->id, $payloadRouter);
    }
    private function formatRouterPayload($postCatalogue, $request)
    {
        $router = [
            'canonical' => Str::slug($request->input('canonical')),
            'module_id' => $postCatalogue->id,
            'controller' => 'App\Http\Controllers\Frontend\PostCatalogueController'
        ];
        return $router;
    }

    private function payload()
    {
        return ['post_catalogue_id', 'follow', 'image', 'publish', 'album'];
    }
    private function payloadLanguage()
    {
        return  ['name', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword', 'canonical'];;
    }
}
