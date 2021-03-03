<html>
	<head>
		<title>Fair Value</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>
		<script
		  src="https://code.jquery.com/jquery-3.5.1.js"
		  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
		  crossorigin="anonymous"></script>

	</head>
	<body class="is-preload">
 <style>
    #video-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, 300px);
      grid-auto-rows: 300px;
    }
    
    video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
  <script>
   const ROOM_ID = "11"
  </script>
<div id="video-grid"></div>
    <script>
    var socket = io.connect(':5001', {secure: true});
    
    const videoGrid = document.getElementById('video-grid')
    const myPeer = new Peer(undefined, {
        host: '/',
        port: '5005'
    })
    const myVideo = document.createElement('video')
    myVideo.muted = true
    const peers = {}

     // navigator.getUserMedia  и   window.URL.createObjectURL (смутные времена браузерных противоречий 2012)
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    window.URL.createObjectURL = window.URL.createObjectURL || window.URL.webkitCreateObjectURL || window.URL.mozCreateObjectURL || window.URL.msCreateObjectURL;

  // запрашиваем разрешение на доступ к поточному видео камеры
    navigator.getUserMedia({video: true}, function (stream) {
      // разрешение от пользователя получено
  
      // получаем url поточного видео
   
     addVideoStream(myVideo, stream)

  myPeer.on('call', call => {
    call.answer(stream)
    const video = document.createElement('video')
    call.on('stream', userVideoStream => {  
      addVideoStream(video, userVideoStream)
    })
  })

  socket.on('connected', userId => {  
    connectToNewUser(userId, stream)
  })
    }, function () {
      console.log('что-то не так с видеостримом или пользователь запретил его использовать :P');
    });
    
    socket.on('user-disconnected', userId => {
      if (peers[userId]) peers[userId].close()
    })
    
    myPeer.on('open', id => {
      socket.emit('join-room', ROOM_ID, id)
    })
    
    function connectToNewUser(userId, stream) {   
      const call = myPeer.call(userId, stream)
      const video = document.createElement('video')
      call.on('stream', userVideoStream => {
        addVideoStream(video, userVideoStream)
      })
      call.on('close', () => {
        video.remove()
      })
    
      peers[userId] = call
    }

    function addVideoStream(video, stream) { 
      video.srcObject = stream
      video.addEventListener('loadedmetadata', () => {
        video.play()
      })
      videoGrid.append(video)
    }

    socket.on('connect', function(){

        socket.on("message", function(data){
            console.log(data);
        });
        
        //	   var room_id = Math.random();
        //	var room_id = 11;
        
        socket.emit("join-room", ROOM_ID, 10);
        
        socket.on('connected', function(userId){
        console.log("user connected" + userId);
        });
 
    });
        
	</script>
</body>
</html>