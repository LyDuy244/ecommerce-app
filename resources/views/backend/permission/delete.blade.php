@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <x-dashboard.heading heading="Thêm thành viên"/>
    <form action="{{ route('permission.destroy', $permission->id) }}" method="POST">
        @csrf
        @method('Delete')
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">
                            Thông tin chung
                        </div>
                        <div class="panel-description">
                            <p>- Bạn đang muốn xóa ngôn ngữ có tên là: <span class="text-danger">{{ $permission->name }}</span></p>
                            <p>- Lưu ý: Xóa không thể khôi phục thành viên sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này <span class="text-danger">(*)</span> là bắt buộc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Tên quyền <span class="text-danger">(*)</span></label>
                                        
                                        <input 
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            placeholder=""
                                            readonly
                                            autocomplete="off"
                                            value="{{ old('name', $permission->name ?? '') }}"
                                        >

                                        @error('name')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-danger mb15" type="submit" name="send" value="send">Xóa dữ liệu</button>
            </div>
        </div>
    </form>
@endsection
