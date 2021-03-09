@extends('layouts.app')
@section('content')		
	<h1 class="mt-4">Категории</h1>
	<ol class="breadcrumb mb-4">
		<li class="breadcrumb-item"><a href="index.html">Главная</a></li>
		<li class="breadcrumb-item active">Категории</li>
	</ol>
	<div class="card mb-4">
		<div class="card-body">
		   Добавить категорию:
		</div>
	</div>
	<form action="/addcategory" method="POST">
				   {{ csrf_field() }}
	  <div class="form-group row">
		<label for="staticEmail" class="col-sm-2 col-form-label">Название</label>
		<div class="col-sm-10">
		  <input class="form-control" type="text" name="name" id="name">
		</div>
	  </div>
		<input class="form-control" autofocus type="submit" id="sub" class="save-data" value="Сохранить">
	</form> 
	<br>
	<div class="card mb-4">
		<div class="card-header">
			<i class="fas fa-table mr-1"></i>
			Смотреть все категории:
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Имя</th>
							<th>Видимость</th>
							<th>Дата регистрации</th>
							<th>Операции</th>
						</tr>
					</thead>                                   
					<tbody>								
					 @foreach ($categories as $category)	
						<tr>									
							<td>{{ $category->name}}</td>
							<td>{{ $category->isVisiable}}</td>
							<td>{{ $category->created_at}}</td>
						  <td>
						 <!-- <a href="<?=url("/chat/1")?>"><i class="fas fa-edit mr-1"></i></a>
						  <a href="<?=url("/chat/1")?>"><i class="fas fa-trash mr-1"></i></a> 
						  -->
						  </td>
						</tr>		   
					@endforeach                     
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div> 
@endsection