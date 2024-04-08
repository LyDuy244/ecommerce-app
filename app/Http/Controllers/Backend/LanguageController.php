<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{

    private $language;

    public function __construct()
    {
        $this->language = new Language();
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'language');

        $title = 'Quản lý cấu hình chung';

        $condition['kw'] = $request->kw;
        $condition['publish'] = $request->integer('publish');
        $perpage = $request->integer('perpage');


        $languages = $this->language->pagination(['id', 'name', 'image', 'canonical', 'description', 'publish'], $condition, [], $perpage, []);
        // $Languages = Language::paginate(10);
        return view('backend.language.index', compact('languages', 'title'));
    }

    public function create()
    {
        $this->authorize('modules', 'language.create');

        $title = 'Thêm mới nhóm thành viên';
        $method = 'create';
        return view("backend.language.store", compact('title', 'method'));
    }


    public function store(StoreLanguageRequest $request)
    {
        if ($this->language->create($request)) {
            return redirect()->route('language.index')->with("success", "Thêm mới thành viên thành công");
        }
        return redirect()->route('language.index')->with("error", "Thêm mới thành viên thất bại. Hãy thử lại");
    }

    public function edit($id)
    {
        $this->authorize('modules', 'language.edit');

        $title = 'Sửa thông tin nhóm thành viên';
        $language = $this->language->findById($id);
        $method = 'edit';

        return view("backend.language.store", compact('title', 'language', 'method'));
    }
    public function update(UpdateLanguageRequest $request, $id)
    {
        if ($this->language->edit($id, $request)) {
            return redirect()->route('language.index')->with("success", "Cập nhật bản ghi thành công");
        }
        return redirect()->route('language.index')->with("error", "Cập nhật bản ghi thất bại. Hãy thử lại");
    }

    public function delete($id)
    {
        $this->authorize('modules', 'language.delete');

        $language = $this->language->findById($id);
        $title = 'Xóa nhóm thành viên';

        return view("backend.language.delete", compact('language', 'title'));
    }

    public function destroy($id)
    {
        if ($this->language->deleteLanguageById($id)) {
            return redirect()->route('language.index')->with("success", "Xóa bản ghi thành công");
        }
        return redirect()->route('language.index')->with("error", "Xóa bản ghi thất bại. Hãy thử lại");
    }

    public function switchBackendLanguage($id)
    {
        $language = $this->language->findById($id);
        if ($this->language->switch($id)) {
            session(['app_locale' => $language->canonical]);
            \App::setlocale($language->canonical);
        };
        return back();
    }

    public function translate($id = 0, $languageId = 0, $model = '')
    {
        $this->authorize('modules', 'language.translate');
        $title = 'Sửa thông tin nhóm thành viên';

        $methodName = "get" . $model . "ById";
        $modelInstance = $this->modelInstance($model);
        $currentLanguage = $this->language->findByCondition([['canonical', '=', session('app_locale')]]);

        $object = $modelInstance->{$methodName}($id, $currentLanguage->id);
        $objectTranslate = $modelInstance->{$methodName}($id, $languageId);

        return view("backend.language.translate", compact('title', 'object', 'objectTranslate'));
    }

    private function modelInstance($model)
    {
        $modelNamespace = '\App\Models\\' . ucfirst($model);
        if (class_exists($modelNamespace)) {
            $modelInstance = app($modelNamespace);
        }
        return $modelInstance ?? null;
    }
}
