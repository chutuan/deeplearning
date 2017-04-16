@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-hourglass-2"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ __('Awaiting pick up confirmation') }}</span>
              <span class="info-box-number">{{ $pendingOrders }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-send"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ __('Pending Delivery') }}</span>
              <span class="info-box-number">{{ $deliveryOrders }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">41,410</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ __('New Members Today') }}</span>
              <span class="info-box-number">{{ $newMembers }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
      </div>
      <div class="row">
        <div class="col-md-6">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Orders</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>{{ __('Order By') }}</th>
                    <th>{{ __('Status') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($orders as $order)
                  <tr>
                    <td><a href="pages/examples/invoice.html">{{ $loop->index + 1}}</a></td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        <a href="/admin/users/{{ $order->owner->id}}">
                            {{ $order->owner->fullName() }}
                        </a>
                    </td>
                    <td>
                        @if($order->status === \App\Order::STATUS_NEW)
                        <span class="label label-warning">{{ $order->status }}</span>
                        @else
                            <span class="label label-info">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="/admin/orders" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <div class="col-md-6">
          </div>
          </div>
    </div>
@endsection