<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('message.seo') }} </h5>
    </div>
    <div class="ibox-content">
        <div class="seo-container">
          <div class="meta-title">{{ old('translate_meta_title', ($model->meta_title)??"") ?? __('message.seoTitle') }}</div>
          <div class="canonical">{{ (old('translate_canonical', ($model->canonical)??"")) ? env("APP_URL").old('canonical', ($model->canonical)??"").'.html' : __('message.seoCanonical') }}</div>
          <div class="meta-description">
            {{ old('translate_meta_description', ($model->meta_description)??"") ??  __('message.seoDescription') }}
          </div>
        </div>
        <div class="seo-wrapper">
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span>{{ __('message.seoMetaTitle') }}</span>
                                <div class="count_meta-title">0 {{ __('message.character') }}</div>
                            </div>
                        </label>
                        <input 
                            type="text"
                            name="translate_meta_title"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            value="{{ old('translate_meta_title', $model->meta_title ?? '') }}"
                        >
                   </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            {{ __('message.seoMetaKeyword') }}
                        </label>
                        <input 
                            type="text"
                            name="translate_meta_keyword"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            value="{{ old('translate_meta_keyword', $model->meta_keyword ?? '') }}"
                        >
                   </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span>{{ __('message.seoMetaDescription') }}</span>
                                <div class="count_meta-description">0 {{ __('message.character') }}</div>
                            </div>
                        </label>
                        <textarea 
                            rows="10" 
                            type="text"
                            name="translate_meta_description"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            
                        >{{ old('translate_meta_description', $model->meta_description ?? '') }}</textarea>
                   </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            {{ __('message.canonical') }} <span class="text-danger">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text"
                                name="translate_canonical"
                                class="form-control seo-canonical"
                                placeholder=""
                                autocomplete="off"
                                value="{{ old('translate_canonical', $model->canonical ?? '') }}"
                            >
                            <span class="baseUrl">{{ env('APP_URL') }}</span>
                            @error('canonical')
                                <div class="error-message">*{{ $message }}</div>
                            @enderror
                        </div>
                   </div>
                </div>
            </div>
        </div>  
    </div>
   
</div>
