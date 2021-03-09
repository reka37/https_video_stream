@extends('layouts.app')
@section('content')
	<div class="content">
		<div class="title m-b-md">
		Загрузить Exel
		</div>
		<hr>
		<form method="post" action="/customdata/getfile" enctype="multipart/form-data">
			{{ csrf_field() }}
			<span style="background:<?=$color['first']?>">1. Шаг </span><input type="file" name="image"><hr>
			<span style="background:<?=$color['second']?>">2. Шаг </span><button type="submit">Отправить</button>
			</form>
			<hr>
			<form method="POST" action="/customdata" >
			{{ csrf_field() }}
			<span style="background:<?=$color['three']?>">3. Шаг </span><button type="submit">Установить файл</button>
		</form>
		<hr>
	</div>	
	<div class="card-body">
	<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>ticker</th>
					<th>fair_value</th>
						<th>market_price</th>
							<th>name</th>
								<th>safety_margin</th>
					<th>Дата закачивания</th>
				</tr>
			</thead>                                   
			<tbody>			
			 @foreach ($exels as $exel)
				<tr>								
					<td>{{ $exel->ticker}}</td>
					<td>{{ $exel->fair_value}}</td>
					<td>{{ $exel->market_price}}</td>
					<td>{{ $exel->name}}</td>
					<td>{{ $exel->safety_margin}}</td>
					<td>{{ $exel->created_at}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	</div>      	
@endsection