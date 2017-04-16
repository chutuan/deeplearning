<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function ()
{
    Route::get('/', 'DashboardController@index');

    // Orders
    Route::get('orders/pending-pickups', 'OrdersController@pendingPickups');
    Route::get('orders/picking', 'OrdersController@picking');
    Route::get('orders/cleaneds', 'OrdersController@getCleaneds');
    Route::get('orders/pending-deliveries', 'OrdersController@pendingDeliveries');
    Route::get('orders/ready-delivery', 'OrdersController@getReadyDeliveries');
    Route::get('orders/complete', 'OrdersController@getComplete');
    Route::resource('orders', OrdersController::class);
    Route::put('orders/{id}/assign-pickup', 'OrdersController@assignPickup');
    Route::put('orders/{id}/cancel-pickup', 'OrdersController@cancelPickup');
    Route::put('orders/{id}/cleaned', 'OrdersController@cleaned');
    Route::put('orders/{id}/assign-delivery', 'OrdersController@assignDelivery');
    Route::put('orders/{id}/cancel-delivery', 'OrdersController@cancelDelivery');

    Route::resource('users', UsersController::class);
    Route::put('users/{id}/role', 'UsersController@setRole');
});
