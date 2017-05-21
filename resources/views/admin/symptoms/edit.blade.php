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
                  <div class="row" style="margin-bottom: 10px;">
                      <div class="col-md-9">
                        <input type="text" name="symptoms[]" class="form-control"
                          placeholder="Symptom"/>
                      </div>
                      <div class="col-md-3">
                        <input type="text" name="values[]" class="form-control"
                          placeholder="Value"/>
                      </div>
                    </div>
                  @foreach($symptom->symptoms()->orderBy('sort', 'ASC')->get() as $symptom)
                    <div class="row" style="margin-bottom: 10px;">
                      <div class="col-md-9">
                        <input type="text" name="symptoms[]" class="form-control"
                          value="{{ $symptom->content }}"/>
                      </div>
                      <div class="col-md-3">
                        <input type="text" name="values[]" class="form-control"
                          value="{{ $symptom->sort }}" placeholder="Value"/>
                      </div>
                    </div>
                  @endforeach
                </div>
                <button type="submit" class="btn btn-success">Update</button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
