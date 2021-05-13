<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\NewMessageAdded;
use App\User;
use App\Posts;
use App\Category;
use App\LikesPosts;
  
class ChatController extends Controller
{	
	public function Index($type = 'header'){ 
	
		$category_id = Category::where('seo_url', '=', $type)->first();
		$posts = [];
			$seo_description = null;
	if ($category_id) {
		$posts = Posts::where('category_id', '=', $category_id->id)->orderBy('id','DESC')->paginate(3);
		$seo_description = $category_id->seo_description;
		
	}
		
		$categories = Category::where('isVisiable', '=', 1)->get();
		  
		$result_count_posts = [];
		$result_count_messages = [];
		
		foreach ($posts as $result) {
			$result_count_posts[$result['id']] = LikesPosts::where('post_id', '=', $result['id'])->count();	
			$result_count_messages[$result['id']] = Message::where('post_id', '=', $result['id'])->count();	
		}	
		
		$url = 'https://www.it-world.ru/it-news/tech/?rss=Y'; 
		$rss = simplexml_load_file($url);
		$it_worlds = $rss->channel->item;
		$url = 'https://lenta.ru/rss/top7'; 
		$rss = simplexml_load_file($url);
		$lenta = $rss->channel->item;						
		
		return view('welcome', [
			'description' => $seo_description,
			'it_worlds' => $it_worlds,
			'lenta' => $lenta,
			'posts' => $posts,
			'categories' => $categories, 
			'result_count_posts' => $result_count_posts,
			'result_count_messages' => $result_count_messages
		]);
    }
	
	public function Livecomments($type){ 
	
		$post = Posts::where('seo_url', '=', $type)->first();

		$categories = Category::where('isVisiable', '=', 1)->get();
		$posts = Posts::where('category_id', '=', $post->id)->orderBy('id','DESC')->paginate(3);
		$messages = Message::where('post_id', '=', $post->id)->get();	
		
		$url = 'https://www.it-world.ru/it-news/tech/?rss=Y'; 
		$rss = simplexml_load_file($url);
		$it_worlds = $rss->channel->item;
		$url = 'https://lenta.ru/rss/top7'; 
		$rss = simplexml_load_file($url);
		$lenta = $rss->channel->item;						
		
		return view('livecomments', [
			'description' => $post->name,
			'it_worlds' => $it_worlds,
			'lenta' => $lenta,
			'messages' => $messages,
			'id' => $post->id, 
			'posts' => $posts,
			'post' => $post, 
			'categories' => $categories	
		]);
    }
	
    public function Chat(){
		$messages = Message::all();
		return view('chat.index', ['messages' => $messages]);
    }
	
	 public function Chatone($id){
		$messages = Message::where('autor', '=', $id)->get();	
		return view('chat.index', ['messages' => $messages, 'id' => $id]);
    }
	
	public function Activechat(){
		$users = User::all();
		return view('chat.user', ['users' => $users]);
    }
	
	public function Posts(){
		$posts = Posts::all();
		$categories = Category::where('isVisiable', '=', 1)->get();	
		return view('chat.posts', ['posts' => $posts, 'categories' => $categories]);
    }
	
	public function Addpost(Request $request){
			
		$filename = null;
		
		if($request->isMethod('post')){

			if($request->hasFile('image')) {
				
				$file = $request->file('image');

				$filename = str_random(20) . '.' . $file->getClientOriginalExtension();

				$file->move(public_path() . '/image/posts/',$filename);
			}

			Posts::create([
				'name' => $request->name,
				'isComments' => isset($request->isComments) ? 1 : 0,
				'category_id' => $request->category_id,
				'data' => $request->body,
				'image' => $filename
			]);
			return response()->json(array('msg'=> 'True'), 200);
		}
    }
	
	public function Editpost(Request $request){	

		$post = Posts::find($request->id);	

		if($request->isMethod('post')){
				$filename = null;
	
			if($request->hasFile('image_')) {
				$file = $request->file('image_');
					
				if ($file->getClientOriginalExtension()) {
				$filename = str_random(20) . '.' . $file->getClientOriginalExtension();

				$file->move(public_path() . '/image/posts/',$filename);
								
				$file_for_delete = $post->image;
				
					if (isset($file_for_delete)) {
						@unlink(public_path() . '/image/posts/' . $file_for_delete);
					}		
				}				
			}

			$post->data = $request->body;
			$post->isComments = 1;	
			$post->category_id = $request->category_id;
			$post->name = $request->name;

			if (isset($filename)) {
					$post->image = $filename;
				}
			$post->save();

			return response()->json(array('msg'=> 'True'), 200);
		}		
    }
	
	public function Postupdate($id){
		$post = Posts::where('id', '=', $id)->get();	
		$categories = Category::where('isVisiable', '=', 1)->get();	
		return view('chat.postupdate', ['post' => $post, 'id' => $id, 'categories' => $categories]);
	}
	
	public function Postchat($id){					
		$messages = Message::where('post_id', '=', $id)->get();	
		return view('chat.index', ['messages' => $messages, 'id' => $id]);	
	}
	
	public function Message(Request $request){
		 
		if (!$request->is_admin) {
	
			$content = htmlspecialchars(strip_tags(html_entity_decode($request->content)));
	
			$txt = 'Новое <a href="https://irek.ml/postchat/'.$request->post_id.'">сообщение:</a>';
			$txt .= "<b>".$content."</b>";	
			$token = '965577145:AAHYVCoZ0LYHAblaRBEG9v4W85NRAEVxCY4';	
			//$token = '1622061689:AAFVdQmhE44YA0YEYNUfidKeTeDkyKTD9po';	
			//	https://api.telegram.org/bot1622061689:AAFVdQmhE44YA0YEYNUfidKeTeDkyKTD9po/getUpdated
			//https://api.telegram.org/bot1622061689:AAFVdQmhE44YA0YEYNUfidKeTeDkyKTD9po/setWebhook?url=https://irek.ml
			$chat_id = '-572704974';
	
			$sendToTelegram = @fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text=".urlencode($txt),"r");	
		}	
			
		$message = Message::create($request->all());
		event (
				new NewMessageAdded($message)
		);
    }
	
	public function Postdelete(Request $request){
		$posts = Posts::find($request->id)->delete();
		return response()->json(array('msg'=> $posts), 200);
    }
	
	public function Messagedelete(Request $request){
		$posts = Message::find($request->id)->delete();
		return response()->json(array('msg'=> $posts), 200);
    }
	

	public function Messageupdate(Request $request){
		$message = Message::find($request->id);	

		if($request->isMethod('post')){
			$message->content = $request->content;	
			$message->save();		
		}	
		return view('chat.messageupdate', ['message' => $message, 'id' => $request->id]);
    }
}
