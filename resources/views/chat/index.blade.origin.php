<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts 
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
-->
<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>
<script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
     
    </head>
    <body>
           
        
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Чат
                </div>

               <ul class="chat">
			   @foreach ($messages as $message)
			   <li>{{ $message->autor}}</li>
			   @endforeach
			   </ul>
               <form action="/chat/message" method="POST">
                   <input type="text" name="autor"><br>
				   {{ csrf_field() }}
                   <textarea name="content" style="width:100%;height:50px"></textarea>
                   <input type="submit" value="Отправить">
               </form>
            </div>
        </div>
     <!--   
        <script src="https://cdn.socket.io/socket.io-3.0.1.min.js"></script>
      -->
      <script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>
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
              /* 
			  socket.on('connect', function(){
				  socket.emit('subscribe', channel);
			  });
			  
			  socket.on('error', function(error){
				  console.warn('Error', error);
			  });
			  
			   socket.on('message', function(message){
                   console.info(message);
               });
			  */
			  
              function appendChat(data){
                  var now = new Date();
$('.chat').append(
    $('<li></li>').text(data.autor  + ' - ' +data.content )
 
); 
              }
                   
              // $('form').on('submit', function(){
                  // var text = $('textarea').val(),
                  // name= $('input').val(),
                  // msg = { message:text, name:name};
                  
                  // socket.send(msg);
                  // appendChat(msg);
                   // $('textarea').val('');
                  // return false;
              // });
              
               socket.on("chat:message", function(data){
                      appendChat(data);
				  console.log(data);
               });
              
              
              
           </script>
        
        
    </body>
</html>
