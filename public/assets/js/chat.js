var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();
var chatbox_width = 420;

var socket = io.connect('http://localhost:8080/');
//var socket = io.connect('http://166.70.53.122:6660/');
//var socket = io.connect();
//var socket = io.connect('http://hiphopraw.com:6660/');
//var socket = io.connect();

$(document).ready(function() {
    var base_url = $("#chat-base-url").text(); //$("#main-nav ul li:first a").attr('href');
     console.log("chat has been loaded");
     console.log($.cookie('chat_box_open'));
     //if($.cookie('chat_box_open')!= null){
        // $.createChatRoom($.cookie('chat_box_open'), $.cookie('user_name'));
    // }
    $("#user-logout a").click(function(){
        if ($.cookie('chat_box_open')) {
            console.log('removing cookies');
            var theRooms = $.cookie('chat_box_open').split(/\|/); 

            for (i=0;i<theRooms.length;i++) {
               $.post(base_url+'users/remove_chat', {'chat_room_id': theRooms[i]}, function(data) {
                    if(data.success==true) {
                          console.log('chat history successfuly removed');             
                    }

               }, 'json');

            }

            $.cookie('chat_box_open', null);
        }

    });

    if ($.cookie('chat_box_open')) {
            
         

        var ChatBoxesOpen = new Array();

        ChatBoxesOpen = $.cookie('chat_box_open').split(/\|/);    

      for (i=0;i<ChatBoxesOpen.length;i++) {

 
          console.log(ChatBoxesOpen[i]);
       
        var $current_user = $("#logged-in-user-notification");

           if($current_user.text() != '') {
              socket.emit('connect_chat', $current_user.text(), function(data){

              });
           }

        var history = new Array();
       

            $.post(base_url+'users/get_chat', {'chat_room_id': ChatBoxesOpen[i]}, function(data) {

                if(data.success==true) {

                        history = data.chat;
                          history.forEach(function(chat_line){
                            console.log(chat_line['chat_sender']);
                            console.log(chat_line['chat_reciever']);
                            console.log(chat_line['chat_line']);

                          }); 
                          console.log('chat retrieve successful'); 
                          $.createChatRoom(data.room, $.cookie('user_name'), history);
                }
          
            }, 'json');

    
            
        }     
}

  
    $("a.confirm-send-chat").newChatRoom();

    $('#chat-request-dialog a.button').click(function(e) {
        e.preventDefault();
        console.log("I am here too");
        var status= $(this).data('status');
        var chat_room_id = $('#chat-request-dialog').data('chat-room-id'); 

        var sender = $('#chat-request-dialog').data('sender');
        if(status == 'accept') {

            $.createChatRoom(chat_room_id);
            $.closeDialogWindow();
           
        }
        else {
            $.closeDialogWindow();
           
        }
        socket.emit('chat_request_status', {chat_room_id: chat_room_id, status: status, sender: sender});
    });

    var $current_user = $("#logged-in-user-notification");

    if($current_user.text() != '') {
        socket.emit('connect_chat', $current_user.text(), function(data){

        });
    }

    socket.on('user_login', function(username){
        //$('#friends-online #' + username + ' p.icons img').attr('src', base_url + 'assets/img/online_dot.png');

       // $.post(base_url+'users/chat_login', {'username': username}, function(data) {
           // var response = data;
       // }, 'json');

        console.log("the online user is");
        console.log(username);
    });

    socket.on('update_room', function(data){
        var $chatbox = "#" + data.room_id;
        $($chatbox + ' .chat .chat-detail').append('<p class="chat-notification">'+data.msg+'</p>');

        var $chat_box_visible = $($chatbox+" .chat");
        var $chat_box_detail = $($chatbox+" .chat .chat-detail");
        $chat_box_visible.scrollTop($chat_box_detail.height());

        //hide the request sent confirmation window if it is open
        var sent_dialog_id = "#chat-request-sent-dialog";
        $(sent_dialog_id + " em").remove();
        if($(sent_dialog_id).css('display') != 'none') {
          // var previous_text = $(sent_dialog_id+" p").html();
           //previous_text = previous_text + ' <em>' + data.msg + "</em>";
             var new_text = ' <em>' + data.msg + "</em>";
            $(sent_dialog_id+" p").html(new_text);
        }
    });

    socket.on('room_users', function(room_users, room_id){
        var html = '';
        var base_url = $("#chat-base-url").text();
        html+="<table style='margin: 0;' width='184px' >";
        for(i=0; i< room_users.length; i++){
            html+="<tr style='border-bottom: 1px solid rgb(51,51,51); margin: 0;' height='30px' >"
            var roomuser = room_users[i];
            var user_state = $.findState(roomuser, room_id);
            var profile  = $.getPicture(roomuser, room_id);            
            
            html +="<td  width='15'>&nbsp;&nbsp;<img src='"+base_url+"/assets/img/online_dot.png'> </td> " + "<td width='30'><div id='"+roomuser+"_picture'></div></td><td><table><tr><td>" + room_users[i] + '</td></tr><tr style="color: #ff0000; font-weight: normal; font-size: 11px;"><td><div id="'+roomuser+'_state"></div></td></tr></table></td>'
            html+="</tr>"
        }
        html+="</table>"
        $("#"+room_id+" .users").html(html);
    });

    socket.on('chat_request', function(data){
        var dialog_id = "#chat-request-dialog";
        if($(dialog_id).css('display') == 'none') {
            $.post(base_url+'users/get_dialog_profile_picture', {'username': data.sender}, function(response) {
                $("#chat-request-dialog .dialog-content img.dialog-logo").attr("src", response.profile_picture);

                $(dialog_id).data('chat-room-id', data.chat_room_id);
                $(dialog_id).data('sender', data.sender);
                $(dialog_id+" span.sender").html(data.sender);
                $(dialog_id+" span.subject").html("");
                if(data.subject != "" && data.subject != undefined ) {
                    $(dialog_id+" span.subject").html(data.sender + " wants to talk about " + data.subject + ".");
                }
                $("body").append("<div class='overlay'></div>");
                $(".overlay").height($('body').height());
                $(".overlay").css({
                    'z-index': '3'
                })
                $(".overlay, .close-dialog").closeDialog();
                $(".overlay").append($(dialog_id));
                $(dialog_id).alignCenter();
                $(dialog_id).show();
            }, 'json');

        }
    });

    socket.on('chat_request_response', function(data){
        //hide the request sent confirmation window if it is open
        var sent_dialog_id = "#chat-request-sent-dialog";
         if($(sent_dialog_id).css('display') != 'none') {
            $.closeDialogWindow();
        }
        if(data.status == "decline") {
            var dialog_id = "#chat-request-response-dialog";
            if($(dialog_id).css('display') == 'none') {
                $.post(base_url+'users/get_dialog_profile_picture', {'username': data.username}, function(response) {
                    $("#chat-request-response-dialog .dialog-content img.dialog-logo").attr("src", response.profile_picture);

                    $(dialog_id+" span").html(data.username);
                    $("body").append("<div class='overlay'></div>");
                    $(".overlay").height($('body').height());
                    $(".overlay").css({
                    'z-index': '3'
                     })
                    console.log(data.username);
                    console.log(dialog_id);
                    $(".overlay, .close-dialog").closeDialog();
                    $(".overlay").append($(dialog_id));
                    $(dialog_id).alignCenter();
                    
                    $(dialog_id).show();
                     console.log($(dialog_id).css('display'));
                }, 'json');
            }
        }
        else {
            $.createChatRoom(data.chat_room_id, data.user_name);
        }
    });

 
    socket.on('chat', function(data){
        var $chat_dialog = $("#"+data.chat_room_id);
        if($chat_dialog.css('display') == 'none') {

        }
        var $chat_box_visible = $("#"+data.chat_room_id+" .chat");
        var $chat_box_detail = $("#"+data.chat_room_id+" .chat .chat-detail");

        console.log("the reciever is ");
        console.log(data); 

        if(data.nickname == $current_user.text()){
          $chat_sender = $current_user.text();
          $chat_reciever = data.m_reciever;
        }else{
          $chat_sender = data.nickname;
          $chat_reciever = $current_user.text();
        }
            $.post(base_url+'users/save_chat', {'chat_room_id': data.chat_room_id, 'chat_sender':$chat_sender,'chat_reciever': $chat_reciever, 'chat_line':data.message}, function(data) {

                if(data.success==true) {
                        console.log('chat saving successful');
                         
                       }
                       
            }, 'json');


        var user = data.nickname == $current_user.text() ? "You" : data.nickname;
        var blue_text = data.nickname == $current_user.text() ? "blue-text" : "";
        $chat_box_detail.append('<p class="chat-msg"><span class="user '+blue_text+'">' + user + ' : </span><span class="message">' + data.message + '</span></p>');
        $chat_box_visible.scrollTop($chat_box_detail.height());
    });

    socket.on('user_logout', function(username){
       //  $('#friends-online #' + username + ' p.icons img').attr('src', base_url + 'assets/img/offline_dot.png');
        // $.post(base_url+'users/chat_logout', {'username': username}, function(data) {
       //                var response = data;        }, 'json');
        console.log("the user who just logged out is ");
        console.log(username);
    });
});


