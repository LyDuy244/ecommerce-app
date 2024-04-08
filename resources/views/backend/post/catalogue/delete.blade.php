@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection

@section('content')
    <x-dashboard.heading heading="Thêm thành viên"/>
    <form action="{{ route('post.catalogue.destroy', $postCatalogue->id) }}" method="POST">
        @csrf
        @method('Delete')
        <input type="text" value="{{ $postCatalogue->id }}" name='catalogue' hidden>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">
                            {{ __('message.generalInfo') }}
                        </div>
                        <div class="panel-description">
                            <p> {{ __('message.generalTitle') }} <span class="text-danger">{{ $postCatalogue->name }}</span></p>
                            <p>{{ __('message.generalDescription') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">{{ __('message.tableName') }}<span class="text-danger">(*)</span></label>
                                        
                                        <input 
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            placeholder=""
                                            readonly
                                            autocomplete="off"
                                            value="{{ old('name', $postCatalogue->name ?? '') }}"
                                        >

                                        @error('name')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror

                                        @error('catalogue')
                                            <div class="error-message">*{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-danger mb15" type="submit" name="send" value="send">{{ __('message.deleteButton') }}</button>
            </div>
        </div>
    </form>
@endsection
