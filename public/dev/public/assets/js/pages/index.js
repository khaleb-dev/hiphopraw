$(document).ready(function () {
	
	

//	$(".send-message").showDialog();
//	$(".send-hello").showDialog();
//	$(".send-favorite").showDialog();
//	 $("p.icons a.messages").mouseenter(function(e){
//	        e.preventDefault();
//	        $(".member-profile-dialog1").hide();
//	        var $dialog = $("#" + $(this).data("profile-dialog"));
//	        $dialog.css({
//	            left: $(this).offset().left + 50,
//	            top: e.pageY - 80
//	        });
//	        $dialog.show();
//	    });
//
//	    $("p.icons a.show-message-profile").mouseenter(function(e){
//	        e.preventDefault();
//
//	        var $dialog = $("#" + $(this).data("message-dialog"));
//	        $dialog.css({
//	            left: $(this).offset().left - 373, //320,
//	            top: e.pageY - 80
//	        });
//	        $dialog.show();
//	    });
//	    $("#friends-online .friend").mouseenter(function(e){
//	        $("#friends-online .member-profile-dialog1").hide();
//	    });
//
//	    $("#friends-online .member-profile-dialog1").mouseleave(function(e){
//	        $("#friends-online .member-profile-dialog1").hide();
//	    });
//
//	    $(".member").mouseenter(function(e){
//	        $(".member-profile-dialog1").hide();
//	    });
//	    $(".member-profile-dialog1").mouseleave(function(e){
//	        $(".member-profile-dialog1").hide();
//	    });
//
//
//	    $("p.icons a.hello").mouseenter(function(e){
//	        e.preventDefault();
//	        $(".member-profile-dialog2").hide();
//	        var $dialog = $("#" + $(this).data("profile-dialog"));
//	        $dialog.css({
//	            left: $(this).offset().left + 50,
//	            top: e.pageY - 80
//	        });
//	        $dialog.show();
//	    });
//
//	    $("p.icons a.show-message-profile").mouseenter(function(e){
//	        e.preventDefault();
//
//	        var $dialog = $("#" + $(this).data("message-dialog"));
//	        $dialog.css({
//	            left: $(this).offset().left - 373, //320,
//	            top: e.pageY - 80
//	        });
//	        $dialog.show();
//	    });
//	    $("#friends-online .friend").mouseenter(function(e){
//	        $("#friends-online .member-profile-dialog2").hide();
//	    });
//
//	    $("#friends-online .member-profile-dialog2").mouseleave(function(e){
//	        $("#friends-online .member-profile-dialog2").hide();
//	    });
//
//	    $(".member").mouseenter(function(e){
//	        $(".member-profile-dialog2").hide();
//	    });
//	    $(".member-profile-dialog2").mouseleave(function(e){
//	        $(".member-profile-dialog2").hide();
//	    });
//
//
//	    $("p.icons a.favorite").mouseenter(function(e){
//	        e.preventDefault();
//	        $(".member-profile-dialog3").hide();
//	        var $dialog = $("#" + $(this).data("profile-dialog"));
//	        $dialog.css({
//	            left: $(this).offset().left + 50,
//	            top: e.pageY - 80
//	        });
//	        $dialog.show();
//	    });
//
//	    $("p.icons a.show-message-profile").mouseenter(function(e){
//	        e.preventDefault();
//
//	        var $dialog = $("#" + $(this).data("message-dialog"));
//	        $dialog.css({
//	            left: $(this).offset().left - 373, //320,
//	            top: e.pageY - 80
//	        });
//	        $dialog.show();
//	    });
//	    $("#friends-online .friend").mouseenter(function(e){
//	        $("#friends-online .member-profile-dialog3").hide();
//	    });
//
//	    $("#friends-online .member-profile-dialog3").mouseleave(function(e){
//	        $("#friends-online .member-profile-dialog3").hide();
//	    });
//
//	    $(".member").mouseenter(function(e){
//	        $(".member-profile-dialog3").hide();
//	    });
//	    $(".member-profile-dialog3").mouseleave(function(e){
//	        $(".member-profile-dialog3").hide();
//	    });
//
//	    $(".member-profile-dialog2 a").click(function(){
//	        $(".member-profile-dialog2").hide();
//	    });
//	    $(".member-profile-dialog3 a").click(function(){
//	        $(".member-profile-dialog3").hide();
//	    });
//
//
//	    $(".messages").mouseenter(function(e){
//	        $(".member-profile-dialog").hide();
//	        $(".member-profile-dialog2").hide();
//	        $(".member-profile-dialog3").hide();
//	    });
//	    $(".hello").mouseenter(function(e){
//	    	 $(".member-profile-dialog").hide();
//		     $(".member-profile-dialog1").hide();
//		     $(".member-profile-dialog3").hide();
//	    });
//	    $(".favorite").mouseenter(function(e){
//	    	 $(".member-profile-dialog").hide();
//		     $(".member-profile-dialog1").hide();
//		     $(".member-profile-dialog2").hide();
//	    });
//
//	    $(".chat").mouseenter(function(e){
//	        $(".member-profile-dialog1").hide();
//	        $(".member-profile-dialog2").hide();
//	        $(".member-profile-dialog3").hide();
//	    });
	    
	 $("form#find-friend-form").submit(function(e) {
	        $('button#find-a-friend').html('<i class="fa fa-cog fa-spin"></i>');
	        $.post(this.action, $(this).serialize(), function(data) {
	            var heading = data.status ? "The person is on the system!" : "The person is not on the system!";
	            if(data.status) {
	                $("div#notification-container").removeClass('alert-error');
	                $("div#notification-container").addClass('alert-success');
	            }
	            else {
	                $("div#notification-container").removeClass('alert-success');
	                $("div#notification-container").addClass('alert-error');
	            }
	            $("div#notification-container h4").html(heading);
	            $("div#notification-container").showNotification();
	            $('button#find-a-friend').html('Find a Friend Now!');
	        }, 'json');
	        e.preventDefault();
	    });
		
	
    $("#latest-friend-requests .left-scroller a, #latest-friend-requests .right-scroller a").click(function(e){
        e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$("#member-items");
        var container_width = $("#visible-members").width();
        var item_width = 141;
        var inner_width = inner_container.width();
        var max_left = Math.abs(container_width - inner_width);
        var current_left = inner_container.data('left');
        var new_left = 0;
        if(direction === "left"){
            new_left = current_left - item_width;
            if(new_left >= -max_left){
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        } else {
            new_left = current_left + item_width;
            if(new_left <= 0){
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        }
    });

    $("div.notification-entry a#delete").click(
        function(e){
            var str = $(this).attr('href');
            var fromIndex = str.lastIndexOf("/");
            var toIndex = str.length;
            var id = str.substring(fromIndex + 1, toIndex);
            $(this).css('background','none').html('<i class="fa fa-spinner fa-spin"></i>');

            $.post($(this).attr('href'), null, function(response) {
                if(response.status) {
                    $("div#notification-entry-" + id).slideUp();
                }
                $.closeDialogWindow();
            }, 'json');

            e.preventDefault();
    });
    
    $("form#refer-friend-form").submit(function(e) {
        $('button#refer-a-friend').html('<i class="fa fa-cog fa-spin"></i>');
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "You\'ve successfully notified your friend.!" : "Sending failed. Please try again later!";
            if(data.status) {
                $('input#email').val('');
                $('textarea#message').val('');
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container").showNotification();
            $('button#refer-a-friend').html('Refer a Friend Now!');
        }, 'json');
        e.preventDefault();
    });

});

