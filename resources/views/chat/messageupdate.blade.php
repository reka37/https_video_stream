@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('public/css/quill.snow.css') }}">
            <div class="content">
                <div class="title m-b-md">
                    Редактирование сообщения
                </div>
               <hr>
			   <div class="container">
				<form action="/messageupdate/<?=$id?>" method="POST">
				    {{ csrf_field() }}
					<textarea style="width:100%" name="content">{{$message->content}}</textarea>				 
					<hr>
                   <input autofocus type="submit" id="posts" class="save-data" value="Отправить">
               </form>
			   </div>
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
                  
				var id = {{$id}}
      
				var _token   = $('meta[name="csrf-token"]').attr('content');
  
				var justHtml = editor.root.innerHTML;
          
      
      
                    $.ajax({
                    url: "/posts/edit",
                    type: "POST",
                    data: ({
							_token: _token,
							id:id,
							isComments:isComments,
							data: justHtml
					}),
						dataType: "html",
						success: function (data) { 
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
            
            $('form.edit-blogname').submit(function () { 
				$('button[type*=submit][class*=col-4]').attr('disabled', 'true');
                var formID = $(this).attr('id'); // Получение ID формы
                var formNm = $('#' + formID);
                var sendcontent = formNm.serialize();
                $.ajax({
                    type: 'POST',
                    url: 'backend/ajax/blog/edit_blogname.php', // Обработчик формы отправки
                    data: sendcontent,
                    success: function (data) { 
                        if (data == "True") {
                         
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }
                    }
                });
                return false;
            });
			$(document).ready(function () {
				$('form.form_del_blogname').submit(function () {
					var formID = $(this).attr('id'); // Получение ID формы
					var formNm = $('#' + formID);
					var sendcontent = formNm.serialize();							
					swal({
					  title: "Вы уверены?",
					  text: "Вы удаляете название блога",
					  type: "warning",
					  showCancelButton: true,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "Да удалить",
					  cancelButtonText: "Нет, не удалять",
					  closeOnConfirm: false,
					  closeOnCancel: false
					},
					function(isConfirm){
					  if (isConfirm) {
							$.ajax({
								type: 'POST',
								url: 'backend/ajax/blog/del_blogname.php', // Обработчик формы отправки
								data: sendcontent,
								success: function (data) 
								{if(data == "True")
									{
							
										setTimeout(function() {window.location.reload();}, 2000);
									}else{
					
									}										
								}
							})								  
				
					  } else {
					
					  }
					}); 
					return false;
				});
			});
		});			
                var socket = io(':6050'),
				channel = 'chat:message';
               // /*
               // socket.on('message', function(data){
                   // console.log('Messagae', data);
               // }).on('news', function(data){
                   // console.log(data);
               // });
              // */
              
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
				  
			//	  $('#signal' + id).css("background", "green");
				  
			  if (!data.is_admin) {
					$('#signal' + data.autor).css("background", "green");
					$('#balls').css("display", "block");
				  }	 



				 
if (data.autor == id) {
	/*
	$('.chat').append(
				$('<li></li>').text(data.autor  + ' - ' + data.content )

				); 
				*/
				
	
	
	
	
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
                   
				   

				   
				
				   
				   
     
              /*
               socket.on("chat:message", function(data){
             //         appendChat(data);
		//		  console.log(data);
               });
              */
// $(document).ready(function(){
	// $('#ff').click(function(){


     // var content = $("#content").val();
        // var autor = $("#autor").val();
   // var _token   = $('meta[name="csrf-token"]').attr('content');

	// $.ajax({
              // type:'POST',
              // url:'/chat/message',
      // //   data:{_token: _token, autor:autor, content:content},
              // success:function(data){

// //console.log(data);
				
              // }
           // });
// });
// });


	         
	var t =  function (){
				
 
        var content = $("#content").val();
        var autor = $("#autor").val();
   var _token   = $('meta[name="csrf-token"]').attr('content');
     
           
				   
 
				   
 $.ajax({
              type:'POST',
              url:'/chat/message',
         data:{_token: _token, autor:autor, content:content, is_admin:1},
              success:function(data){

//console.log(data);
				
              }
           });
		   
		//   return false;
	  };
				   
             socket.on("chat:message", function(data){
                      appendChat(data, id);
		//		  console.log(data);
               });
              
           </script>
        	
@endsection