<?php

namespace App\Models;

use App\Http\Requests\StoreUserCatalogueRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UserCatalogue extends Model
{
    use HasFactory, SoftDeletes;
    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    protected $table = 'user_catalogues';
    protected $fillable = [
        'name',
        'description',
        'publish'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_catalogue_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_catalogue_permission', 'user_catalogue_id', 'permission_id');
    }

    public function create(StoreUserCatalogueRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $user = UserCatalogue::insert($payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function edit($id, StoreUserCatalogueRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $user = UserCatalogue::find($id)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function findUserCatalogueById($id)
    {
        return UserCatalogue::find($id);
    }

    public function findById($id, array $column = ['*'], array $relation = [])
    {
        return UserCatalogue::select($column)->with($relation)->findOrFail($id);
    }
    public function getUserCatalogueWithRelation(array $relation = [])
    {
        return UserCatalogue::with($relation)->get();
    }

    public function deleteUserCatalogueById($id)
    {
        DB::beginTransaction();
        try {
            UserCatalogue::find($id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function deleteForceUserCatalogueById($id)
    {
        return  UserCatalogue::find($id)->forceDelete();
    }

    public function pagination(array $column = ["*"], array $condition = [], array $join = [], int $perpage = 20, array $relations = [])
    {
        $query = UserCatalogue::where(function ($query) use ($condition) {
            if (isset($condition['kw']) && !empty($condition['kw'])) {
                $query->where('name', 'like', '%' . $condition['kw'] . '%');
            }

            if (isset($condition['publish']) && !empty($condition['publish'])) {
                $query->where('publish', '=', $condition['publish'] - 1);
            }

            return $query;
        })->select($column);

        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                # code...
                $query->withCount($relation);
            }
        }

        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perpage)->withQueryString();
    }

    public function setPermission($request)
    {
        DB::beginTransaction();
        try {

            $permissions = $request->input('permission');
            if (count($permissions)) {
                foreach ($permissions as $key => $val) {
                    $userCatalogue = $this->findUserCatalogueById($key);
                    $userCatalogue->permissions()->detach();
                    $userCatalogue->permissions()->sync($val);
                }
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

    public function updateStatus($post)
    {
        DB::beginTransaction();
        try {
            UserCatalogue::where('id', $post['modelId'])->update([$post['field'] => $post['value'] == 1 ? 0 : 1]);
            $this->changeUserStatus($post);

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
            $this->changeUserStatus($post);

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
            UserCatalogue::whereIn($whereInField, $whereIn)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    private function changeUserStatus($post, array $array = [])
    {
        DB::beginTransaction();
        try {

            if (isset($post['modelId'])) {
                $array[] = $post['modelId'];
                $payload[$post['field']] = $post['value'] == 1 ? 0 : 1;
            } else {
                $array = $post['id'];
                $payload[$post['field']] = $post['value'];
            }


            // $postArr['id'] = $post['id'];
            // $postArr[]


            $this->user->updateByWhereIn('user_catalogue_id', $array, $payload);

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
