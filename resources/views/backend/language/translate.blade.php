@extends('backend.dashboard.layout')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<x-dashboard.heading heading="Thêm nhóm bài viết"/>
<form action="" method="POST">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>THÔNG TIN CHUNG</h5>
                    </div>
                    <div class="ibox-content">
                       @include('backend.dashboard.components.content', ['model' => ($object) ?? null])
                    </div>
                </div>
                @include('backend.dashboard.components.seo', ['model' => ($object) ?? null])
            </div>
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>THÔNG TIN CHUNG</h5>
                    </div>
                    <div class="ibox-content">
                       @include('backend.dashboard.components.translate', ['model' => ($objectTranslate) ?? null])
                    </div>
                </div>
                @include('backend.dashboard.components.seoTranslate', ['model' => ($objectTranslate) ?? null])
            </div>
        </div>
        <div class="text-right">
            <button class="btn btn-primary mb15 " type="submit" name="send" value="send">Lưu lại</button>
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