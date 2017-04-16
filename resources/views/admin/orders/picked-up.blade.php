@extends('adminlte::layouts.app')

@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ __('Picking') }}</h3>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Order By</th>
                            <th>Picked At</th>
                            <th>Pickup By</th>
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
                            <td>{{ $order->picked_at->format('m/d/Y H:i') }}</td>
                            <td>
                                @php $user = $order->picker()->user()->first() @endphp
                                <a href="/admin/users/{{ $user->id }}">
                                    {{ $user->fullName() }}
                                </a>
                                </td>
                            <td>{{ number_format($order->weight, 2) }} kg</td>
                            <td>
                                @if($order->status == \App\Order::STATUS_PICKEDUP)
                                <form action="/admin/orders/{{ $order->id }}/cleaned" method="POST">
                                    <input name="_method" type="hidden" value="PUT">
                                    {{ csrf_field() }}
                                    <button class="btn btn-success btn-sm">{{ __('Clean') }}</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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