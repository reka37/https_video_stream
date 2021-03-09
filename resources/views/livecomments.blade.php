<!DOCTYPE HTML>
<html>
	<head>
		<title>Fair Value</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{ asset('public/css/main.css')}}" />
		<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>
		<script
		  src="https://code.jquery.com/jquery-3.5.1.js"
		  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
		  crossorigin="anonymous"></script>
	</head>
	<body class="is-preload">
			<div id="wrapper">		
					<header id="header">
						<h1><a href="/">Fair Value</a></h1>
						<nav class="links">
							<ul>
								<li><a href="#"></a></li>
								<li><a href="{{ url('/') }}">Назад к ленте</a></li>
							</ul>
						</nav>
						<nav class="main">
							<ul>
								<li class="search">
									<a class="fa-search" href="#search">Search</a>
									<form id="search" method="get" action="#">
										<input type="text" name="query" placeholder="Search" />
									</form>
								</li>
								<li class="menu">
									<a class="fa-bars" href="#menu">Menu</a>
								</li>
							</ul>
						</nav>
					</header>
					<section id="menu">				
							<section>
								<form class="search" method="get" action="#">
									<input type="text" name="query" placeholder="Search" />
								</form>
							</section>
							<section>
								<ul class="links">
									<li>
										<a href="#">
											<h3>1</h3>
											<p>2</p>
										</a>
									</li>
							
								</ul>
							</section>
							<section>
								<ul class="actions stacked">
									<li><a href="#" class="button large fit">Log In</a></li>
								</ul>
							</section>
					</section>
					<div id="main" class="chat">
						@foreach ($messages as $message)
							<span>
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
					</div>
				</div>
			</div>		
			<article class="post">								
				<p>
					@if($posts->isComments)
							<form onsubmit="t();return false;" action="/chat/message" method="POST">
								<input type="hidden" name="autor" id="autor" value="{{ $id }}"><br>
								<input type="hidden" name="post_id" id="post_id" value="{{ $id }}"><br>
								{{ csrf_field() }}
								<textarea name="content" id="content" style="width:100%;height:200px"></textarea>
								<input autofocus type="submit" id="sub" class="save-data" value="Написать в чат">
							</form>
					@else
						<br>Комментарии запрещены			   
					@endif
				</p>				
			</article>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>	 
           <script>
				var id = {{ $id }};

				var socket = io(':6050'),
				channel = 'chat:message';

				// socket.on('connect', function(){
					// socket.emit('subscribe', channel);
				// });

				// socket.on('error', function(error){
					// console.warn('Error', error);
				// });

				// socket.on('message', function(message){
					// console.info(message);
				// });
			  
			  
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
				});
              
			</script>
			<script src="{{ asset('public/js/jquery.min.js')}}"></script>
			<script src="{{ asset('public/js/browser.min.js')}}"></script>
			<script src="{{ asset('public/js/breakpoints.min.js')}}"></script>
			<script src="{{ asset('public/js/util.js')}}"></script>	
			<script src="{{ asset('public/js/main.js')}}"></script>
</body>
</html>
 	
