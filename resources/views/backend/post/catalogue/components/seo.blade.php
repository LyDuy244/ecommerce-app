<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('message.seo') }} </h5>
    </div>
    <div class="ibox-content">
        <div class="seo-container">
          <div class="meta-title">{{ old('meta_title', ($postCatalogue->meta_title)??"") ?? __('message.seoTitle') }}</div>
          <div class="canonical">{{ (old('canonical', ($postCatalogue->canonical)??"")) ? env("APP_URL").old('canonical', ($postCatalogue->canonical)??"").'.html' : __('message.seoCanonical') }}</div>
          <div class="meta-description">
            {{ old('meta_description', ($postCatalogue->meta_description)??"") ??  __('message.seoDescription') }}
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
                            name="meta_title"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            value="{{ old('meta_title', $postCatalogue->meta_title ?? '') }}"
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
                            name="meta_keyword"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            value="{{ old('meta_keyword', $postCatalogue->meta_keyword ?? '') }}"
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
                            name="meta_description"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            
                        >{{ old('meta_description', $postCatalogue->meta_description ?? '') }}</textarea>
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
                                name="canonical"
                                class="form-control seo-canonical"
                                placeholder=""
                                autocomplete="off"
                                value="{{ old('canonical', $postCatalogue->canonical ?? '') }}"
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