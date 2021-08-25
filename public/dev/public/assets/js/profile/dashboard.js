$(document).ready(function () {

    $("#friendship-form a").click(function(e) {
        var action_url = $(this).parent().attr('action');
        var pending_friend =  $(this).parent().parent();
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

            pending_friend.remove();
            if($("#latest-friend-requests .content").children().length === 0 ){
                $("#latest-friend-requests .content").append("<p>No New Friend Requests!</p>");
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

    var item_width = 113;
    var element_count = $(".match-slider .slider-content .content").children().length;
    $(".match-slider .slider-content .content").width(item_width*element_count);

    $(".match-slider img#left-scroller, .match-slider img#right-scroller").click(function(e){
        e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$(".match-slider .slider-content .content");
        var container_width = $(".match-slider .slider-content").width();
        //var item_width = 113;
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
});