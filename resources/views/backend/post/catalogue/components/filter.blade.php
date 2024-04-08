<form action="{{ route('post.catalogue.index') }}">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" class="form-control input-sm perpage filter mr10" id="">
                        @for ($i = 20; $i <= 100; $i+=20)
                            <option value="{{ $i }}"  {{ request()->perpage == $i ? 'selected' : "" }}>{{ $i }} {{ __('message.perpage') }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <select name="publish" class="form-control mr10" id="">
                        @foreach (__('message.publish') as $key => $val)
                            <option value="{{ $key }}" {{ request()->publish == $key ? 'selected' : "" }}>{{ $val }}</option>
                        @endforeach
        
                    </select>
                    <div class="uk-search uk-flex uk-flex-middle mr10">
                       <div class="input-group">
                            <input 
                                type="text" 
                                name="kw" 
                                value="{{ request()->kw }}" 
                                placeholder="{{ __('message.searchInput') }}"
                                class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary mb-0 btn-sm">{{ __('message.search') }}</button>
                            </span>
                       </div>
                    </div>
                    <a href="{{ route('post.catalogue.create') }}" class="btn btn-danger mr5"><i class="fa fa-plus"></i>{{ __('message.postCatalogue.create.title') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>