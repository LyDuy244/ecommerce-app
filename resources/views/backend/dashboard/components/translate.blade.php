<div class="row mb15">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">{{ __('message.title') }} <span class="text-danger">(*)</span> </label>
            <input 
                type="text"
                name="name"
                class="form-control"
                placeholder=""
                autocomplete="off"
                value="{{ old('translate_name', $model->translate_name ?? '') }}"
            >
            @error('translate_name')
                 <div class="error-message">*{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="" class="control-label text-left">{{ __('message.description') }}</label>
            <textarea
                id="translate_description"
                type="text"
                name="translate_description"
                class="form-control  ck-editor"
                placeholder=""
                autocomplete="off"
                data-height='150'
                >{{ old('translate_description', $model->translate_description ?? '') }}</textarea> 
        </div>
    </div>
</div>
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row ">
            <div class="uk-flex uk-middle uk-flex-space-between">
                <label for="" class="control-label text-left">{{ __('message.content') }}</label>
                <a href="" class="multipleUploadImageCkeditor" data-target="ckContent">{{ __('message.uploadMultipleImage') }}</a>
            </div>
            <textarea
                type="text"
                name="translate_content"
                class="form-control ck-editor"
                placeholder=""
                autocomplete="off"
                data-height='500'
                id="ckContent_2"
                >{{ old('translate_content', $model->translate_content ?? '') }}</textarea> 
        </div>
    </div>
</div>