$(document).ready(function () {

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

    $("#friendship-form a").click(function(e) {
        var action_url = $(this).parent().attr('action');
        var pending_friend =  $(this).parent().parent();
        var form = $(this).parent();
        var friendship_status = $(this).data("friendship-status");
        $.post(action_url, {
            sender_id: $(this).data("sender-id"),
            status: friendship_status
        }, function(data) {
            var heading = data.status ? "Success" : "Error";
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            if(friendship_status === "accepted"){
                form.remove(); //remove accept/reject form
                pending_friend.appendTo('#my-friends .content'); //append to my friends list
                $("#my-friends .content >p").remove(); //remove the No Friends message if it exist, this happens for the first friend request acceptance
            }else if(friendship_status === "rejected"){
                pending_friend.remove();
            }

            if($("#pending-friends .content").children().length === 0 ){
                $("#pending-friends .content").append("<p>No new friend requests!</p>");
            }

            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();

        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occurred while trying to send your friend request. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });

        e.preventDefault();
    });

    $("#manage-friendship-form a").click(function(e) {
        var action_url = $(this).parent().attr('action');
        var friend =  $(this).parent().parent();
        var form = $(this).parent();
        var friendship_status = $(this).data("friendship-status");
        var $button = $(this);
        $.post(action_url, {
            friend_id: $(this).data("friend-id"),
            status: friendship_status
        }, function(data) {
            var heading = data.status ? "Success" : "Error";
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }

            friend.remove();
            if($("#my-friends .content").children().length === 0 ){
                $("#my-friends .content").append("<p>No friends added yet!</p>");
            }

            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();

        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occurred while trying to send your friend request. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });

        e.preventDefault();
    });
});
