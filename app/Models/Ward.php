<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $table = 'wards';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function getAll(){
        return Ward::all();
    }

    // public function findWardByDistrictId($id)
    // {
    //     return Ward::where('district_code', $id)->get();
    // }

    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}