$.fn.newChatRoom = function() {
    $(this).click(function(e) {
        e.preventDefault();
        var chat_room_id = uuid.v4();
        var user_name = $(this).data("username");

        
        
        if(user_name != '') {
            console.log(user_name);
            
            socket.emit('send_chat_request', {chat_room_id: chat_room_id, user_name: user_name});
            

            //Create Notification
            var base_url = $("#chat-base-url").text();
            

            $.post(base_url+'users/get_dialog_profile_picture', {'username': user_name}, function(data) {
               var response = data;
            }, 'json');

            //$.closeDialogWindow();
         
        //    var the_other_dialog = "#chat-confirmation-dialog";
        //  if($(the_other_dialog).css('display') != 'none') {
        //     $.closeDialogWindow();
        // }

            //Open the chat request sent confirmation window when request sent
            var dialog_id = "#" + $(this).data("dialog");
            console.log(dialog_id );

            if($(dialog_id).css('display') == 'none') {
                var profile_picture = $(this).data("profile-picture");
                $("#chat-request-sent-dialog .dialog-content img.dialog-logo").attr("src", profile_picture);
                
                console.log("i am here");
               
                $(dialog_id+" span").html(user_name);

                $(".overlay").append($(dialog_id));
                $(dialog_id).alignCenter();
                $(dialog_id).show();
                $("#chat-confirmation-dialog").hide();
            }
        }
    });
}

