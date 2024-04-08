<div class="ibox">
    <div class="ibox-title">
        <h5>CẤU HÌNH SEO</h5>
    </div>
    <div class="ibox-content">
        <div class="seo-container">
          <div class="meta-title">{{ old('meta_title', ($post->meta_title)??"") ?? 'Bạn chưa có tiêu đề SEO' }}</div>
          <div class="canonical">{{ (old('canonical', ($post->canonical)??"")) ? env("APP_URL").old('canonical', ($post->canonical)??"").'.html' : 'http://duong-dan-cua-ban.html' }}</div>
          <div class="meta-description">
            {{ old('meta_description', ($post->meta_description)??"") ??  'Bạn chưa có mô tả SEO' }}
          </div>
        </div>
        <div class="seo-wrapper">
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span>Tiêu đề SEO</span>
                                <div class="count_meta-title">0 ký tự</div>
                            </div>
                        </label>
                        <input 
                            type="text"
                            name="meta_title"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            value="{{ old('meta_title', $post->meta_title ?? '') }}"
                        >
                   </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            Từ khóa SEO
                        </label>
                        <input 
                            type="text"
                            name="meta_keyword"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            value="{{ old('meta_keyword', $post->meta_keyword ?? '') }}"
                        >
                   </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span>Mô tả SEO</span>
                                <div class="count_meta-description">0 ký tự</div>
                            </div>
                        </label>
                        <textarea 
                            rows="10" 
                            type="text"
                            name="meta_description"
                            class="form-control"
                            placeholder=""
                            autocomplete="off"
                            
                        >{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                   </div>
                </div>
            </div>
            <div class="row mb15">
                <div class="col-lg-12">
                   <div class="form-row">
                        <label for="" class="control-label text-left">
                            Đường dẫn <span class="text-danger">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input 
                                type="text"
                                name="canonical"
                                class="form-control seo-canonical"
                                placeholder=""
                                autocomplete="off"
                                value="{{ old('canonical', $post->canonical ?? '') }}"
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