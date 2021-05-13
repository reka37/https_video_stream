@extends('layouts.app')
@section('content')
	<div class="content">
		<div class="title m-b-md">
			Посты
		</div>
		<hr>
		@foreach ($posts as $post)
		<p>{{ $post->name }}</p> 
		<div>
			<?php if (isset($post->image)):?>
			<img style="width:150px;height:150px;object-fit:contain;margin-bottom:5px" src="<?='public/image/posts/'.$post->image?>">
			<?php endif; ?>
		</div>		
		<div style="border: 1px solid rgba(0,0,0,0.25);border-radius:2px; padding:10px;box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">			 
			<p>{!! $post->data !!}</p>
			<p>{{ $post->created_at }}</p>	   
			<a href="<?=url("/postupdate/$post->id")?>"><i class="fas fa-edit mr-1"></i></a>
			<td><a href="<?=url("/postchat/$post->id")?>"><i class="fas green fa-envelope mr-1"></i></a></td>
			<span onclick="trash(<?=$post->id?>)"><i class="fas fa-trash mr-1"></i></span> 
		</div>
		<hr><br><br><hr>
		@endforeach			   
		<form action="/posts/add" method="POST" id="upload" enctype="multipart/form-data">
			{{ csrf_field() }}  
			Название:<input class="form-control" type="text" name="name" id="name"><br>	
			Содержание:					
			


<textarea id="editor">
						</textarea>	   										
						<hr>
					 	<input type="hidden" name="body"/>	


				
				Категория:						
				<select class="form-control" name="category_id" id="category_id">
					<?php foreach ($categories as $category) :?>
					<option value="<?=$category->id?>"><?=$category->name?></option>
					<?php endforeach; ?>
				</select><hr>
				<div class="image-preview text-center">
					<img id="preview_" src="" alt="" style="width: 200px;">
				</div>	
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Картинка</span>
					</div><br>
					<div class="custom-file">
						<input type="file" class="custom-file-input" name="image" id="image">
						<label class="custom-file-label" for="plus_img_modal"></label>
					</div>
				</div><hr>	
				<input type="checkbox" name="isComments" id="isComments" value="1">Разрешить коментарии<br><hr>						
		   <input autofocus type="submit" id="posts" class="save-data" value="Отправить">
		</form>
	</div>
	</div>
	</div>  
	
	<link rel="stylesheet" href="public/ckeditor/samples/css/samples.css">
		<link rel="stylesheet" href="public/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
		<script src="public/ckeditor/ckeditor.js"></script>	
		<script src="public/ckeditor/samples/js/sample.js"></script>	
	<script>
	initSample(); 
		$(document).ready(function () {


			function readImage ( input , id) {
				if (input.files && input.files[0]) {
				  var reader = new FileReader();
			 
				  reader.onload = function (e) {
					$(id).attr('src', e.target.result);
				  }
			 
				  reader.readAsDataURL(input.files[0]);
				}
			  }
			 
			  function printMessage(destination, msg) {
			 
				$(destination).removeClass();
			 
				if (msg == 'success') {
				  $(destination).addClass('alert alert-success').text('Файл успешно загружен.');
				}
			 
				if (msg == 'error') {
				  $(destination).addClass('alert alert-danger').text('Произошла ошибка при загрузке файла.');
				}		 
			  }

				$('#image').change(function(){  
						readImage(this, '#preview_');
					});


			   $('#upload').on('submit',(function(e) {
			   
			 	e.preventDefault();

				for ( instance in CKEDITOR.instances )
				{
					CKEDITOR.instances[instance].updateElement();
				}
			
				var field1 =CKEDITOR.instances[instance].getData();

				var name = document.querySelector('input[name=body]'); // set name input var
				name.value = field1;
				var formData = new FormData(this); 
			 
			 
			 
					$.ajax({
					url: "/posts/add",
					type: "POST",
					data: formData,
					   cache:false, // В запросах POST отключено по умолчанию, но перестрахуемся
			contentType: false, // Тип кодирования данных мы задали в форме, это отключим
			processData: false, // Отключаем, так как передаем файл
						dataType: "html",
						success: function (data) { 
						window.location.reload();
							if (data == "True") {
								swal("Успешно", "Имя блога зарегистрировано", "success");
								setTimeout(function () {
								window.location.reload();
								}, 3000);				
							} else if (data == "False") {
								swal("Ошибка", "Имя блога не зарегистрировано", "error");
							}					
						}
					})
			}));  	
		});
			
		function trash(id){			
				  swal({
				  title: 'Вы уверены?',
				  text: "Удалить?",
				  type: 'warning',
				   icon: "success",
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Yes, delete it!'
				}).then(function(res) {
					if(res){
						 var _token   = $('meta[name="csrf-token"]').attr('content');
						  $.ajax({
								type: 'POST',
										url:'/posts/delete',
								data:{_token: _token, id:id},				   
								success: function (data) 
								{
									if(data.msg)
									{
										  swal(
											'Удалено',
											'',
											'success'
										  );
										  
										  setTimeout(function() {window.location.reload();}, 2000);
									}  
								}
							})
					}
				})
			return false;
		}          
	</script>      	
@endsection