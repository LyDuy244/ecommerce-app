<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'districts';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function getAll()
    {
        return District::all();
    }

    // public function findDistrictByProvinceId($id)
    // {
    //     return District::where('province_code', $id)->get();
    // }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_code', 'code');
    }

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function findWardByDistrictId(int $id, array $columns = ['*'], array $relations = [])
    {
        return District::select($columns)->with($relations)->findOrFail($id);
    }
}
