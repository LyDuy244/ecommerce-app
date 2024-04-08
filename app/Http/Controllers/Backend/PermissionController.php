<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permission;

    public function __construct()
    {
        $this->permission = new Permission();
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'permission');

        $title = 'Quản lý cấu hình chung';

        $condition['kw'] = $request->kw;
        $condition['publish'] = $request->integer('publish');
        $perpage = $request->integer('perpage');


        $permissions = $this->permission->pagination(['id', 'name', 'canonical'], $condition, [], $perpage, []);
        // $permissions = permission::paginate(10);
        return view('backend.permission.index', compact('permissions', 'title'));
    }

    public function create()
    {
        $this->authorize('modules', 'permission.create');

        $title = 'Thêm mới nhóm thành viên';
        $method = 'create';
        return view("backend.permission.store", compact('title', 'method'));
    }


    public function store(StorePermissionRequest $request)
    {
        if ($this->permission->create($request)) {
            return redirect()->route('permission.index')->with("success", "Thêm mới thành viên thành công");
        }
        return redirect()->route('permission.index')->with("error", "Thêm mới thành viên thất bại. Hãy thử lại");
    }

    public function edit($id)
    {
        $this->authorize('modules', 'permission.edit');

        $title = 'Sửa thông tin nhóm thành viên';
        $permission = $this->permission->findPermissionById($id);
        $method = 'edit';

        return view("backend.permission.store", compact('title', 'permission', 'method'));
    }
    public function update(UpdatePermissionRequest $request, $id)
    {
        if ($this->permission->edit($id, $request)) {
            return redirect()->route('permission.index')->with("success", "Cập nhật bản ghi thành công");
        }
        return redirect()->route('permission.index')->with("error", "Cập nhật bản ghi thất bại. Hãy thử lại");
    }

    public function delete($id)
    {
        $this->authorize('modules', 'permission.delete');

        $permission = $this->permission->findPermissionById($id);
        $title = 'Xóa nhóm thành viên';

        return view("backend.permission.delete", compact('permission', 'title'));
    }

    public function destroy($id)
    {
        if ($this->permission->deletePermissionById($id)) {
            return redirect()->route('permission.index')->with("success", "Xóa bản ghi thành công");
        }
        return redirect()->route('permission.index')->with("error", "Xóa bản ghi thất bại. Hãy thử lại");
    }
}
