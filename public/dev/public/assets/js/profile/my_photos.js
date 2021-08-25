$(document).ready(function () {	
    $("#profile-header ul li").selectTab();

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

    $("#photo-container .left-scroller a, #photo-container .right-scroller a").click(function(e){
        e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$("#photo-items");
        var container_width = $("#visible-photos").width();
        var item_width = 143;
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

$.fn.selectTab = function () {
     $(this).click(function(e){
         e.preventDefault();

         $("#profile-header ul li").removeClass("active");
         $(this).addClass("active");

         $("#profile-detail > div").removeClass("active");
         $("#profile-detail #" + $(this).data('detail')).addClass("active");
     })
     
}




$.fn.showDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();
        var dialog_id = "#" + $(this).data("dialog");
        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};

$.clearDialogForm = function(){
    $("div.dialog input[type=text], div.dialog textarea").val("");
};

$.closeDialogWindow = function(){
    $("body").append($(".overlay div.dialog"));
    $("div.dialog").hide();
    $(".overlay").detach();
};

