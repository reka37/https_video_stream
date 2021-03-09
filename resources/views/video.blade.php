@extends('layouts.appfrontend')
@section('content')
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
		  padding: 10px;float:left;
		}
		
		.user_ {
			float:left;
		}
</style>
<article class="post">
<div id="video-grid"></div>


<?php 			
	if (Auth::check()) {
		$user_id_auth = Auth::user()->id;
		$user_id = $user_id;
		$user_name = Auth::user()->name;
	}					
?>
</article>  
<script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/socket.io-client@2/dist/socket.io.js"></script>	 
<script>
	   		 		   
var ROOM_ID = {{ $user_id }};
var USER_ID = {{ $user_id_auth }};
var USER_NAME = '{{ $user_name }}';

var socket = io.connect(':5001', {secure: true});

const videoGrid = document.getElementById('video-grid')
const myPeer = new Peer(undefined, {
	host: '/',
	port: '5005'
})
const myVideo = document.createElement('video')
myVideo.muted = true
const peers = {}

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
window.URL.createObjectURL = window.URL.createObjectURL || window.URL.webkitCreateObjectURL || window.URL.mozCreateObjectURL || window.URL.msCreateObjectURL;

// запрашиваем разрешение на доступ к поточному видео камеры
navigator.getUserMedia({video: true}, function (stream) {
  // разрешение от пользователя получено

  // получаем url поточного видео

	addVideoStream(myVideo, stream, USER_NAME)

	myPeer.on('call', call => {
		call.answer(stream)
		const video = document.createElement('video')
		call.on('stream', userVideoStream => {  
			addVideoStream(video, userVideoStream, USER_NAME)
		})
	})

	socket.on('connected', userId => {  
	console.log(userId);
		connectToNewUser(userId, stream, userId)
	})
}, function () {
  console.log('что-то не так с видеостримом или пользователь запретил его использовать :P');
});

socket.on('disconnected', userId => {
  if (peers[userId]) peers[userId].close()
})

myPeer.on('open', id => {
  socket.emit('join-room', ROOM_ID, id)
})
  
function connectToNewUser(userId, stream, USER_NAME) {   
	const call = myPeer.call(userId, stream)
	const video = document.createElement('video')
	
	call.on('stream', userVideoStream => {
		addVideoStream(video, userVideoStream, userId)
	})
	call.on('close', () => {
		video.remove()
	})

	peers[userId] = call
}

function addVideoStream(video, stream, USER_NAME) { 
  video.srcObject = stream
  video.addEventListener('loadedmetadata', () => {
	video.play()
  })
  
  var dNew = document.createElement('div');
//dNew.innerHTML="<p style='position:absolute; left:60px; top:60px; background:white'>" +USER_NAME+ "<p>"
dNew.innerHTML="<p style='position:absolute; display: inline; margin-left:-280px; margin-top:18px; background-color:white;z-index:88888; '><span style='background:white;z-index:88888;padding:5px'>" +USER_NAME+ "</span><p>"
  videoGrid.append(video)
  videoGrid.appendChild(dNew)
}
 
socket.on('connect', function(){

	socket.on("message", function(data){
		console.log(data);
	});        
	
	socket.emit("join-room", ROOM_ID, USER_ID);
	
	socket.on('connected', function(userId){
		console.log("user connected " + userId);
	});

});              
</script>
@endsection