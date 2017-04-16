@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Pending Pickups') }}</h3>
            </div>
            <div class="box-body">
                @if(count($orders))
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Order By</th>
                            <th>Pickup At</th>
                            <th>Weight</th>
                            <th>Action</th>
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
                            <td>{{ $order->pickup_at->format('m/d/Y H:i') }}</td>
                            <td>{{ number_format($order->weight, 2) }} kg</td>
                            <td>
                                <div class="row">
                                    @if($order->status == \App\Order::STATUS_NEW)
                                    <form action="/admin/orders/{{ $order->id }}/assign-pickup" method="POST">
                                    <input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                    <div class="form-group col-md-6">
                                        <select name="employee_id" class="form-control">
                                            <option value="">Select Employee</option>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}" 
                                                    {{ $order->picker() && $order->picker()->user_id == $driver->id ? "selected" : "" }}>
                                                    {{ $driver->fullName() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-success btn-md">Assign Pickup</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-danger">
                        Not found any orders
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