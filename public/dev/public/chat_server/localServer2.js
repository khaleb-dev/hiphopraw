var express = require('express'),
    app = express(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
        _ = require('underscore')._,
    users = {};
//server.name = 'ipv4server';
//server.listen(4600, '68.69.170.78', function() {
//    console.log('Listening port', server.address());
//});
server.listen(4600, 'localhost', function() {
    console.log('Listening port and address', server.address());
});

// sets the log level of socket.io, with
// log level 2 we wont see all the heartbits
// of each socket but only the handshakes and
// disconnections
//io.set('log level', 2);

app.get('/', function(request, response){
    response.sendfile('hello world');
});

io.sockets.on('connection', function(socket) {
   socket.on('connect_chat', function(data, callback){
       if(data in users) {
           socket.nickname = data;
           callback(false);
       } else {
           callback(true);
           socket.nickname = data;
           users[socket.nickname] = socket;
       }
       io.sockets.emit('user_login', socket.nickname);
       io.sockets.clients().forEach(function(client) {
           console.log(client.nickname);
       });

   });

   socket.on("join_room", function(room_id) {
       if(typeof users[socket.nickname] != "undefined") {
            socket.join(room_id);
            //socket.emit("update_room", {msg:"Connected..."});
       } else {
           socket.emit("update_room", {msg:"The user is not connected to the chat server. Refresh your page to connect", room_id: room_id});
       }

       var users_list = get_room_users(room_id);
       io.sockets.emit('room_users', users_list, room_id);
   });

   socket.on("leave_room", function(room_id) {
       console.log("leave: " + socket.nickname);
       if(typeof users[socket.nickname] != "undefined") {
            socket.leave(room_id);
            io.sockets.in(room_id).emit('update_room', {msg: socket.nickname + " has disconnected from the server.", room_id: room_id});
        }
        var users_list = get_room_users(room_id);
        io.sockets.emit('room_users', users_list, room_id);
   });

   socket.on("send_chat_request", function(data) {
       var new_user = data.user_name;
       if(new_user in users) {
           var room_users = get_room_users(data.chat_room_id);
           if(_.contains(room_users,new_user)) {
               socket.emit("update_room", {msg:"The user is already in the chat room.", room_id: data.chat_room_id});
           } else {
               data.sender = socket.nickname;
               users[new_user].emit('chat_request', data);
           }
       } else {
           socket.emit("update_room", {msg:"The requested user is offline.", room_id: data.chat_room_id});
       }
   });

    socket.on("chat_request_status", function(data) {
        var status = data.status;
        var chat_room_id = data.chat_room_id;
        var sender = data.sender;
        console.log("username: " + socket.nickname);
        users[sender].emit('chat_request_response', {chat_room_id: chat_room_id, status: status, username: socket.nickname});
    });

   function get_room_users(room_id) {
       var room_users= io.sockets.clients(room_id);
       var users_list = [];
       room_users.forEach(function(client) {
           users_list.push(client.nickname);
       });

       return users_list;
   }

   socket.on('send_message', function(data) {
      var chat_room_id = data.chat_room_id;
      io.sockets.in(chat_room_id).emit('chat', {chat_room_id: chat_room_id, message: data.message, nickname: socket.nickname});
      var users_list = get_room_users(chat_room_id);
      io.sockets.emit('room_users', users_list, chat_room_id);
   });
   
   socket.on('disconnect', function(data){
       if(!socket.nickname) return;
       var count = 0;
       io.sockets.clients().forEach(function(client) {
           if(client.nickname == socket.nickname) {
               count++;
           }
           console.log(client.nickname);
       });
       if(count == 1) {
           delete users[socket.nickname];
           io.sockets.emit('user_logout', socket.nickname);
       }
   })
});