<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use App\Posts;
use App\Events\NewMessageAdded;
 
/**
* Сообщение в чат по определенному посту, получить список постов
*
*
* @author 'Fair Value'
*/

class MessageController extends Controller
{
	/**
	* НАПИСАТЬ СООБЩЕНИЕ В ЧАТ (при вызове метода сообщение появляется в живом режиме)
	* 
	* POST запрос на этот адрес<br>
	*  baseURL/api/sendmessage<br>
	* передать json параметр {"content":"тело сообщения", "is_admin":"0 или 1 ",<br>
	* "post_id":"id поста ", "autor":"id поста(не опечатка)"}<br>
	* строка массив с данными если прошло успешно<br>
	* @param string $content 
	* @param string $is_admin 
	* @param string $post_id 
	* @param string $autor  
	* @return array
	*/	
	public function Sendmessage(Request $request)
    {		
		$message = Message::create($request->all());
		
		event (
				new NewMessageAdded($message)
		);
		
		return response()->json(['result' => $message], 200);
    }
	  
	/**
	* ПОЛУЧИТЬ СПИСОК ПОСТОВ
	* 
	* GET запрос на этот адрес<br>
	*  baseURL/api/getallposts<br>
	* строка массив с данными если прошло успешно<br>
	* @return array
	*/	
	public function Getallposts()
    {		
		$posts = Posts::all();
		
		return response()->json(['result' => $posts], 200);
    }
	
	/**
	* ПОЛУЧИТЬ ОДИН ПОСТ
	* 
	* POST запрос на этот адрес<br>
	*  baseURL/api/getonepost<br>
	* передать json параметр {"id":"id"}<br>
	* строка массив с данными если прошло успешно<br>
	* @param string $id id 
	* @return bool
	*/	
	public function Getonepost(Request $request)
    {		
		$post = Posts::find($request->id);
		
		return response()->json(['result' => $post], 200);
    }

}
