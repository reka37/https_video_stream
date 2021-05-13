@extends('layouts.app')
@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Посты
                </div>
               <hr>
				<form action="/posts/edit" method="POST" id="upload" enctype="multipart/form-data">
				    {{ csrf_field() }}   
					Название:<input class="form-control" type="text" name="name" id="name" value="<?=$post[0]['name']?>"><hr>Содержание:					
				   
					
						<div id="editor"><?=$post[0]['data']?>
						</div>	
					<hr>
					<input type="hidden" name="body"/>
					
					
					
					
					Категория:
					<select class="form-control" name="category_id" id="category_id">
							<?php foreach ($categories as $category) :?>
							<option <?php if ($post[0]['category_id'] == $category->id) echo 'selected'; ?> value="<?=$category->id?>"><?=$category->name?></option>
							<?php endforeach; ?>
					</select><hr>		
					
						<input type="hidden" name="id" value="<?=$post[0]['id']?>"/><br>						
						<div class="image-preview text-center">						
							<img id="preview_" src="<?='../public/image/posts/'.$post[0]['image']?>" alt="" style="width: 200px;">
						</div>						
					   <div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Картинка</label>
						</div> 
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">Картинка</span>
							</div>
  
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="image_" id="image_">
								<label class="custom-file-label" for="plus_img_modal"></label>
							</div>
						</div><hr>	
					<input type="checkbox" name="isComments" id="isComments" value="1">Разрешить коментарии<br><hr>					
                   <input autofocus type="submit" id="posts" class="save-data" value="Отправить">
               </form>
            </div>
        </div>
		</div>  
		<link rel="stylesheet" href="../public/ckeditor/samples/css/samples.css">
		<link rel="stylesheet" href="../public/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
		<script src="../public/ckeditor/ckeditor.js"></script>	
		<script src="../public/ckeditor/samples/js/sample.js"></script>			
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

			$('#image_').change(function(){  
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
                    url: "/posts/edit",
                    type: "POST",
                   data: formData,
					cache:false, // В запросах POST отключено по умолчанию, но перестрахуемся
					contentType: false, // Тип кодирования данных мы задали в форме, это отключим
					processData: false, // Отключаем, так как передаем файл
						dataType: "html",
						success: function (data) {  
						console.log(JSON.parse(data).msg);
							if (JSON.parse(data).msg) {
								swal("Успешно", "Вы изменили данные поста", "success");
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
</script>       	
@endsection