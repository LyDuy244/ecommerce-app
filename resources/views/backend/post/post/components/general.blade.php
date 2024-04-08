<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Tiêu đề bài viết <span class="text-danger">(*)</span> </label>
            <input 
                type="text"
                name="name"
                class="form-control"
                placeholder=""
                autocomplete="off"
                value="{{ old('name', $post->name ?? '') }}"
            >
            @error('name')
                 <div class="error-message">*{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">Mô tả ngắn </label>
            <textarea
                id="description"
                type="text"
                name="description"
                class="form-control  ck-editor"
                placeholder=""
                autocomplete="off"
                data-height='150'
                >{{ old('description', $post->description ?? '') }}</textarea> 
        </div>
    </div>
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row ">
            <div class="uk-flex uk-middle uk-flex-space-between">
                <label for="" class="control-label text-left">Nội dung</label>
                <a href="" class="multipleUploadImageCkeditor" data-target="ckContent">Upload nhiều hình ảnh</a>
            </div>
            <textarea
                type="text"
                name="content"
                class="form-control ck-editor"
                placeholder=""
                autocomplete="off"
                data-height='500'
                id="ckContent"
                >{{ old('content', $post->content ?? '') }}</textarea> 
        </div>
    </div>
</div>

