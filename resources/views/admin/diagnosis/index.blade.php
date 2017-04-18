@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Users') }}</h3>
            </div>
            <div class="box-body">
                @if(count($diagnosis))
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Symptoms</th>
                            <th>Result</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($diagnosis as $index => $diagnose)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $diagnose->symptoms }}</td>
                            <td>{{ $diagnose->result }}</td>
                            <td>
                                <form action="/admin/diagnosis/{{ $diagnose->id }}" method="POST"
                                    style="display:inline-block;">
                                    <input name="_method" type="hidden" value="DELETE">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-md btn-sm">{{ __('Destroy') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-danger">
                        {{ __('Not found any diagnosis') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
