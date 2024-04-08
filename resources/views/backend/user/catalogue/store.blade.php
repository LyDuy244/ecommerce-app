@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection
@section('css')
@endsection
@php
    $url = $method == 'create' ? route('user.catalogue.store') : route('user.catalogue.update', $userCatalogue->id)
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
                            <p>- Nhập thông tin chung của nhóm thành viên</p>
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
                                        <label for="" class="control-label text-left">Tên nhóm <span class="text-danger">(*)</span></label>
                                        <input 
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            value="{{ old('name', $userCatalogue->name ?? '') }}"
                                        >
                                        @error('name')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Ghi chú <span class="text-danger">(*)</span></label>
                                        
                                        <input 
                                            type="text"
                                            name="description"
                                            class="form-control"
                                            placeholder=""
                                            autocomplete="off"
                                            value="{{ old('description', $userCatalogue->description ?? '') }}"
                                        >

                                        @error('description')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="text-right">
                <button class="btn btn-primary mb15" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
@endsection