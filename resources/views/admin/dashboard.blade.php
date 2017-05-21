@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-hourglass-2"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ __('Diagnosis') }}</span>
              <span class="info-box-number">{{ \App\DiagnoseHistory::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ __('Members') }}</span>
              <span class="info-box-number">{{ \App\User::count() }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
      </div>
    </div>
@endsection