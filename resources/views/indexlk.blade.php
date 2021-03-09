@extends('layouts.appfrontend')
@section('content')
	<article class="post">  
		<header>
			<div class="meta">
				<time class="published" datetime="2015-11-01">Видеосвязь</time>
				<span class="name">Выберите комнату</span>
			</div>
		</header>
		<form method="get" action="{{ url('/video') }}">
			<select class="form-control" name="user_id">
			<?php foreach($users as $result):?>
				<option value="<?=$result['id']?>"><?=$result['name']?></option>
			<?php endforeach?>
			</select>
			<p style="width:200px"></p>
			<footer>
				<ul class="actions">
					<li><button type="submit" href="11" class="button large">Связаться</button></li>
				</ul>
			</footer>
		</form>
	</article>    

	<article class="post">  
		<header>
			<div class="meta">
				<time class="published" datetime="2015-11-01">Чат</time>
				<span class="name">Выберите комнату</span>
			</div>
		</header>
		<form method="get" action="{{ url('/livecommentchat') }}">
			<select class="form-control" name="user_id">
			<?php foreach($users as $result):?>
				<option value="<?=$result['id']?>"><?=$result['name']?></option>
			<?php endforeach?>
			</select>
			<p style="width:200px"></p>
			<footer>
				<ul class="actions">
					<li><button type="submit" class="button large">Связаться</button></li>
				</ul>
			</footer>
		</form>
	</article>    		
@endsection