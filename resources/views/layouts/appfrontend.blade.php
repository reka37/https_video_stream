<!DOCTYPE HTML>
<html>
	<head>
		<title>Fair Value</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{ asset('public/css/main.css')}}" />
		<script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
		<link rel="icon" href="{{ asset('public/favicon.ico')}}" type="image/x-icon">
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
								<?php if (Auth::check()): ?> 
									<li>
										<a href="{{ url('/lk') }}">
											Личный кабинет (<?=Auth::user()->name?>)											
										</a>
									</li>
								<?php endif; ?>	
							</ul>
						</nav>
						<nav class="main">
							<ul>
								<li class="search">
									<a class="fa-search" href="#search">Поиск</a>
									<form id="search" method="get" action="#">
										<input type="text" name="query" placeholder="Поиск" />
									</form>
								</li>
								<li class="menu">
									<a class="fa-bars" href="#menu">Меню</a>
								</li>
							</ul>
						</nav>
					</header>
					<section id="menu">				
							<section>
								<form class="search" method="get" action="#">
									<input type="text" name="query" placeholder="Поиск" />
								</form>
							</section>
							<section>
								<ul class="links">
								<?php if (Auth::check()): ?> 
									<li>
										<a href="{{ url('/lk') }}">
											<h3>Личный кабинет (<?=Auth::user()->name?>)</h3>
											<p></p>
										</a>
									</li>
								<?php endif; ?>						  
								</ul>
							</section>
							<section>	
								@if (Auth::guest())							
								<ul class="actions stacked">
									<li><a href="{{ url('/login') }}" class="button large fit">Вход</a></li>
								</ul>
								<ul class="actions stacked">
									<li><a href="{{ url('/register') }}" class="button large fit">Регистрация</a></li>
								</ul>	
								  @else
									  <ul class="actions stacked">
									<li><a href="{{ url('/logout') }}" onclick="event.preventDefault();
								 document.getElementById('logout-form').submit();" class="button large fit">Выход</a></li>
								</ul>							
								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
								</form>	
									@endif		
							</section>
					</section> 
				<div id="main">		
			   @yield('content')
					</div>
					<section id="sidebar">
							<section id="intro">
								<!--<a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>-->
								<header>
									<h2>Fair Value</h2>
									<p></p>
								</header>
							</section>
							<section>
								<div class="mini-posts">
									@foreach ($posts as $post)
										<article class="mini-post">
											<header>
												<a href="#go{{ $post->id }}">
												<time class="published" datetime="2015-10-20">{{ $post->created_at }}</time>
												<!--<a href="#" class="author"><img src="images/avatar.jpg" alt="" /></a>-->
												</a>
											</header>
											<!--<a href="single.html" class="image"><img src="images/pic04.jpg" alt="" /></a>-->
										</article>
									@endforeach
								</div>
							</section>
							<section id="footer">
								<ul class="icons">
									<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon solid fa-rss"><span class="label">RSS</span></a></li>
									<li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
								</ul>
								<p class="copyright">Fair Value</p>
							</section>
					</section>
			</div>
	   <script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>	
	<script src="{{ asset('public/js/jquery.min.js')}}"></script>
<script src="{{ asset('public/js/browser.min.js')}}"></script>
<script src="{{ asset('public/js/breakpoints.min.js')}}"></script>
<script src="{{ asset('public/js/util.js')}}"></script>	
<script src="{{ asset('public/js/main.js')}}"></script>
	</body>
</html>