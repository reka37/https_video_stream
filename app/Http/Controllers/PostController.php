<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\LikesPosts;

class PostController extends Controller
{
    public function Setclick(Request $request){
		
		if (Auth::check()) {
 
			$user_id = Auth::user()->id;
		}

		$likes_posts = LikesPosts::where([['user_id', '=', $user_id], ['post_id', '=', $request->post_id]])->first();	
		if ($likes_posts) {

			$likes_posts->delete();
		} else {
			$post = LikesPosts::create([
			'user_id' => $user_id,
			'post_id' => $request->post_id
			]);
		}
		$count_likes_posts = LikesPosts::where('post_id', '=', $request->post_id)->count();	

		return response()->json(array('count_likes_posts'=> $count_likes_posts), 200);
	}
}
