/*************************************
//
// dice2m33tu app
//
**************************************/

// express magic
var express = require('express');
var app = express();
var server = require('http').createServer(app)
var io = require('socket.io').listen(server);
var device  = require('express-device');

console.log("hi1");
var runningPortNumber = process.env.OPENSHIFT_NODEJS_PORT;
console.log(process.env.OPENSHIFT_NODEJS_PORT);
//var runningPortNumber = 8080;

app.configure(function(){
	console.log("hi2");
	// I need to access everything in '/public' directly
	app.use(express.static(__dirname + '/public'));

	//set the view engine
	app.set('view engine', 'ejs');
	app.set('views', __dirname +'/views');

	app.use(device.capture());
});


// logs every request
app.use(function(req, res, next){
	console.log("hi6");
	// output every request in the array
	console.log({method:req.method, url: req.url, device: req.device});

	// goes onto the next function in line
	next();
});

app.get("/example", function(req, res){
	console.log("hi3");
	res.render('example', {});
});

app.get("/", function(req, res){
		console.log("hi3");
	res.render('index', {});
});


io.sockets.on('connection', function (socket) {
		console.log("hi4");

	io.sockets.emit('blast', {msg:"<span style=\"color:red !important\">someone connected</span>"});

	socket.on('blast', function(data, fn){
		console.log(data);
		io.sockets.emit('blast', {msg:data.msg});

		fn();//call the client back to clear out the field
	});

	socket.on('onthemap', function(data, fn){
		console.log(data);
		io.sockets.emit('onthemap', data);

		fn();//call the client back to clear out the field
	});

});


server.listen(runningPortNumber, process.env.OPENSHIFT_NODEJS_IP);
console.log("hi5");

