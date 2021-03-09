@extends('layouts.app')
@section('content')		
				<h1 class="mt-4">Пользователи</h1>
				<ol class="breadcrumb mb-4">
					<li class="breadcrumb-item"><a href="index.html">Главная</a></li>
					<li class="breadcrumb-item active">Пользователи</li>
				</ol>
				<div class="card mb-4">
					<div class="card-body">
					   Здесь отображаются пользователи
					</div>
				</div>
				<div class="card mb-4">
					<div class="card-header">
						<i class="fas fa-table mr-1"></i>
						Пользователи
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Сообщение</th>
										<th>Имя</th>
										<th>Почта</th>
										<th>Дата регистрации</th>
										<th>Операции</th>
									</tr>
								</thead>                                   
								<tbody>								
								 @foreach ($users as $user)	
									<tr id="signal<?=$user->id?>">									
									 <td><a href="<?=url("/chat/$user->id")?>"><i class="fas green fa-envelope mr-1"></i></a></td>
										<td>{{ $user->name}}</td>
										<td>{{ $user->email}}</td>
										<td>{{ $user->created_at}}</td>
									  <td>
									  <a href="<?=url("/chat/$user->id")?>"><i class="fas fa-edit mr-1"></i></a>
									  <a href="<?=url("/chat/$user->id")?>"><i class="fas fa-trash mr-1"></i></a> 
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
           <script>               
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
			  			  
              function appendChat(data){
				  if (!data.is_admin) {
					$('#signal' + data.autor).css("background", "green");
					$('#balls').css("display", "block");
				  }
              }                  
              
               socket.on("chat:message", function(data){
                      appendChat(data);
               });           
           </script>   
@endsection