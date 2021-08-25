$(document).ready(function () {

    $("a.refer-friend").showDialog();
    $("a#report-me").showDialog();

    $("form#report-me-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');

                $("div#notification-container h4").html("Report Sent");
                $("div#notification-container").showNotification();
                $("div#report-me-dialog div.dialog-content p textarea").val('');
                $.closeDialogWindow();
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');

                $("div#notification-container h4").html("Report Not Sent");
                var validation_errors = "";
                for(var i = 0; i < data.validation.length; i++){
                    validation_errors += "<p>" + data.validation[i] + "</p>";
                }
                $("div#notification-container p").html(validation_errors);
                $("div#notification-container").showNotification();
            }
        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occured while trying to send your report. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    });

    $("#profile-header ul li").selectTab();
    $("#request-as-friend, #request-as-friend-bottom").showDialog();
    $("form#send-invite-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "Friend Request Sent!" : "Friend Request Failed!";
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();
            $.closeDialogWindow();
            $("a#request-as-friend").remove();
            $("a#request-as-friend-bottom").parent().remove();
            $(this).remove();

        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occured while trying to send your friend request. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    });

	$("form#refer-to-friend-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "Refer Friend Sent!" : "Sending Refer |Friend Failed!";
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();
            $.closeDialogWindow();
        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occured while trying to send your Refer Friend. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
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

$.fn.showNotification = function() {
    var top =  $(window).scrollTop() + 20;
    var left = $(window).width() / 2 - $(this).width() / 2;
    $(this).css({
        top: top,
        left: left,
        zIndex: 5
    });
    setTimeout($.fn.fadeAlert, 3000);
    $(this).show();
};

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
