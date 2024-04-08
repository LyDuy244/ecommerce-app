<div class="ibox">
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="" class="control-label text-left">{{  __('message.parent') }}<span class="text-danger">(*)</span></label>
                    <span class="text-danger notication mb10 block"> {{ __('message.parentNotice') }}</span>
                    <select class="form-control setupSelect2" name="parent_id" id="">
                       @foreach ($dropdown as $key => $value)
                           <option {{ old('parent_id', isset($postCatalogue->parent_id) ? $postCatalogue->parent_id : '') == $key ? 'selected' : "" }} value="{{ $key }}">{{ $value }}</option>
                       @endforeach
                    </select>
                    @error('parent_id')
                        <div class="error-message">*{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">{{ __('message.image') }}</div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                  <span class="image img-cover img-target">
                    <img src="{{ old('image', $postCatalogue->image ?? "/backend/img/not-found.png") ??  '/backend/img/not-found.png' }}" alt="">
                    <input type="hidden" name="image" value="{{ old('image', $postCatalogue->image ?? "") ?? '' }}" data-upload='Images'>
                  </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-title">{{ __('message.advance') }}</div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                  <div class="mb15">
                    <select name="publish" class="form-control mr10 setupSelect2" id="">
                        @foreach (__('message.publish') as $key => $val)
                            <option value="{{ $key }}"  {{ old('publish', isset($postCatalogue->publish) ? $postCatalogue->publish + 1 : '') == $key ? 'selected' : "" }}>{{ $val }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="mb15">
                    <select name="follow" class="form-control mr10 setupSelect2" id="">
                        @foreach (__('message.follow') as $key => $val)
                            <option value="{{ $key }}" {{ old('follow',  isset($postCatalogue->follow) ? $postCatalogue->follow + 1 : '') == $key ? 'selected' : "" }}>{{ $val }}</option>
                        @endforeach
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