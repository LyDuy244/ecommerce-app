@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@php
    $url = $method == 'create' ? route('user.store') : route('user.update', $user->id)
@endphp
@section('content')
    <x-dashboard.heading heading="Thêm thành viên"/>
    <form action="{{ $url }}" method="POST">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">
                            Thông tin chung
                        </div>
                        <div class="panel-description">
                            <p>- Nhập thông tin chung của người sử dụng</p>
                            <p>- Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Email <span class="text-danger">(*)</span></label>
                                        <input 
                                            type="text"
                                            name="email"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            value="{{ old('email', $user->email ?? '') }}"
                                        >
                                        @error('email')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Họ tên <span class="text-danger">(*)</span></label>
                                        
                                        <input 
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            value="{{ old('name', $user->name ?? '') }}"
                                        >

                                        @error('name')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Nhóm thành viên <span class="text-danger">(*)</span></label>
                                        <select 
                                            name="user_catalogue_id" 
                                            class="form-control setupSelect2"  
                                        >
                                            <option value="0" {{ old('user_catalogue_id', $user->user_catalogue_id ?? '') == 0 ? 'selected' : '' }}>[Chọn Nhóm Thành Viên]</option>
                                            <option value="1" {{ old('user_catalogue_id', $user->user_catalogue_id ?? '') == 1 ? 'selected' : '' }}>Quản trị viên</option>
                                            <option value="2" {{ old('user_catalogue_id', $user->user_catalogue_id ?? '') == 2 ? 'selected' : '' }}>Cộng tác viên</option>
                                        </select>
                                        
                                        @error('user_catalogue_id')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Ngày sinh</label>
                                        
                                        <input 
                                            type="date"
                                            name="birthday"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            value= '{{ old('birthday',  (isset($user->birthday)) ? date('Y-m-d', strtotime($user->birthday)) : '' ) }}'
                                            >
                                    </div>
                                </div>
                            </div>
                            @if ($method == 'create')
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Mật khẩu <span class="text-danger">(*)</span></label>
                                        <input 
                                                type="password" 
                                                name="password"
                                                class="form-control"
                                                autocomplete="off">
                                            @error('password')
                                                <div class="error-message">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label for="" class="control-label text-left">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                                        <input 
                                                type="password" 
                                                name="re_password"
                                                class="form-control"
                                                autocomplete="off">
                                            @error('re_password')
                                                <div class="error-message">*{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb15">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Ảnh đại diện </label>
                                       <input 
                                            type="text" 
                                            name="image"
                                            class="form-control input-image"
                                            autocomplete="off"
                                            data-upload='Images'
                                            value="{{ old('image', $user->image ?? '') }}"
                                            >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">
                            Thông tin liên hệ
                        </div>
                        <div class="panel-description">
                            Nhập thông tin liên hệ của người sử dụng
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Thành phố <span class="text-danger">(*)</span></label>
                                        <select 
                                        name="province_id" 
                                        onchange="getLocation(this.value, selectDistrict, this.dataset.target)" 
                                        class="form-control setupSelect2 province location"
                                        data-target = 'districts'
                                        >
                                            <option value="0">[Chọn thành phố]</option>
                                            @if (isset($province))
                                                @foreach ($province as $item)
                                                    <option value="{{ $item->code }}"  @if (old('province_id') == $item->code)
                                                        selected
                                                    @endif>{{ $item->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Quận/Huyện <span class="text-danger">(*)</span></label>
                                        
                                        <select 
                                            name="district_id" 
                                            class="form-control setupSelect2  district location" 
                                            data-target = 'wards'
                                            onchange="getLocation(this.value, selectWard, this.dataset.target)">
                                            <option value="0">[Chọn Quận/Huyện]</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Phường/Xã <span class="text-danger">(*)</span></label>
                                        <select name="ward_id" class="form-control setupSelect2 ward">
                                            <option value="0">[Chọn Phường/Xã]</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Địa chỉ</label>
                                        
                                        <input 
                                            type="text"
                                            name="address"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            value="{{ old('address', $user->address ?? '') }}"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="row mb15">
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Số điện thoại <span class="text-danger">(*)</span></label>
                                       <input 
                                            type="text" 
                                            name="phone"
                                            class="form-control"
                                            autocomplete="off"
                                            value="{{ old('phone', $user->phone ?? '') }}">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Ghi chú <span class="text-danger">(*)</span></label>
                                       <input 
                                            type="text" 
                                            name="description"
                                            class="form-control"
                                            autocomplete="off"
                                            value="{{ old("description", $user->description ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-primary mb15" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.setupSelect2').select2();
        })
    </script>
    <script>
        var province_id = '{{ isset($user->province_id) ? $user->province_id : old('province_id') }}'
        var district_id = '{{ isset($user->district_id) ? $user->district_id : old('district_id') }}'
        var ward_id = '{{ isset($user->ward_id) ? $user->ward_id : old('ward_id') }}'
        const csrf_token = document.querySelector('input[name="_token"]').value
        const selectProvince = document.querySelector('.province')
        const selectDistrict = document.querySelector('.district')
        const selectWard = document.querySelector('.ward')
        function getLocation(location_id, element, target) {
            element.innerHTML = '';
            let option = {
                'data': {
                    'location_id': location_id
                },
                'target': target
            }
            fetchData(option, element)
        }
        async function fetchData(option, element) {
            const response = await fetch('/location', {
                'method': 'POST',
                'headers': {
                    "content-type": "application/json",
                    "X-CSRF-TOKEN": csrf_token,
                },
                body: JSON.stringify(option),
            })

            const data = await response.json();
            element.insertAdjacentHTML('beforeend', data.html);

            if(district_id != '' && option.target == 'districts'){
                selectDistrict.value = district_id;
                getLocation(district_id, selectWard, 'wards');
            }

            if(ward_id != '' && option.target == 'wards'){
                selectWard.value = ward_id;
            }
        }

        function loadCity(){
            if(province_id != ''){
                selectProvince.value = province_id;
                getLocation(province_id, selectDistrict, 'districts');
            }
        }
        loadCity()
    </script>
    <script>
        document.querySelector('.input-image').addEventListener('click', function () {
            let fileUpload = this.dataset.upload
            BrowseServerInput(this, fileUpload);
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset("backend/plugin/ckfinder/ckfinder.js") }}"></script>
    <script src="{{ asset("backend/library/finder.js") }}"></script>
@endsection