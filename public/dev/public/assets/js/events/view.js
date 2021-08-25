$(document).ready(function () {
    $("#rsvp").showDialog();
    $("#cancel-rsvp").closeDialog();

    $("form#rsvp-form").submit(function(e) {
        $('button.button-left').html('<i class="fa fa-cog fa-spin"></i>');
        $.post(this.action, $(this).serialize(), function(data) {
            $("button#rsvp").text("RSVP Sent").attr('disabled','disabled');
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


