@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@php
    $url = $method == 'create' ? route('post.store') : route('post.update', $post->id)
@endphp
@section('content')
    <x-dashboard.heading heading="Thêm nhóm bài viết"/>
    <form action="{{ $url }}" method="POST">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>THÔNG TIN CHUNG</h5>
                        </div>
                        <div class="ibox-content">
                           @include('backend.post.post.components.general')
                        </div>
                    </div>
                    @include('backend.dashboard.components.album')
                    @include('backend.post.post.components.seo')
                </div>
                <div class="col-lg-3">
                    @include('backend.post.post.components.aside')
                    <div class="text-right">
                        <button class="btn btn-primary mb15 " type="submit" name="send" value="send">Lưu lại</button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
@endsection

@section('script')
    <script>
        var BASE_URL = '{{ env('APP_URL') }}'
        $(document).ready(function() {
            $('.setupSelect2').select2();
        })

        document.documentElement.addEventListener('click', function (e) {
            if(e.target.dataset.target !== undefined){
                e.preventDefault();
                let object = e.target;
                 let target = object.dataset.target

                browseServerCkeditor(object, 'Images', target)
            }
        })

    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset("backend/plugin/ckeditor/ckeditor.js") }}"></script>
    <script src="{{ asset("backend/library/editor.js") }}"></script>
    <script src="{{ asset("backend/library/seo.js") }}"></script>
    <script src="{{ asset("backend/plugin/ckfinder/ckfinder.js") }}"></script>
    <script src="{{ asset("backend/library/finder.js") }}"></script>
    <script src="{{ asset("backend/library/library.js") }}"></script>
    
@endsection