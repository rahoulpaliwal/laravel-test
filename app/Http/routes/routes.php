<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'UserController@index');

Route::post('/users', 'UserController@store');
        
Route::get('/users/{id?}', 'UserController@edit');
    
Route::put('/users/{id?}', 'UserController@update');
    
Route::delete('/users/{id?}', 'UserController@destroy');


//Route::resource('/','UserController');

Route::get('downloadExcel/{type}', 'UserController@downloadExcel');
Route::post('importExcel', 'UserController@importExcel');


Route::post('/api/users', 'API\UserController@getUser');
