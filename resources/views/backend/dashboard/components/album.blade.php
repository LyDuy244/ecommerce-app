<div class="ibox">
    <div class="ibox-title">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Album Ảnh</h5>
            <div class="upload-album"><a href="" class="upload-picture">Chọn Hình</a></div>
        </div>
    </div>
    <div class="ibox-content">
        @php
            $gallery = (isset($album) && count($album)) ? $album : old('album')
        @endphp
        <div class="row">
            <div class="col-lg-12">
                @if (!isset($gallery) || count($gallery)  == 0)
                    <div class="click-to-upload">
                        <div class="icon">
                            <a href="" class="upload-picture">
                                <img src="/backend/img/not-found.png" alt="">
                            </a>
                        </div>
                        <div class="small-text">Sử dụng nút chọn hình hoặc click vào đây để thêm hình ảnh</div>
                    </div>
                @endif
               
                    <div class="upload-list {{ (isset($gallery) && count($gallery)) ? '' : 'hidden' }}">
                        <div class="row">
                            <ul id="sortable" class="clear-fix data-album sortui ui-sortable">
                                @if (isset($gallery) && count($gallery) > 0)
                                    @foreach ($gallery as $item)
                                        <li class="ui-state-default">
                                        <div class="thumb">
                                            <span class="image img-scaledown">
                                                <img src="{{ $item }}" alt="{{ $item }}">
                                                <input type="hidden" name="album[]" value="{{ $item }}"  >
                                            </span>
                                            <a class="delete-image"><i class="fa fa-trash"></i></a>
                                        </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.upload-picture').forEach(element => {
        element.addEventListener('click', function(e){
            e.preventDefault();
            browseServerAlbum();
        })
    });

    document.querySelector('#sortable').addEventListener('click', function(e){
        if(e.target.matches('.delete-image')){
            e.preventDefault()
            e.target.closest(".ui-state-default").parentElement.removeChild(e.target.closest(".ui-state-default"))
           if(document.querySelectorAll('.ui-state-default').length == 0){
                document.querySelector('.click-to-upload').classList.remove("hidden")
                document.querySelector('.upload-list').classList.add("hidden")
           }
        }
    })
</script>