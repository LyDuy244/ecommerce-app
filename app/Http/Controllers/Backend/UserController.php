<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $province;
    private $district;
    private $ward;
    private $user;

    public function __construct()
    {
        $this->province = new Province();
        $this->district = new District();
        $this->ward = new Ward();
        $this->user = new User();
    }

    public function index(Request $request)
    {
        $this->authorize('modules', 'user');

        $title = 'Quản lý thành viên';

        $condition['kw'] = $request->kw;
        $condition['publish'] = $request->integer('publish');
        $condition['user_catalogue_id'] = $request->user_catalogue_id;
        $perpage = $request->integer('perpage');

        $users = $this->user->pagination(['id', 'name', 'email', 'phone', 'address', 'publish', 'user_catalogue_id'], $condition, [], $perpage);
        // $users = User::paginate(10);
        return view('backend.user.user.index', compact('users', 'title'));
    }

    public function create()
    {
        $this->authorize('modules', 'user.create');

        $title = 'Thêm mới thành viên';
        $province =  $this->province->getAll();
        $method = 'create';
        return view("backend.user.user.store", compact('title', 'province', 'method'));
    }


    public function store(StoreUserRequest $request)
    {
        if ($this->user->create($request)) {
            return redirect()->route('user.index')->with("success", "Thêm mới thành viên thành công");
        }
        return redirect()->route('user.index')->with("error", "Thêm mới thành viên thất bại. Hãy thử lại");
    }

    public function edit($id)
    {
        $this->authorize('modules', 'user.edit');

        $title = 'Sửa thông tin thành viên';
        $user = $this->user->findUserById($id);
        $method = 'edit';


        $province =  $this->province->getAll();
        return view("backend.user.user.store", compact('title', 'province', 'user', 'method'));
    }
    public function update(UpdateUserRequest $request, $id)
    {

        if ($this->user->edit($id, $request)) {
            return redirect()->route('user.index')->with("success", "Cập nhật bản ghi thành công");
        }
        return redirect()->route('user.index')->with("error", "Cập nhật bản ghi thất bại. Hãy thử lại");
    }

    public function delete($id)
    {
        $this->authorize('modules', 'user.delete');

        $user = $this->user->findUserById($id);
        $title = 'Xóa thành viên';

        return view("backend.user.user.delete", compact('user', 'title'));
    }

    public function destroy($id)
    {
        if ($this->user->deleteUserById($id)) {
            return redirect()->route('user.index')->with("success", "Xóa bản ghi thành công");
        }
        return redirect()->route('user.index')->with("error", "Xóa bản ghi thất bại. Hãy thử lại");
    }
}