letsTalk = function(user_name, subject) {
    var chat_room_id = uuid.v4();
    if(user_name != '') {
        socket.emit('send_chat_request', {chat_room_id: chat_room_id, user_name: user_name, subject: subject});

        //Create Notification
        var base_url = $("#chat-base-url").text();
        $.post(base_url+'users/get_dialog_profile_picture', {'username': user_name}, function(data) {
            var response = data;
        }, 'json');

        //Open the chat request sent confirmation window when request sent
        var dialog_id = "#chat-request-sent-dialog";
        if($(dialog_id).css('display') == 'none') {
            $.post(base_url+'users/get_dialog_profile_picture', {'username': user_name}, function(response) {
                $("#chat-request-sent-dialog .dialog-content img.dialog-logo").attr("src", response.profile_picture);

                $(dialog_id+" span").html(user_name);
                $("body").append("<div class='overlay'></div>");
                $(".overlay").height($('body').height());
                $(".overlay").css({
                    'z-index': '3'
                })
                $(".overlay, .close-dialog").closeDialog();
                $(".overlay").append($(dialog_id));
                $(dialog_id).alignCenter();
                $(dialog_id).show();
            }, 'json');
        }
    }
}

$.createChatRoom = function(chat_room_id,user_name, history) {
    var base_url = $("#chat-base-url").text();
    var chatbox_title = (user_name ? user_name : "") +"<img src='"+base_url+"/assets/img/chat_header.png' >" + " Hip Hop Live Chat" //$(this).data("chatbox-title");
    
    console.log(chat_room_id);
    var newCookie = chat_room_id;

    var existingBoxes = new Array();  


    if ($.cookie('chat_box_open')) {
            existingBoxes = $.cookie('chat_box_open').split(/\|/); 

            console.log(newCookie);
            console.log(existingBoxes);
            if(newCookie in existingBoxes){
                console.log("already in cookie");
            } else{
                newCookie += '|'+$.cookie('chat_box_open');
                $.cookie('chat_box_open', newCookie);
            }
            
    } else{
         $.cookie('chat_box_open', newCookie);
    }

   

    console.log($.cookie('chat_box_open'));

    //$.cookie('chat_box_open', chat_room_id);
    $.cookie('user_name', user_name);

    if($("#"+chat_room_id).length > 0) {
        if($("#"+chat_room_id).css('display') == 'none') {
            $("#"+chat_room_id).css('display', 'block');
            $.restructureChatRooms();
        }
        $("#"+chat_room_id+" .chatboxtextarea").focus();
        return;
    }

    $(" <div />" ).attr("id",chat_room_id)
        .addClass("chatbox")
        .html('<div class="chatboxhead clearfix">' +
            '<div class="chatboxtitle">'+
                chatbox_title+
            '</div>' +
            '<div class="chatboxoptions">' +
            '<a href="javascript:void(0)" onclick="$.toggleChatRoom(\''+chat_room_id+'\')">-</a> ' +
            '<a class="close-chat-room" href="#" data-chat-room="'+ chat_room_id +'" data-user="'+ user_name +'">x</a>' +
            '</div>' +
            '</div>' +
            '<div class="chatboxcontent">' +
            '<div class="chat-container">' +
            '<div class="chat"><div class="chat-detail"></div></div>' +
            '<div class="chatboxinput">' +
            '<textarea class="chatboxtextarea" onkeydown="javascript:return $.send_message(event,this,\''+chat_room_id+'\');"></textarea>' +
            '</div>'  +
            '</div>' +
            '<div class="users-container">' +
            '<div class="add-user">' +
            '<select><option value=""></option></select>' +
            '<a href="javascript:void(0)" onclick="$.add_user(\''+chat_room_id+'\')"> + Invite a Friend</a> ' +
            '</div>' +
            '<div class="users"></div>' +
            '</div>' +
            '</div>'
        )
        .appendTo($( "body" ));

    var $chat_box_visible = $("#"+chat_room_id+" .chat");
    var $chat_box_detail = $("#"+chat_room_id+" .chat .chat-detail");

    if (typeof history != 'undefined'){

      console.log('about to write');
      console.log(history);
      counter = 0; 
             
        var $current_user = $("#logged-in-user-notification");

        history.forEach(function(chat_line){

          //if(counter % 2 == 0){

        var user = chat_line['chat_sender'] == $current_user.text() ? "You" : chat_line['chat_sender'];
        var blue_text = chat_line['chat_sender'] == $current_user.text() ? "blue-text" : "";
        $chat_box_detail.append('<p class="chat-msg"><span class="user '+blue_text+'">'+ user + ' : </span><span class="message">' + chat_line['chat_line'] + '</span></p>');
        $chat_box_visible.scrollTop($chat_box_detail.height());  

              // }
              // counter = counter + 1;
      });  

     }
    var base_url = $("#chat-base-url").text(); //$("#main-nav ul li:first a").attr('href');
    $.post(base_url+'users/chat_friends', function(data) {
        var option = '';
        console.log(data.friends_usernames);
        for (i=0;i<data.friends_usernames.length;i++){
            option += '<option value="'+ data.friends_usernames[i] + '">'+ data.friends_usernames[i] + '</option>';
        }
        $('#'+chat_room_id+' select').append(option);
    }, 'json').error(function() {
        });

    $("a.close-chat-room").closeChatRoom();

    $("#"+chat_room_id).css('top', '0px');

    chatBoxeslength = 0;
    for (x in chatBoxes) {
        if ($("#"+chatBoxes[x]).css('display') != 'none') {
            chatBoxeslength++;
        }
    }

    if (chatBoxeslength == 0) {
        $("#"+chat_room_id).css('right', '20px');
    } else {
        width = (chatBoxeslength)*(chatbox_width+7)+20;
        $("#"+chat_room_id).css('right', width+'px');
    }
    chatBoxes.push(chat_room_id);

    chatboxFocus[chat_room_id] = false;

    $("#"+chat_room_id+" .chatboxtextarea").blur(function(){
        chatboxFocus[chat_room_id] = false;
        $("#"+chat_room_id+" .chatboxtextarea").removeClass('chatboxtextareaselected');
    }).focus(function(){
            chatboxFocus[chat_room_id] = true;
            newMessages[chat_room_id] = false;
            $('#'+chat_room_id+' .chatboxhead').removeClass('chatboxblink');
            $("#"+chat_room_id+" .chatboxtextarea").addClass('chatboxtextareaselected');
        });

    $("#"+chat_room_id+' .chat').click(function() {
        if ($('#'+chat_room_id+' .chat').css('display') != 'none') {
            $("#"+chat_room_id+" .chatboxtextarea").focus();
        }
    });

    $("#"+chat_room_id).show();

    //join a chat room based on the generated id
    socket.emit('join_room', chat_room_id);
}

