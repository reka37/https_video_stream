<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\User;
use App\Message;

class LkController extends Controller
{
	public function Index(){	
		$users = User::all();		
		$posts = Posts::all();	
		return view('indexlk', ['posts' => $posts, 'users' => $users]);
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
