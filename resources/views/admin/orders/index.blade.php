@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Orders') }}</h3>
            </div>
            <div class="box-body">
                <form method="GET" role="form">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="New">New</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label style="display: block;">Action</label>
                            <button class="btn btn-success">Search</button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Order By</th>
                            <th>Order At</th>
                            <th>Pickup At</th>
                            <th>Weight</th>
                            <th>Unit Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->address }}</td>
                            <td>
                                <a href="/admin/users/{{ $order->owner->id }}">
                                    {{ $order->owner->fullName() }}
                                </a>
                            </td>
                            <td>{{ $order->created_at->format('m/d/Y H:i') }}</td>
                            <td>{{ $order->pickup_at->format('m/d/Y H:i') }}</td>
                            <td>{{ number_format($order->weight, 2) }} kg</td>
                            <td>{{ number_format($order->unit_price, 2) }} $</td>
                            <td>{{ $order->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
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