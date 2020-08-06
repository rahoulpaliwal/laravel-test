<?php

/*
 |--------------------------------------------------------------------------
 | API Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register API routes for your application. These
 | routes are loaded by the RouteServiceProvider within a group which
 | is assigned the "api" middleware group. Enjoy building your API!
 |
 */

// Route::post('user', 'API\UserController@register');

Route::resource('users', 'UserController');

/* Route::middleware('auth:api')->group( function () {
    Route::resource('users', 'API\UsersController');
}); */