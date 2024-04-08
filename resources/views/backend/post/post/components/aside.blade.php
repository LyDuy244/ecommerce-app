<div class="ibox">
    <div class="ibox-title">
        <h5>Chọn danh mục cha</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notication mb10 block">*Chọn root nếu không có danh mục cha</span>
                    <select class="form-control setupSelect2" name="post_catalogue_id" id="">
                       @foreach ($dropdown as $key => $value)
                           <option {{ old('post_catalogue_id', isset($post->post_catalogue_id) ? $post->post_catalogue_id : '') == $key ? 'selected' : "" }} value="{{ $key }}">{{ $value }}</option>
                       @endforeach
                    </select>
                    @error('post_catalogue_id')
                        <div class="error-message">*{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
         @php
             $catalogue = [];
             if(isset($post)){
                foreach ($post->post_catalogues as $key => $value) {
                    $catalogue[] = $value->id;
                }
             }
         @endphp
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">Danh mục phụ</label>
                    <select multiple class="form-control setupSelect2" name="catalogue[]" id="">
                       @foreach ($dropdown as $key => $value)
                          <option  @if (is_array(old('catalogue', 
                          isset($catalogue) && count($catalogue) ? $catalogue : [])) && isset($post->post_catalogue_id) && $key !== $post->post_catalogue_id  && in_array($key, old('catalogue', isset($catalogue) ? $catalogue : []) )) selected
                          @endif value="{{ $key }}" >{{ $value }}</option>
                       @endforeach
                    </select>
                    @error('catalogue')
                        <div class="error-message">*{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">CHỌN ẢNH ĐẠI DIỆN</div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                  <span class="image img-cover img-target">
                    <img src="{{ old('image', $post->image ?? "/backend/img/not-found.png") ??  '/backend/img/not-found.png' }}" alt="">
                    <input type="hidden" name="image" value="{{ old('image', $post->image ?? "") ?? '' }}" data-upload='Images'>
                  </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">CẤU HÌNH NÂNG CAO</div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                  <div class="mb15">
                    <select name="publish" class="form-control mr10 setupSelect2" id="">
                        <option value="0" selected>Chọn tình trạng</option>
                        <option value="2" {{ old('publish', isset($post->publish) ? $post->publish + 1 : '') == 2 ? 'selected' : "" }}>Publish</option>
                        <option value="1" {{ old('publish', isset($post->publish) ? $post->publish + 1 : '') == 1 ? 'selected' : "" }}>UnPublish</option>
                    </select>
                  </div>
                  <div class="mb15">
                    <select name="follow" class="form-control mr10 setupSelect2" id="">
                        <option value="0" selected>Chọn điều hướng</option>
                        <option value="2" {{ old('follow',  isset($post->follow) ? $post->follow + 1 : '') == 2 ? 'selected' : "" }}>Follow</option>
                        <option value="1" {{ old('follow',  isset($post->follow) ? $post->follow + 1 : '') == 1 ? 'selected' : "" }}>No follow</option>
                    </select>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const imageTarget = document.querySelector('.img-target');

    function browseServerAvartar(object, type) {
        if (typeof type == 'undefined') {
            type = 'Images'
        }
        var finder = new CKFinder();
        finder.resourceType = type;

        finder.selectActionFunction = function (fileUrl, data) {
            object.querySelector('input').value = fileUrl;
            object.querySelector('img').setAttribute( "src", fileUrl );
        }

        finder.popup();
    }


    imageTarget.addEventListener('click', function(){
        const type = "Images"
        browseServerAvartar(this, type);
    })
</script>