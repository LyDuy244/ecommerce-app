<?php

namespace App\Models;

use App\Classes\Nestedsetbie;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostCatalogue extends Model
{
    use HasFactory, SoftDeletes;
    protected $nestedset;
    protected $router;

    public function __construct()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => "post_catalogues",
            'foreignkey' => 'post_catalogue_id',
            'language_id' => 1
        ]);

        $this->router = new Router();
    }

    protected $table = 'post_catalogues';
    protected $fillable = [
        'parent_id',
        'lft',
        'rgt',
        'level',
        'image',
        'icon',
        'album',
        'order',
        'user_id',
        'follow',
        'publish'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_catalogue_post', 'post_catalogue_id', 'post_id');
    }
    public function post_catalogue_language()
    {
        return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'post_catalogue_language', 'post_catalogue_id', 'language_id')
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

    public function createPostCatalogue(StorePostCatalogueRequest $request)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->createPostCatalogueFunc($request);
            if ($postCatalogue->id > 0) {
                $this->uploadLanguageForPostCatalogue($postCatalogue, $request);
                $this->createRouter($postCatalogue, $request);
            }

            $this->nestedSetFunc();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function edit($id, UpdatePostCatalogueRequest $request)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->findById($id);


            if ($this->uploadPostCatalogue($postCatalogue, $request)) {
                $this->uploadLanguageForPostCatalogue($postCatalogue, $request);
                $this->updateRouter($postCatalogue, $request);


                $this->nestedSetFunc();
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
        return PostCatalogue::select($column)->with($relation)->findOrFail($id);
    }

    public function findPostCatalogueById($id, $language_id = 0, array $column = ["*"], array $join = [])
    {
        $query = PostCatalogue::select($column);
        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $value) {
                $query->join($value[0], $value[1], $value[2], $value[3]);
            }
        }
        $query = $query->where('tb2.language_id', '=', $language_id)
            ->find($id);
        return $query;
    }



    public function deletePostCatalogueById($id)
    {
        DB::beginTransaction();
        try {
            PostCatalogue::find($id)->delete();

            $this->nestedSetFunc();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function deleteForcePostCatalogueById($id)
    {
        return  PostCatalogue::find($id)->forceDelete();
    }

    public function pagination(array $column = ["*"], array $condition = [], array $join = [], int $perpage = 20, array $relations = [], array $orderBy = [])
    {
        $query = PostCatalogue::where(function ($query) use ($condition) {
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

        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }

        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $value) {
                $query->join($value[0], $value[1], $value[2], $value[3]);
            }
        }

        if (isset($orderBy) && is_array($orderBy) && count($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }
        return $query->paginate($perpage)->withQueryString();
    }

    public function getPostCatalogueById($id, $languageId){
        $query = PostCatalogue::where('id', '=', $id)
            ->where('tb2.language_id', '=', $languageId)
            ->select([
                'post_catalogues.id as id',
                'post_catalogues.parent_id',
                'post_catalogues.publish',
                'post_catalogues.image',
                'post_catalogues.icon',
                'post_catalogues.album',
                'post_catalogues.follow',
                'tb2.name as name',
                'tb2.description as description',
                'tb2.content as content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ])
            ->join('post_catalogue_language as tb2', 'post_catalogues.id', '=', 'tb2.post_catalogue_id')->first();
        return $query;
    }

    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            PostCatalogue::where('id', $post['modelId'])->update([$post['field'] => $post['value'] == 1 ? 0 : 1]);
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
            PostCatalogue::whereIn($whereInField, $whereIn)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function createLanguagePivot($model, array $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }


    private function uploadLanguageForPostCatalogue($postCatalogue, $request)
    {
        $payload = $this->formatLanguagePayload($postCatalogue, $request);
        $postCatalogue->languages()->detach([$payload['language_id'], $postCatalogue->id]);
        return $this->createPivot($postCatalogue, $payload, 'languages');
    }

    private function nestedSetFunc()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }

    private function formatLanguagePayload($postCatalogue, $request)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['language_id'] = 1;
        $payload['post_catalogue_id'] = $postCatalogue->id;
        $payload['canonical'] = Str::slug($payload['canonical']);
        return $payload;
    }

    private function createPostCatalogueFunc($request)
    {
        $payload = $request->only($this->payload());
        $payload['publish'] = $payload['publish'] == 2 ? 1 : 0;
        $payload['follow'] = $payload['follow'] == 2 ? 1 : 0;
        $payload['album'] = $this->formatAlbum($payload);
        $payload['user_id'] = Auth::id();
        $postCatalogue = PostCatalogue::create($payload);

        return $postCatalogue;
    }

    private function uploadPostCatalogue($post, $request)
    {
        $payload = $request->only($this->payload());
        $payload['publish'] = $payload['publish'] == 2 ? 1 : 0;
        $payload['follow'] = $payload['follow'] == 2 ? 1 : 0;
        $payload['album'] = $this->formatAlbum($payload);
        return PostCatalogue::find($post->id)->update($payload);
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
            'canonical' =>  Str::slug($request->input('canonical')),
            'module_id' => $postCatalogue->id,
            'controller' => 'App\Http\Controllers\Frontend\PostCatalogueController'
        ];
        return $router;
    }

    private function formatAlbum($payload)
    {
        return (isset($payload['album']) && !empty($payload['album'])) ? json_encode($payload['album']) : '';
    }

    public function createPivot($model, array $payload = [], string $relation = '')
    {
        return $model->{$relation}()->attach($model->id, $payload);
    }

    private function payload()
    {
        return ['parent_id', 'follow', 'image', 'publish', 'follow', 'album'];
    }
    private function payloadLanguage()
    {


        return  ['name', 'description', 'content', 'meta_title', 'meta_description', 'meta_keyword', 'canonical'];;
    }
}
