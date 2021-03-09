<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/users', 'Api\UserController@index');

Route::get('/getexel', 'Api\ExelController@index');

Route::get('/gettradings/{status}', 'Api\ExelController@gettradings');

Route::post('/register', 'Api\UserController@register'); 

Route::post('/updateuser', 'Api\UserController@updateuser'); 

Route::post('/deleteuser', 'Api\UserController@deleteuser'); 

Route::post('/sendmessage', 'Api\MessageController@sendmessage');

Route::get('/getallposts', 'Api\MessageController@getallposts'); 

Route::post('/getonepost', 'Api\MessageController@getonepost');

