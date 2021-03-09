<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

/**
* Регистрация, изменение и удаление пользователей (пока это не нужно)
*
*
* @author 'Fair Value'
*/
 
class UserController extends Controller
{
	/**
	* ПОЛУЧИТЬ ВСЕХ ПОЛЬЗОВАТЕЛЕЙ
	* 
	* GET запрос на этот адрес<br>
	*  baseURL/api/users<br>
	* @param string $id id 
	* @param string $name
	* @param string $email
	* @param string $created_at
	* @return array
	*/	
	public function index()
    {	
		$users = User::where('email', '!=', 'admin@mail.ru')->get();
		return response()->json($users, 200);
    }
	
	/**
	* РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ
	* 
	* POST запрос на этот адрес<br>
	*  baseURL/api/register<br>
	* передать json параметр {"email":"почта", "name":"имя",<br>
	* "password":"пароль"}<br>
	* строка массив с данными если прошло успешно<br>
	* @param string $id id пользователя
	* @param string $email почта пользователя
	* @param string $name  имя 
	* @param string $created_at  дата создания
	* @return array
	*/	
	public function register(Request $request)
    {
		$user = User::where('email', $request->email)->first();
		 
		if (!$user) {
			$result = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password) 
			]);
		} else {
			$result = 'mail is busy';
		}
		
		return response()->json(['result' => $result], 200);
    }
	 
	/**
	* ОБНОВЛЕНИЕ ДАННЫХ ПОЛЬЗОВАТЕЛЯ
	* 
	* POST запрос на этот адрес<br>
	*  baseURL/api/updateuser<br>
	* передать json параметр {"id":"id", "name":"имя"}<br>
	* строка массив с данными если прошло успешно<br>
	* @param string $id id пользователя
	* @param string $email почта пользователя
	* @param string $name  имя 
	* @return bool
	*/	
	public function updateuser(Request $request)
    {		
		$user = User::find($request->id);
	
		if ($user) {
			$user->name = $request->name;
			$result = $user->save();
		} else {
			$result = 'user is not found';
		}
		
		return response()->json(['result' => $result], 200);
    }
	 
	/**
	* УДАЛЕНИЕ ПОЛЬЗОВАТЕЛЯ
	* 
	* POST запрос на этот адрес<br>
	*  baseURL/api/deleteuser<br>
	* передать json параметр {"id":"id"}<br>
	* строка массив с данными если прошло успешно<br>
	* @param string $id id пользователя
	* @return bool
	*/	
	public function deleteuser(Request $request)
    {		
		$user = User::where('email', '!=', 'admin@mail.ru')->where('id', '=', $request->id)->get();

		if ($user) {
			$result = (boolean)User::where('email', '!=', 'admin@mail.ru')->where('id', '=', $request->id)->delete();
		} else {
			$result = 'user is not found';
		}
		
		return response()->json(['result' => $result], 200);
    }
}
