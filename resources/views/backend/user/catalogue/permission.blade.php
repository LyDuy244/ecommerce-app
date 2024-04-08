@extends('backend.dashboard.layout')
@section('title')
    {{ $title }}
@endsection
@section('css')
@endsection

@section('content')
    <x-dashboard.heading heading="Phân quyền nhóm thành viên"/>
    <form action="{{ route('user.catalogue.updatePermission') }}" method="POST">
        @csrf
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title"><h5>Cấp quyền</h5></div>
                        <div class="ibox-content">
                            <table class="table table-striped table-bordered">
                              <tr>
                                <th></th>
                                @foreach ($userCatalogues as $userCatalogue)
                                    <th>{{ $userCatalogue->name }}</th>
                                @endforeach
                              </tr>
                              @foreach ($permissions as $permission)
                              <tr>
                                    <td><a href="" class="uk-flex uk-flex-middle uk-flex-space-between">{{ $permission->name }} <span style="color: red">{{ $permission->canonical }}</span></a></td>
                                    @foreach ($userCatalogues as $userCatalogue)
                                        <th><input {{ collect($userCatalogue->permissions)->contains('id', $permission->id) ? 'checked' : '' }} type="checkbox" name="permission[{{ $userCatalogue->id }}][]" class="form-control" value="{{ $permission->id }}" ></th>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="text-right">
                <button class="btn btn-primary mb15" type="submit" name="send" value="send">Lưu lại</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
@endsection