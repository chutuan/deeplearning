@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Users') }}</h3>
            </div>
            <div class="box-body">
                <form method="GET" role="form">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Role</label>
                            <select class="form-control" name="role">
                                <option value="">{{ __('All') }}</option>
                                @foreach(\App\User::getRoles() as $key => $role)
                                <option value="{{ $key }}" {{ "$key" === $options['role'] ? "selected" : ""}} >
                                    {{ $role }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label style="display: block;">Action</label>
                            <button class="btn btn-success">Search</button>
                        </div>
                    </div>
                </form>
                @if(count($users))
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->fullName() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="row">
                                    <form action="/admin/users/{{ $user->id }}/role" method="POST">
                                        <input name="_method" type="hidden" value="PUT">
                                        {{ csrf_field() }}
                                        <div class="form-group col-md-6">
                                            <select name="role" class="form-control">
                                                @foreach(\App\User::getRoles() as $key => $role)
                                                    <option value="{{ $key }}" {{ $key === $user->role ? "selected" : ""}} >
                                                        {{ $role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn btn-success btn-md">{{ __('Set Role') }}</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-danger">
                        {{ __('Not found any users') }}
                    </div>
                @endif
            </div>
            
            {{-- <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div> --}}
        </div>
    </div>
</div>
@endsection
