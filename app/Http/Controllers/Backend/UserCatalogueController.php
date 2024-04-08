<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use App\Models\UserCatalogue;
use Illuminate\Http\Request;

class UserCatalogueController extends Controller
{

    private $userCatalogue;
    private $permission;

    public function __construct()
    {
        $this->userCatalogue = new UserCatalogue();
        $this->permission = new Permission();
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'user.catalogue');

        $title = 'Quản lý nhóm thành viên';

        $condition['kw'] = $request->kw;
        $condition['publish'] = $request->integer('publish');
        $perpage = $request->integer('perpage');


        $userCatalogues = $this->userCatalogue->pagination(['id', 'name', 'description', 'publish'], $condition, [], $perpage, ['users']);
        // $users = User::paginate(10);
        return view('backend.user.catalogue.index', compact('userCatalogues', 'title'));
    }

    public function create()
    {
        $this->authorize('modules', 'user.catalogue.create');

        $title = 'Thêm mới nhóm thành viên';
        $method = 'create';
        return view("backend.user.catalogue.store", compact('title', 'method'));
    }


    public function store(StoreUserCatalogueRequest $request)
    {
        if ($this->userCatalogue->create($request)) {
            return redirect()->route('user.catalogue.index')->with("success", "Thêm mới thành viên thành công");
        }
        return redirect()->route('user.catalogue.index')->with("error", "Thêm mới thành viên thất bại. Hãy thử lại");
    }

    public function edit($id)
    {
        $this->authorize('modules', 'user.catalogue.edit');

        $title = 'Sửa thông tin nhóm thành viên';
        $userCatalogue = $this->userCatalogue->findUserCatalogueById($id);
        $method = 'edit';

        return view("backend.user.catalogue.store", compact('title', 'userCatalogue', 'method'));
    }
    public function update(StoreUserCatalogueRequest $request, $id)
    {

        if ($this->userCatalogue->edit($id, $request)) {
            return redirect()->route('user.catalogue.index')->with("success", "Cập nhật bản ghi thành công");
        }
        return redirect()->route('user.catalogue.index')->with("error", "Cập nhật bản ghi thất bại. Hãy thử lại");
    }

    public function delete($id)
    {
        $this->authorize('modules', 'user.catalogue.delete');

        $userCatalogue = $this->userCatalogue->findUserCatalogueById($id);
        $title = 'Xóa nhóm thành viên';

        return view("backend.user.catalogue.delete", compact('userCatalogue', 'title'));
    }

    public function destroy($id)
    {
        if ($this->userCatalogue->deleteUserCatalogueById($id)) {
            return redirect()->route('user.catalogue.index')->with("success", "Xóa bản ghi thành công");
        }
        return redirect()->route('user.catalogue.index')->with("error", "Xóa bản ghi thất bại. Hãy thử lại");
    }
    public function permission()
    {
        $title = 'Phân quyền nhóm thành viên';
        $userCatalogues = $this->userCatalogue->getUserCatalogueWithRelation(['permissions']);
        $permissions = $this->permission->all();
        return view("backend.user.catalogue.permission", compact('userCatalogues', 'title', 'permissions'));
    }
    public function updatePermission(Request $request)
    {
        if ($this->userCatalogue->setPermission($request)) {
            return redirect()->route('user.catalogue.index')->with("success", "Cập nhật quyền thành công");
        }
        return redirect()->route('user.catalogue.index')->with("error", "Có vấn đề xảy thử lại");
    }
}