$.fn.closeChatRoom = function() {
    $(this).click(function(e) {
        e.preventDefault();

        var chat_room = $(this).data('chat-room');
        var user_name = $(this).data('user');
        var index = $.inArray(chat_room, chatBoxes);
        if(index != -1) {
            chatBoxes.splice(index,1);
            $('#'+chat_room).remove();     
            $.restructureChatRooms();
            
           var existingOnes = $.cookie('chat_box_open').split(/\|/); 
           var newOnes = new Array();
           

            for(i=0; i<existingOnes.length; i++){

                if(existingOnes[i] === chat_room){
                    continue;
                }else{
                    newOnes.push(existingOnes[i]);           

                }

            }  
        if(newOnes.length > 0){
            for(i=0; i<newOnes.length; i++){
                if(i==0){
                    $.cookie('chat_box_open', newOnes[i]);
                }else{
                     newOnes[i]+= '|'+$.cookie('chat_box_open');
                }

            }
         }else{
            $.cookie('chat_box_open', null);
         }
           
            $.cookie('user_name', null);

            socket.emit('leave_room', chat_room);
            // $.cookie('chat_box_open', null);
        }
    });
};

$.toggleChatRoom = function(chat_room) {
    if ($('#'+chat_room+' .chatboxcontent').css('display') == 'none') {

        var minimizedChatBoxes = new Array();
        if ($.cookie('chatbox_minimized')) {
            minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
        }
        var newCookie = '';
        for (i=0;i<minimizedChatBoxes.length;i++) {
            if (minimizedChatBoxes[i] != chat_room) {
                newCookie += chat_room+'|';
            }
        }
        newCookie = newCookie.slice(0, -1)

        $.cookie('chatbox_minimized', newCookie);
        $('#'+chat_room+' .chatboxcontent').css('display','block');
        $('#'+chat_room+' .chatboxinput').css('display','block');
        $("#"+chat_room+" .chatboxcontent").scrollTop($("#"+chat_room+" .chatboxcontent")[0].scrollHeight);
    } else {

        var newCookie = chat_room;

        if ($.cookie('chatbox_minimized')) {
            newCookie += '|'+$.cookie('chatbox_minimized');
        }

        $.cookie('chatbox_minimized',newCookie);
        $('#'+chat_room+' .chatboxcontent').css('display','none');
        $('#'+chat_room+' .chatboxinput').css('display','none');
    }
}

