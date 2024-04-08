<?php

namespace App\Models;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'canonical',
    ];

    public function user_catalogues()
    {
        return $this->belongsToMany(UserCatalogue::class, 'user_catalogue_permission', 'permission_id', 'user_catalogue_id');
    }


    public function create(StorePermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $permission = Permission::insert($payload);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function edit($id, UpdatePermissionRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $permission = Permission::find($id)->update($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function findPermissionById($id)
    {
        return Permission::find($id);
    }

    public function deletePermissionById($id)
    {
        DB::beginTransaction();
        try {
            Permission::find($id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function deleteForcePermissionById($id)
    {
        return  Permission::find($id)->forceDelete();
    }

    public function pagination(array $column = ["*"], array $condition = [], array $join = [], int $perpage = 20, array $relations = [])
    {
        $query = Permission::where(function ($query) use ($condition) {
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


    public function updateByWhereIn(string $whereInField = "", array $whereIn = [], array $payload = [])
    {
        DB::beginTransaction();
        try {
            Permission::whereIn($whereInField, $whereIn)->update($payload);
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
