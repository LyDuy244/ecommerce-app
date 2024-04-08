<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use HasFactory;
    protected $table = 'provinces';
    protected $primaryKey = 'code';
    public $incrementing = false;


    protected $fillable = [
        'name',
    ];


    public function getAll()
    {
        return Province::all();
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }

    public function findDistrictByProvinceId(int $id, array $columns = ['*'], array $relations = [])
    {
        return Province::select($columns)->with($relations)->findOrFail($id);
    }
}
