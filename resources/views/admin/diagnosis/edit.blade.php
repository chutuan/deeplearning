@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Edit Symptoms') }}</h3>
            </div>
            <div class="box-body">
              <form method="POST" action="/admin/symptoms/{{ $symptom->id }}">
                <input type="hidden" name="_method" value="PUT">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Section</label>
                  <input type="text" name="content" class="form-control"
                    value="{{ $symptom->content }}">
                </div>
                <div class="form-group">
                  <label>Symptoms:</label>
                  <input type="text" name="symptoms[]" class="form-control"
                    style="margin: 5px 0px;"/>
                  @foreach($symptom->symptoms()->orderBy('sort', 'ASC')->get() as $symptom)
                    <input type="text" name="symptoms[]" class="form-control"
                      value="{{ $symptom->content }}" style="margin: 5px 0px;"/>
                  @endforeach
                </div>
                <button type="submit" class="btn btn-success">Update</button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
