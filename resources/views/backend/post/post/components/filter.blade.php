<form action="{{ route('post.index') }}">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" class="form-control input-sm perpage filter mr10" id="">
                        @for ($i = 20; $i <= 100; $i+=20)
                            <option value="{{ $i }}"  {{ request()->perpage == $i ? 'selected' : "" }}>{{ $i }} bản ghi</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <select name="publish" class="form-control mr10" id="">
                        <option value="0" selected>Chọn tình trạng</option>
                        <option value="2" {{ request()->publish == 2 ? 'selected' : "" }}>Publish</option>
                        <option value="1" {{ request()->publish == 1 ? 'selected' : "" }}>UnPublish</option>
                    </select>
                    <select name="post_catalogue_id" class="form-control mr10" id="">
                        @foreach ($dropdown as $key => $val)
                            <option value="{{ $key }}" {{ (request('post_catalogue_id') ?: old('post_catalogue_id')) == $key ? 'selected' : '' }} >{{ $val }}</option>
                        @endforeach
                    </select>
                    <div class="uk-search uk-flex uk-flex-middle mr10">
                       <div class="input-group">
                            <input 
                                type="text" 
                                name="kw" 
                                value="{{ request()->kw }}" 
                                placeholder="Nhập từ khóa muốn tìm kiếm"
                                class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary mb-0 btn-sm">Tìm kiếm</button>
                            </span>
                       </div>
                    </div>
                    <a href="{{ route('post.create') }}" class="btn btn-danger mr5"><i class="fa fa-plus"></i> Thêm mới bài viết</a>
                </div>
            </div>
        </div>
    </div>
</form>