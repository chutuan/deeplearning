@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Create Diagnosis') }}</h3>
            </div>
            <div class="box-body">
              <form method="POST" action="/admin/diagnosis">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <label>Symptoms</label>
                    <input type="text" name="symptoms" class="form-control">
                    @if($errors->has('symptoms'))
                    <span class="help-block" style="color: #dd4b39;">
                      {{ $errors->first('symptoms') }}
                    </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label>Result</label>
                    <input type="text" name="result" class="form-control">
                    @if($errors->has('result'))
                    <span class="help-block" style="color: #dd4b39;">
                      {{ $errors->first('result') }}
                    </span>
                    @endif
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
