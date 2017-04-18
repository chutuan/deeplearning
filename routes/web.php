<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function ()
{
    Route::get('/', 'DashboardController@index');

    Route::resource('diagnosis', DiagnosisController::class);
    Route::resource('symptoms', SymptomsController::class);
    Route::resource('users', UsersController::class);
    Route::put('users/{id}/role', 'UsersController@setRole');
});
