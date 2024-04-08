@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="{{ asset('backend/css/plugins/switchery/switchery.css') }}" rel="stylesheet">
@endsection
@section('content')
    <x-dashboard.heading heading="Quản lý nhóm bài viết"/>
    <div class="mt20">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Danh sách nhóm bài viết</h5>
                @include('backend.post.catalogue.components.toolbox')
            </div>
            <div class="ibox-content">
                @include('backend.post.catalogue.components.filter')
                @include('backend.post.catalogue.components.table')

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.js-switch').each(function(){
               var switchery = new Switchery(this, {color: '#1AB394'})
            })
        })
    </script>
   
    <script src="{{ asset("backend/js/plugins/switchery/switchery.js") }}"></script>
@endsection