$.add_user = function(chat_room_id) {
    var user_name = $("#"+chat_room_id+" select option").filter(":selected").text().trim();
    $("#"+chat_room_id+" select").val(0);
    if(user_name != '') {
        socket.emit('send_chat_request', {chat_room_id: chat_room_id, user_name: user_name});
    }
}

$.send_message = function(event, txtMessage, chat_room_id) {
    if(event.keyCode == 13 && event.shiftKey == 0) {
        var message = $(txtMessage).val().trim();
        $(txtMessage).val('');
        $(txtMessage).focus();
        if(message != '') {
            socket.emit('send_message', {chat_room_id: chat_room_id, message: message});
        }
        return false;
    }
}
$.findState = function(roomuser, room_id){
    var base_url = $("#chat-base-url").text();
    $.post(base_url+'users/friends_state/' + roomuser, function(data) {
        user_state = data.friends_state;
         html=user_state;
         $("#"+room_id+" .users #"+roomuser+"_state").html(html);
   }, 'json').error(function() {
              });  
}
$.getPicture = function(roomuser, room_id){
    var base_url = $("#chat-base-url").text();
    $.post(base_url+'users/get_profile_picture', {'username': roomuser}, function(response) {
                   //console.log(response.profile_picture);
                    profile = response.profile_picture;
                    html="<img src='"+profile+"' height='30' width='30'>";
                    $("#"+room_id+" .users #"+roomuser+"_picture").html(html);
              }, 'json').error(function() {
              });  
    
}
$.restructureChatRooms = function() {
    align = 0;
    for (x in chatBoxes) {
        chat_room_id = chatBoxes[x];

        //$.cookie('chat_box_open', null);

        if ($("#"+chat_room_id).css('display') != 'none') {
            if (align == 0) {
                $("#"+chat_room_id).css('right', '20px');
            } else {
                width = (align)*(chatbox_width+7)+20;
                $("#"+chat_room_id).css('right', width+'px');
            }
            align++;
        }
    }
}


/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};

        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '; path=/';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
