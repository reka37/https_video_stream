@extends('layouts.appfrontend')
@section('content')
   @foreach ($posts as $post)
			<article class="post" id="go{{ $post->id }}">
				<header>
					<div class="meta" style="width:200px">
					<h1>{{ $post->name }}</h1>
						<time class="published" datetime="2015-11-01">{{ $post->created_at }}</time>
						<!--<a href="#" class="author"><span class="name">Администратор</span><img src="/public/image/photo3.jpg" alt="" /></a>-->								
					</div>
					<div style="text-align: center;">
						<?php if (isset($post->image)):?>
						<img style="width:150px;height:150px;object-fit:contain;margin-top:30%" src="<?='public/image/posts/'.$post->image?>">
						<?php endif; ?>
					</div>		
				</header>
				<div style="display:block; overflow-x: auto; max-width:750px">
				<p style="width:200px;">{!! $post->data !!}</p>
				</div>
				<footer>
					<ul class="actions">
						<li><a href="<?=url("/livecomments/$post->seo_url")?>" class="button large">Оставить комментарий</a></li>
					</ul>
					<ul class="stats">
						<!--<li><a href="#">Администратор</a></li>-->
						@if (!Auth::guest())	
						<li><a href="" onclick="setclick(<?=$post->id?>); return false; " id="click<?=$post->id?>" class="icon solid fa-heart">
							<?=$result_count_posts[$post->id]?>
						</a></li>
						@else
						<li><a href="{{ url('/login') }}" >Войдите</a> или <a href="{{ url('/register') }}" >зарегистрируйтесь</a></li>
						@endif						
						<li><a href="<?=url("/livecomments/$post->seo_url")?>" class="icon solid fa-comment">
							<?=$result_count_messages[$post->id]?>										
						</a></li>
					</ul>
				</footer>
			</article>
		@endforeach
		@if ($posts) {{ $posts->links('paginate') }} @endif
@endsection			