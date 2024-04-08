<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Router extends Model
{
    use HasFactory;
    protected $table = 'routers';

    protected $fillable = [
        'canonical',
        'module_id',
        'controller'
    ];

    public function createRouter(array $payload = [])
    {
        DB::beginTransaction();
        try {
            $router = $this->create($payload);

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
        return $this::select($column)->with($relation)->findOrFail($id);
    }

    public function findByCondition($condition = [])
    {
        $query = $this->newQuery();
        foreach ($condition  as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->first();
    }

    public function edit($id, array $payload = [])
    {
        DB::beginTransaction();
        try {
            Router::find($id)->update($payload);

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
