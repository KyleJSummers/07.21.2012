var app = require('http').createServer(handler)
  , io = require('socket.io').listen(app)
  , fs = require('fs')

app.listen(8080);

function handler (req, res) {
  fs.readFile(__dirname + '/index.html',
  function (err, data) {
    if (err) {
      res.writeHead(500);
      return res.end('Error loading index.html');
    }

    res.writeHead(200);
    res.end(data);
  });
}

var users = {};
var userNumber = 1;

function getUsers () {
   var userNames = [];
   for(var name in users) {
     if(users[name]) {
       userNames.push(name);  
     }
   }
   return userNames;
}

io.sockets.on('connection', function (socket) {
  var myNumber = userNumber++;
  var myName = 'user#' + myNumber;
  users[myName] = socket;
  
  socket.emit('hello', { hello: myName });
  io.sockets.emit('listing', getUsers());
  
  socket.on('change', function (data) {
    users[data.user].emit('update', { delta: data.delta });
  });
  
  socket.on('cursor', function (cursor) {
    users[cursor.user].emit('cursor', { cursor: cursor.cursor, selection: cursor.selection });
    console.log(cursor.selection);
  });
  
  socket.on('disconnect', function () {
    users[myName] = null;
    io.sockets.emit('listing', getUsers());
  });
});