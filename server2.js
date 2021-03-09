


/*
var express = require("express");
var app = express();
var http = require('http');

var startServer=http.createServer(app);
var io = require('socket.io').listen(startServer);
startServer.listen(6035, function () {
    console.log('server running on',8080)
});

io.on('connection', function (socket) {
    console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>>connected');
   
   
      socket.on('message', function(data){
                   socket.broadcast.send(data);
                   
               });
   
});

*/ 

//console.log('ddd1');

var Redis = require ('ioredis'),
request = require('request'),
 io = require ('socket.io')(6050),
redis = new Redis();

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

redis.psubscribe('*', function(event, count){
    
});
redis.on('pmessage', function(pattern, chanell, message){
	message = JSON.parse(message);
	io.emit(chanell + ':' + message.event, message.data.message);
    console.log(chanell, message);
});
