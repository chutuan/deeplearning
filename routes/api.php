<?php

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1'], function()
{
    // Users
    Route::get('users/me', 'UsersController@me')->middleware('auth');
    Route::post('users', 'UsersController@store');
    Route::get('users', 'UsersController@index');
    Route::put('users/change-password', 'UsersController@changePassword')->middleware('auth');
    Route::post('users/change-avatar', 'UsersController@changeAvatar')->middleware('auth');
    Route::put('users/verify', 'UsersController@verify')->middleware('auth');

    // Order
    Route::get('orders/pickups', 'OrdersController@getPickUps')->middleware('auth', 'api.driver');
    Route::get('orders/deliveries', 'OrdersController@getDeliveries')->middleware('auth', 'api.driver');
    Route::resource('orders', OrdersController::class, ['middleware' => ['auth']]);
    Route::put('orders/{id}/picked', 'OrdersController@pickedUp')->middleware('auth', 'api.driver');
    Route::put('orders/{id}/delivered', 'OrdersController@delivered')->middleware('auth', 'api.driver');

    // Review
    Route::resource('reviews', ReviewsController::class, ['middleware' => ['auth']]);

    // Auths
    Route::group(['prefix' => 'auths'], function(){
        Route::post('login', 'AuthsController@login');
        Route::post('facebook', 'AuthsController@facebook');
        Route::post('gmail', 'AuthsController@gmail');
        Route::post('logout', 'AuthsController@logout')->middleware('auth');
    });
});