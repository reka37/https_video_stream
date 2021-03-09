@extends('layouts.app')
@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Посты
                </div>
               <hr>
				<form onsubmit="return false;" action="/posts/add" method="POST">
				    {{ csrf_field() }}        
				    <div id="body" class="col-12">					
						<?=$post[0]['data']?>
                    	</div>
					<hr>
					<select class="form-control" name="category_id" id="category_id">
							<?php foreach ($categories as $category) :?>
							<option <?php if ($post[0]['category_id'] == $category->id) echo 'selected'; ?> value="<?=$category->id?>"><?=$category->name?></option>
							<?php endforeach; ?>
					</select><hr>
					<input type="checkbox" name="isComments" id="isComments" <?php if($post[0]['isComments']) echo 'checked'; ?>>Разрешить коментарии<br><hr>					
                   <input autofocus type="submit" id="posts" class="save-data" value="Отправить">
               </form>
            </div>
        </div>
		</div>   
	 <script>
        $(document).ready(function () {
                    var options = {
            	modules: {
                toolbar: [
                  ['bold', 'italic', 'underline', 'strike'],
                  ['blockquote', 'code-block'],
                  ['link', 'image', 'video', 'formula', 'size'],
                  [{ 'size': ['small', false, 'large', 'huge'] }],
                  [{ 'script': 'sub'}, { 'script': 'super' }], 
                  [{ 'color': [] }, { 'background': [] }],  
                  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'align': [] }],
                     ['clean'],
                       [{ 'indent': '-1'}, { 'indent': '+1' }], 
                  [{ list: 'ordered' }, { list: 'bullet' }]
                ]
              },
              placeholder: 'Введите сообщение',
              theme: 'snow'
            };
            
            var editor = new Quill('#body', options);  
  
            
            $("#posts").bind("click", function () { 
					   
				if ($('#isComments').is(':checked')){
					var isComments = 1; 
				} else {
					var isComments = 0; 
				}
				
				var category_id = $('#category_id').val();
				
				var id = {{$id}}
      
				var _token   = $('meta[name="csrf-token"]').attr('content');
  
				var justHtml = editor.root.innerHTML;
              
                    $.ajax({
                    url: "/posts/edit",
                    type: "POST",
                    data: ({
							_token: _token,
							id:id,
							category_id:category_id,
							isComments:isComments,
							data: justHtml
					}),
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
         
            });
            

	
		});
			
                var socket = io(':6050'),
				channel = 'chat:message';

			  socket.on('connect', function(){
				  socket.emit('subscribe', channel);
			  });
			  
			  socket.on('error', function(error){
				  console.warn('Error', error);
			  });
			  
			   socket.on('message', function(message){
                   console.info(message);
               });
			  
			  
              function appendChat(data, id){
				  
			  if (!data.is_admin) {
					$('#signal' + data.autor).css("background", "green");
					$('#balls').css("display", "block");
				  }	 
			 
				if (data.autor == id) {

				var date = new Date();

				var str_date = date.getFullYear() + '-' + date.getMonth() + '-' + date.getDate() + ' ' +date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
						
				var dark = '';
				var time_ = 'time-right';
				var right_ = '';
					var photo = '/public/image/222.jpg';
			if (data.is_admin) {
				 dark = 'darker';
				 time_= 'time-left';
				 var right_ = 'class="right"';
				 	var photo = '/public/image/photo3.jpg';
			}	
				
			$('.chat').append(

			$('<li></li>').html(
				'<li>   <div class="container ' +dark+ '"><img src="' +photo+ '" alt="Avatar" ' + right_ + '>'+
				'<p>' + data.content + '</p>'+
				'<span class="' + time_ + '">' + str_date + '</span>'+
			'</div></li>')
			); 

			}
              };
                   	         
			var t =  function (){
				var content = $("#content").val();
				var autor = $("#autor").val();
				var _token   = $('meta[name="csrf-token"]').attr('content');

				$.ajax({
					type:'POST',
					url:'/chat/message',
					data:{_token: _token, autor:autor, content:content, is_admin:1},
					success:function(data){
					}
				});
			};

			socket.on("chat:message", function(data){
				appendChat(data, id);
			});              
           </script>       	
@endsection