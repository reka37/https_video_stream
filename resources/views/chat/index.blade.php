@extends('layouts.app')
@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Чат
                </div>
               <ul class="chat container">
			   @foreach ($messages as $message)
			   <li>
					<div class="container <?php if ($message->is_admin) echo 'darker';?>">
						<img src="<?php if ($message->is_admin) echo '/public/image/photo3.jpg'; else echo '/public/image/222.jpg';?>" alt="Avatar" <?php if ($message->is_admin) echo 'class="right"';?>>
						<p>{{ $message->content}}</p>
						<span <?php if ($message->is_admin) echo 'class="time-left"'; else echo 'class="time-right"';?>>
							{{ $message->created_at}}  &nbsp;&nbsp;
						<span onclick="trash(<?=$message->id?>)">
							<i class="fas fa-trash mr-1"></i>
							</span>&nbsp;   
							<a href="<?=url("/messageupdate/$message->id")?>"><i class="fas fa-edit mr-1"></i></a>
						</span>
					</div>
					</li>			
			   @endforeach
			   </ul>
				<form onsubmit="t();return false;" action="/chat/message" method="POST">
                   <input type="hidden" name="autor" id="autor" value="{{ $id }}"><br>
				   <input type="hidden" name="post_id" id="post_id" value="{{ $id }}"><br>
				    {{ csrf_field() }}
                   <textarea name="content" id="content" style="width:100%;height:50px"></textarea>
                   <input autofocus type="submit" id="sub" class="save-data" value="Отправить">
               </form>
            </div>
        </div>
		</div> 
		<script>
               var id = {{ $id }};
			
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
							'<span class="' + time_ + '">' + str_date + 
							'&nbsp;&nbsp;<span onclick="trash(' + data.id + ')">'+
							'<i class="fas fa-trash mr-1"></i></span>' + 
							'&nbsp;&nbsp;<a href="<?=url("/messageupdate/' +data.id+ '")?>"><i class="fas fa-edit mr-1"></i></a>'+
							
							'</span>'+
							'</div></li>')
						); 
					}
              };
                   	         
			var t =  function (){

			var content = $("#content").val();
			var autor = $("#autor").val();
			var post_id = $("#post_id").val();
			var _token   = $('meta[name="csrf-token"]').attr('content');
	   
				$.ajax({
					type:'POST',
					url:'/chat/message',
					data:{_token: _token, autor:autor, post_id:post_id, content:content, is_admin:1},
					success:function(data){
					}
				});
			};
				   
             socket.on("chat:message", function(data){
                      appendChat(data, id);
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
											url:'/message/delete',
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