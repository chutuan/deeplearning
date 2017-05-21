@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Create Symptoms') }}</h3>
            </div>
            <div class="box-body">
              <form method="POST" action="/admin/symptoms">
                {{ csrf_field() }}
                <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label >Content</label>
                      <input type="text" name="content" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
