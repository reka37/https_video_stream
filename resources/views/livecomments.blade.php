@extends('layouts.appfrontend')
@section('content')

	<article class="post" id="go{{ $post->id }}">
				<header>
					<div class="meta" style="width:200px">
					<h1>{{ $post->name }}</h1>
						<time class="published" datetime="2015-11-01">{{ $post->created_at }}</time>
						<!--<a href="#" class="author"><span class="name">Администратор</span><img src="/public/image/photo3.jpg" alt="" /></a>-->								
					</div>
					<div style="text-align: center;">
						<?php if (isset($post->image)):?>
						<img style="width:150px;height:150px;object-fit:contain;margin-top:30%" src="<?='/public/image/posts/'.$post->image?>">
						<?php endif; ?>
					</div>		
				</header>
				<div style="display:block; overflow-x: auto; max-width:750px">
				<p style="width:200px;">{!! $post->data !!}</p>
				</div>

			</article>






			@foreach ($messages as $message)
				<span class="chat">
				<article class="post">
				
						<div class="title">
						{{ $message->content }}
						</div>
						<div class="meta">
							<time class="published" datetime="2015-11-01">{{ $message->created_at}}</time>
							<a href="#" class="author"><span class="name">
							<?php if ($message->is_admin) echo 'Администратор'; else echo 'Пользователь';?>
							</span>
							<img src="<?php if ($message->is_admin) echo '/public/image/photo3.jpg'; else echo '/public/image/222.jpg';?>" alt="" />
							</a>
						</div>								
				</article></span>
				<span></span>						
			@endforeach
		  
<article class="post">								
	<p>
		@if($post->isComments)
				<form onsubmit="t();return false;" action="/chat/message" method="POST">
					<input type="hidden" name="autor" id="autor" value="{{ $id }}"><br>
					<input type="hidden" name="post_id" id="post_id" value="{{ $id }}"><br>
					{{ csrf_field() }}
					<textarea name="content" id="content" style="width:100%;height:200px"></textarea><br>
					<input autofocus type="submit" id="sub" class="save-data" value="Написать в чат">
				</form>
		@else
			<br>Комментарии запрещены			   
		@endif
	</p>				
</article>
<script>
	var id = {{ $id }};

	var socket = io(':5016'),
	 channel = 'chat:message';	  
  
	function appendChat(data, id){

		if (!data.is_admin) {
			$('#signal' + data.autor).css("background", "green");
			$('#balls').css("display", "block");
		}	 

		if (data.autor == id) {

			var date = new Date();

			var str_date = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + ' ' +date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

			var dark = 'Пользователь';
			var time_ = 'time-right';
			var right_ = '';
			var photo = '/public/image/222.jpg';
			if (data.is_admin) {
			dark = 'Администратор';
			time_= 'time-left';
			var right_ = 'class="right"';
			var photo = '/public/image/photo3.jpg';
			}	

			$('.chat').append(

				$('<span></span>').html(

				'<span>	<article class="post">'+

						'<div class="title">'+data.content +'</div>'+
						'<div class="meta">'+
							'<time class="published" datetime="2015-11-01">'+str_date+'</time>'+
							'<a href="#" class="author"><span class="name">'+dark+'</span>'+
							'<img src="'+photo+'" alt="" />'+
							'</a></div></article></span>')
			); 
		}
	};
  
	var t =  function (){  
		var content = $("#content").val();
		var autor = $("#autor").val();
		var post_id = $("#post_id").val();
		var _token   = $('meta[name="csrf-token"]').attr('content');

		$.ajax({
			type:'POST',
			url:'/chat/message',
			data:{_token: _token, autor:autor, post_id:post_id, content:content, is_admin:0},
			success:function(data){
			}
		});
	};

	socket.on("chat:message", function(data){
		appendChat(data, id);
		$('#content').val('');
	});

</script>
@endsection	