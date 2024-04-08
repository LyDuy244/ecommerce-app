@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <x-dashboard.heading heading="Quản lý Quyền"/>
    <div class="mt20">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Danh sách Quyền</h5>
            </div>
            <div class="ibox-content">
                @include('backend.permission.components.filter')
                @include('backend.permission.components.table')

            </div>
        </div>
    </div>
@endsection

