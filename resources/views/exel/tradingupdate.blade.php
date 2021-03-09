@extends('layouts.app')

@section('content')

            <div class="content">
                <div class="title m-b-md">
                    Trading
                </div><hr>	<hr>
					<form action="/tradingupdate/<?=$trading->id?>" method="POST">
								   {{ csrf_field() }}
					  <div class="form-group row">
						<label for="staticEmail" class="col-sm-2 col-form-label">Ticker</label>
						<div class="col-sm-10">
						  <input class="form-control" type="text" name="ticker" id="ticker" value="<?=$trading->ticker?>">
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label">Order type</label>
						<div class="col-sm-10">
						  <select class="form-control" type="text" name="order_type" id="order_type">
							<option value="BUY" <?php if ($trading->order_type == 'BUY') echo 'selected';?>>BUY</option>
									  <option <?php if ($trading->order_type == 'SELL') echo 'selected';?> value="SELL">SELL</option>
									  </select>
						</div>
					  </div>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Buy price</label>
							<div class="col-sm-10">
								<input class="form-control" type="number" required name="buy_price" id="buy_price" value="<?=$trading->buy_price?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Take profit</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="take_profit" id="take_profit" value="<?=$trading->take_profit?>">
							</div>
						</div>
					   <div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Stop loss</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="stop_loss" id="stop_loss" value="<?=$trading->stop_loss?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Percent from Portfolio</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="percent" id="percent" value="<?=$trading->percent?>">
							</div>
						</div>
						
						<div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-10">
						  <select class="form-control" type="text" name="closed" id="closed">
							<option value="0" <?php if ($trading->closed) echo 'selected';?>>Открытая</option>
									  <option <?php if ($trading->closed) echo 'selected';?> value="1">Закрытая</option>
									  </select>
						</div>
					  </div>
					  
					  <div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Сlose price</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="close_price" id="close_price" value="<?=$trading->close_price?>">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label">Percent for close</label>
							<div class="col-sm-10">
								<input class="form-control" type="number" name="percent_for_close" id="percent_for_close" value="<?=$trading->percent_for_close?>">
							</div>
						</div>
					
						
						
						
						
						
						<input class="form-control" autofocus type="submit" id="sub" class="save-data" value="Сохранить">
						<?php if($success):?>
						<hr>
						<div class="alert alert-success" role="alert">
						  Сохранено!!!
						</div>
						<?php endif?>
					</form> 
            </div>
			<hr>	<hr>

        </div>
		</div>

	  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     
           <script>
            		
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
		 var post_id = $("#post_id").val();
   var _token   = $('meta[name="csrf-token"]').attr('content');
     
           
				   
 
				   
 $.ajax({
              type:'POST',
              url:'/chat/message',
         data:{_token: _token, autor:autor, post_id:post_id, content:content, is_admin:1},
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