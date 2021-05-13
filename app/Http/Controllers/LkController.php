<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\User;
use App\Message;
use App\Category;

class LkController extends Controller
{
	public function Index(){	 
		$users = User::all();		
		$posts = Posts::all();	
		$categories = Category::where('isVisiable', '=', 1)->get();
		
		$url = 'https://www.it-world.ru/it-news/tech/?rss=Y'; 
		$rss = simplexml_load_file($url);
		$it_worlds = $rss->channel->item;
		$url = 'https://lenta.ru/rss/top7'; 
		$rss = simplexml_load_file($url);
		$lenta = $rss->channel->item;	
		
		return view('indexlk', [
			'it_worlds' => $it_worlds,
			'lenta' => $lenta,
			'users' => $users,
			'categories' => $categories
		]);
    }
	
	public function Video(Request $request){
		$posts = Posts::all();			
		return view('video', ['posts' => $posts,'user_id' => $request->user_id]);		
    }
	
	public function Livecommentchat(Request $request){
		$posts = Posts::find($request->user_id);
		$messages = Message::where('post_id', '=', $request->user_id)->get();	
		return view('livecommentchat', ['messages' => $messages, 'id' => $request->user_id, 'posts' => $posts]);  
    }

}
