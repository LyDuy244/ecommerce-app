<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function changeStatus(Request $request)
    {
        $post = $request->except('_token');

        $modelNamespace = '\App\Models\\' . ucfirst($post['model']);
        if (class_exists($modelNamespace)) {
            $modelInstance = app($modelNamespace);
        }
        $flag = $modelInstance->updateStatus($post);
        return response()->json(['flag' => $flag]);
    }

    public function changeStatusAll(Request $request)
    {
        $post = $request->except('_token');
        $post['value'] = $request->integer('value');

        $modelNamespace = '\App\Models\\' . ucfirst($post['model']);
        if (class_exists($modelNamespace)) {
            $modelInstance = app($modelNamespace);
        }
        $flag = $modelInstance->updateStatusAll($post);
        return response()->json(['flag' => $flag]);
    }
}
