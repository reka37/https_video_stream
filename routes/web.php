<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/logout', function(){
	\Auth::logout();
	 // $request->session()->invalidate();

    // $request->session()->regenerateToken();

    return redirect('/');
});


Route::get('/categories', 'CategoryController@index'); 

Route::post('/addcategory', 'CategoryController@addcategory'); 

Route::get('/posts', 'ChatController@posts'); 

Route::post('/posts/setclick', 'PostController@setclick'); 
  
Route::get('/home', 'HomeController@index');

Route::get('/lk', 'LkController@index');

Route::get('/video', 'LkController@video');
Route::get('/livecommentchat', 'LkController@livecommentchat');


Route::get('/', 'ChatController@index');

Route::get('/{type}', 'ChatController@index');

Route::get('/livecomments/{type}', 'ChatController@livecomments');

Route::get('/test-auth', function(){
	\Auth::login(\App\User::find(1));
	return redirect('/chat');
});

Route::group(['prefix' => 'ws'], function(){
	
	Route::get('check-auth', function(){
		return response()->json([
		'auth' => \Auth::check()
		]);
	}); 
	
	Route::get('check-sub/{channel}', function($channel){
		return response()->json([
		'can' => \Auth::check() && \Auth::user()->name == 'igor'
		]);
	}); 	
});
 
Route::post('/posts/edit', 'ChatController@editpost');
 
Route::get('/chat', 'ChatController@chat');

Route::post('/posts/add', 'ChatController@addpost');

Route::get('/postupdate/{id}', 'ChatController@postupdate');

Route::post('/posts/delete', 'ChatController@postdelete');

Route::get('/chat/{id}', 'ChatController@chatone');

Route::get('/postchat/{id}', 'ChatController@postchat');

Route::get('/activechat', 'ChatController@activechat');

Route::post('/chat/message', 'ChatController@message');

Route::post('/message/delete', 'ChatController@messagedelete');

Route::get('/messageupdate/{id}', 'ChatController@messageupdate');  

Route::post('/messageupdate/{id}', 'ChatController@messageupdate');

Route::get('/tradingupdate/{id}', 'CustomController@tradingupdate');

Route::post('/tradingupdate/{id}', 'CustomController@tradingupdate');
  
Route::post('/customdata', 'CustomController@index');

Route::post('/customdata/getfile', 'CustomController@getfile');

Route::get('/getfileshow', 'CustomController@getfileshow');

Route::get('/trading', 'CustomController@trading');

Route::get('/trading/{close}', 'CustomController@trading');

Route::post('/trading/delete', 'CustomController@tradingdelete');

Route::post('/trading', 'CustomController@trading');

