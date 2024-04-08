<?php

namespace App\Models;

use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Language extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'languages';
    protected $fillable = [
        'name',
        'canonical',
        'publish',
        'user_id',
        'image',
        'current'
    ];

    public function languages()
    {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')
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

    public function create(StoreLanguageRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $payload['user_id'] = Auth::id();
            $language = Language::insert($payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function edit($id, UpdateLanguageRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $language = Language::find($id)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function findById($id)
    {
        return Language::find($id);
    }

    public function findByCondition($condition = [])
    {
        $query = $this->newQuery();
        foreach ($condition  as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->first();
    }

    public function deleteLanguageById($id)
    {
        DB::beginTransaction();
        try {
            Language::find($id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function deleteForceLanguageById($id)
    {
        return  Language::find($id)->forceDelete();
    }

    public function pagination(array $column = ["*"], array $condition = [], array $join = [], int $perpage = 20, array $relations = [])
    {
        $query = Language::where(function ($query) use ($condition) {
            if (isset($condition['kw']) && !empty($condition['kw'])) {
                $query->where('name', 'like', '%' . $condition['kw'] . '%')
                    ->orWhere('canonical', 'like', '%' . $condition['kw'] . '%');
            }

            if (isset($condition['publish']) && !empty($condition['publish'])) {
                $query->where('publish', '=', $condition['publish'] - 1);
            }

            return $query;
        })->select($column);

        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }

        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perpage)->withQueryString();
    }

    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            Language::where('id', $post['modelId'])->update([$post['field'] => $post['value'] == 1 ? 0 : 1]);
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
            Language::whereIn($whereInField, $whereIn)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function switch($id)
    {
        DB::beginTransaction();
        try {

            $this->where('id', $id)->update(['current' => 1]);
            $this->where('id', '!=', $id)->update(["current" => 0]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }
}
