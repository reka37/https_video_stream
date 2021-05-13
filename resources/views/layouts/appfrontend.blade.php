<!DOCTYPE HTML>
<html>
	<head>
		<title>IT Recommend</title>
		<meta charset="utf-8" />  
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="google-site-verification" content="ALTRNVaR38G1MJ2YumvHitPHb_jH0jZhTRoeOjYauzo" />  
		<meta name="yandex-verification" content="d0c183317d07aa75" />
		 <meta name="description" content="<?php if (isset($description)) echo $description; else echo 'Рекомендации по программированию'; ?>"> 
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="apple-touch-icon" href="{{ asset('public/favicon.ico')}}" type="image/x-icon">
		<link rel="icon" href="{{ asset('public/favicon.ico')}}" type="image/x-icon">
		<link rel="stylesheet" href="{{ asset('public/css/main.css')}}" />
		<link rel="stylesheet" href="{{ asset('public/css/pagination.css')}}" />		
		<script defer src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>
		<script defer
		  src="https://code.jquery.com/jquery-3.5.1.js"
		  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
		  crossorigin="anonymous"></script>
		  <script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(77575159, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/77575159" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
		</head>
		<body class="is-preload">
			<div id="wrapper">		
					<header id="header">
						<h1><a href="/"><span style="font-weight:bold;color:red">I</span>T <span style="font-weight:bold;color:red">Rec</span>ommend</a></h1>
						<nav class="links">
							<ul>	
								<?foreach ($categories as $category):?>
									<li>
										<a href="{{ url('/',['type' => $category->seo_url]) }}">
											<?=$category->name?>											
										</a>
									</li>								
								<?endforeach?>	
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
									<input type="text" name="query" placeholder="Search" />
								</form>
							</section>
							<section>
								<ul class="links">
									<?foreach ($categories as $category):?>
										<li>
											<a href="{{ url('/',['type' => $category->seo_url]) }}">
												<?=$category->name?>											
											</a>
										</li>								
									<?endforeach?>	
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
									<header>
									<h2><span style="font-weight:bold;color:red">I</span>T <span style="font-weight:bold;color:red">Rec</span>ommend</h2>
										<a href="#" class="logo2"><img src="{{ asset('public/image/log.png')}}" alt="" /></a> <br>
									<span>Онлайн платформа, где есть помощь и рекомендации программистам</span>
									<hr><hr>
									<h3>Новости IT</h3>
										<div style="display:block;width:300px;height:400px;overflow:auto;padding:5px;box-shadow: 0 0 10px rgba(0,0,0,0.5);">
											<?php foreach ($it_worlds as $item):?>
												<div>
												<div class="blog_post_descr">
												<div class="blog_post_date"><?=$item->pubDate?></div>
												<a class="blog_post_title" href="<?=$item->link?>" ><?=$item->title?></a>
												(Источник <a href="<?=$item->link?>" >https://it-world.ru</a>)
												<div class="blog_post_content"><?=$item->description?></div>
												</div>
												</div><hr>
											<?php endforeach ?> 
										</div>	
									<hr><hr>
									<h3>Новости мира</h3>
									<div style="display:block;width:300px;height:400px;overflow:auto">
									<?php foreach ($lenta as $item):?>
										<div>
										<div class="blog_post_img">
											<img style="object-fit:contain;width:300px" src="<?=$item->enclosure['url']?>" alt="" />
											<a class="zoom" href="about.php?id=%s" ></a>
										</div>
										<div class="blog_post_descr">
											<div class="blog_post_date"><?=$item->pubDate?></div>
											<a class="blog_post_title" href="<?=$item->link?>" ><?=$item->title?></a>
											(Источник <a href="<?=$item->link?>" >Лента.ру</a>)
											<hr>
											<div class="blog_post_content"><?=$item->description?></div>
											<a class="read_more_btn" href="<?=$item->link?>" >Читать далее...</a>
										</div>
										</div>
								<?php endforeach ?>									
								</div>										
								</header>								
							</section>
							<section>								
							<h2>Оглавление</h2>									
								<div class="mini-posts">
									@if (isset($posts))
										@foreach ($posts as $post)
											<article class="mini-post">
												<header>
													<a href="#go{{ $post->id }}">
													<time class="published" datetime="2015-10-20">{{ $post->created_at }}</time>
													<p>{{ $post->name }}</p>
													<!--<a href="#" class="author"><img src="images/avatar.jpg" alt="" /></a>-->
													</a>
												</header>
												<!--<a href="single.html" class="image"><img src="images/pic04.jpg" alt="" /></a>-->
											</article>
										@endforeach
									@endif
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
								<p class="copyright"><?=date('Y')?> <span style="font-weight:bold;color:green">irec</span> - <span style="font-weight:bold;color:green">I</span>T <span style="font-weight:bold;color:green">Rec</span>ommend</p>
							</section>							
					</section>
			</div>  
	<script defer src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>		
	<script defer src="{{ asset('public/js/jquery.min.js')}}"></script>
	<script defer src="{{ asset('public/js/browser.min.js')}}"></script>
	<script defer src="{{ asset('public/js/breakpoints.min.js')}}"></script>
	<script defer src="{{ asset('public/js/util.js')}}"></script>	
	<script defer src="{{ asset('public/js/main.js')}}"></script>
	<script defer src="{{ asset('public/js/custom.js')}}"></script>
	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
	   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
	   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
	   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

	   ym(77078851, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:true
	   });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/77078851" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->
</body>
</html>