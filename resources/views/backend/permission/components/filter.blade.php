<form action="{{ route('permission.index') }}">
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
                    <a href="{{ route('permission.create') }}" class="btn btn-danger mr5"><i class="fa fa-plus"></i> Thêm mới quyền</a>
                </div>
            </div>
        </div>
    </div>
</form>