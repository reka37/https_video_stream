process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";

var express = require('express');  
var app = express();  
var server = require('http').createServer(app);  
var io = require('socket.io')(server);
var fs = require('fs');
var https = require('https');




server.listen(5000, function () {
  console.log('Server listening at port %d', 5000);
});

const opts = {
key: fs.readFileSync('secure/actions.gq_2021-03-01-15-59_09.key'),
        cert: fs.readFileSync('secure/actions.gq_2021-03-01-15-59_09.crt')
}




var httpsServer = https.createServer(opts, app);
httpsServer.listen(5001, function(){
  console.log("HTTPS on port " + 5001);
})

app.get('/', function (req, res) {
 //   res.render('/',{roomId:12});
  console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>connected');
})


app.get('/:room', (req, res) => {
  res.render('index', { roomId: req.params.room })
})



io.attach(httpsServer);
io.attach(server);

io.on('connection', function(client) {  
    

    client.send("Hello!");
    
 		client.on("join-room", function(roomId, userId){
				console.log(roomId, userId);
					client.emit('connected', userId);
				
				client.join(roomId);
				client.to(roomId).broadcast.emit('connected', userId);
				
				
  
				});
    
    console.log('Client connected...');
    client.on('click', function(data){
      console.log(JSON.parse(data));
        setTimeout(function() {
          client.emit("ok", "data");
        }, 3000);
    })
});

    

  const {PeerServer} = require('peer');

const peerServer = PeerServer({
  port: 5005,
    path: '/',
  ssl: {
    key: fs.readFileSync('secure/actions.gq_2021-03-01-15-59_09.key'),
    cert: fs.readFileSync('secure/actions.gq_2021-03-01-15-59_09.crt')
  }
});
  
  peerServer.on('signal', function(data){
      console.log(data);
  });





/*

var io = require ('socket.io')(6086);
//var io = require('socket.io').listen(startServer);

io.on('connection', function (socket) {
    console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>connected');
   
   
  //    socket.on('message', function(data){
            //       socket.broadcast.send(data);
                   
          //     });
   
});
*/




/*

startServer.listen(6086, function () {
    console.log('server running oeeen',6080);
});

var io = require('socket.io')(startServer, {
  path: '/socket.io-client'
});

io.on('connection', function (socket) {
  
    console.log('gghh');

});
*/


/*
var io = require ('socket.io')(6087);
//var io = require('socket.io').listen(startServer);

io.on('connection', function (socket) {
    console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>connected');
   
   
  //    socket.on('message', function(data){
            //       socket.broadcast.send(data);
                   
          //     });
   
});
*/



/*
var Redis = require ('ioredis'),
request = require('request'),
 io = require ('socket.io')(6080),
redis = new Redis();

console.log('test3');

io.use(function(socket, next){
	request.get({
		url: 'http://goodactions.ga/ws/check-auth',
		headers:{cookie: socket.request.headers.cookie},
		json:true
		
	}, function (error, response, json) {
		console.log(json);
//		return json.auth ? next() : next(new Error('Auth error'));
		return next();
	});
	//next(new Error('Auth error'));
});



io.on('connection', function(socket){
	socket.on('subscribe', function(channel){
		
		request.get({
			url: 'http://goodactions.ga/ws/check-sub' + channel,
			headers:{cookie: socket.request.headers.cookie},
			json:true
			
		}, function (error, response, json) {
			
			if (!json.can) {
				socket.join(channel, function(error){
					socket.send('join to' + channel);
				});
				return;
			}	

		});	
		
	});
});

    

io.on('connection', socket => {
  socket.on('join-room', (roomId, userId) => {
    socket.join(roomId)
    socket.to(roomId).broadcast.emit('user-connected', userId)

    socket.on('disconnect', () => {
      socket.to(roomId).broadcast.emit('user-disconnected', userId)
    })
  })
})





redis.psubscribe('*', function(event, count){
    
});
redis.on('pmessage', function(pattern, chanell, message){
	message = JSON.parse(message);
	io.emit(chanell + ':' + message.event, message.data.message);
    console.log(chanell, message);
});
*/
