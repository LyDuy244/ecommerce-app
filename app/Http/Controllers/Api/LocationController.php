<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class LocationController extends Controller
{
    //
    protected $district;
    protected $province;
    public function __construct()
    {
        $this->district = new District();
        $this->province = new Province();
    }

    public function getLocation(Request $request)
    {
        // $province_id = $request->province_id;
        $get = $request->input();
        $html = '';

        if ($get['target'] == 'districts') {
            $provinces = $this->province->findDistrictByProvinceId($get['data']['location_id'], ['code', 'name'], ['districts']);
            $html = $this->renderHtml($provinces->districts);
        } else if ($get['target'] == 'wards') {
            $districts = $this->district->findWardByDistrictId($get['data']['location_id'], ['code', 'name'], ['wards']);
            $html = $this->renderHtml($districts->wards, 'Chọn Phường/Xã');
        }

        // $districts = $provinces->districts->toArray();
        // dd($districts);
        $response = [
            'html' => $html
        ];
        return response()->json($response);
    }

    public function renderHtml($districts, $root = 'Chọn Quận/Huyện')
    {
        $html = '<option value="0">' . $root . '</option>';
        foreach ($districts as $district) {
            $html .= '<option value="' . $district->code . '">' . $district->name . '</option>';
        }
        return $html;
    }
}
