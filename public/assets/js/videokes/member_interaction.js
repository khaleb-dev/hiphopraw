$(document).ready(function() {
    $("p.icons a").mouseenter(function(e){
        e.preventDefault();
        var icon_name = $(this).children("i").attr("class");
        switch(icon_name){
            case "messages":
                bgColor = "#34cf95";
                message = "Send Message"
                break;
            case "chat":
                bgColor = "#002482"
                message = "Start a Chat"
                break;
            case "hello":
                bgColor = "#c30d64"
                message = "Send a Hello"
                break;
            case "favorite":
                bgColor = "#ec993b"
                message = "Save as Favorite"
                break;
            default:
                bgColor = "#000000";
        }
        var $content = $("div#interaction-icons-description p")
        $content.html(message);
        $content.css({
            "background-color":bgColor
        });
        var $dialog = $("div#interaction-icons-description");
        $dialog.hide();
        $dialog.css({
            left: $(this).offset().left,
            top: $(this).offset().top -38
        });
        $dialog.show();

    });
    $("p.icons a").mouseleave(function(e){
        var $dialog = $("div#interaction-icons-description");
        $dialog.hide();
    });

    $("p.icons a#request-as-friend, a#request-as-friend-bottom, p.icons a#send-a-hello,p.icons a#send-chat,p.icons a#send-message,p.icons a#send-favorite").showUpgradeDialog();
    $("nav#public-profile-nav a#send-message,nav#public-profile-nav a#send-a-hello,nav#public-profile-nav a#send-favorite, nav#public-profile-nav a#send-chat, nav#public-profile-nav a#refer-a-friend").showUpgradeDialog();
    $("nav#public-profile-nav a#book-me,nav#public-profile-nav a#report-me,nav#public-profile-nav a#refer-me").showUpgradeDialog();


    $("p.icons a.send-message-icon,p.icons a.send-hello-icon,p.icons a.save-profile-icon,p.icons a.send-chat-request").showInteractionConfirmationDialog();
    $("nav#public-profile-nav a.send-message-icon,nav#public-profile-nav a.send-hello-icon,nav#public-profile-nav a.save-profile-icon, nav#public-profile-nav a.send-chat-request, a#start-chat-talk.send-chat-request").showInteractionConfirmationDialog();

    $("div.confirmation-dialog a.no-button").click(function(e) {
        e.preventDefault();
        $.closeDialogWindow();
    });

    $("div.confirmation-dialog a.confirm-send-message").click(function(e) {
        e.preventDefault();
        $.closeDialogWindow();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();

        var dialog_id = "#" + $(this).data("dialog");
        var from_member_id = $(this).data("from-member-id");
        var to_member_id = $(this).data("to-member-id");
        var message_to = $(this).data("username");
        $(dialog_id  + " #form_from_member_id").val(from_member_id);
        $(dialog_id  + " #form_to_member_id").val(to_member_id);
        $(dialog_id  + " p span.readonly-text").text(message_to);

        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });

    $("div.confirmation-dialog a.confirm-send-hello").click(function(e) {
        e.preventDefault();
        $.closeDialogWindow();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();

        var dialog_id = "#" + $(this).data("dialog");
        var from_member_id = $(this).data("from-member-id");
        var to_member_id = $(this).data("to-member-id");
        var hello_to = $(this).data("username");
        $(dialog_id  + " #form_from_member_id").val(from_member_id);
        $(dialog_id  + " #form_to_member_id").val(to_member_id);
        $(dialog_id  + " p span.readonly-text").text(hello_to);

        var action = $("form#send-hello-form").attr('action').substr(0,$("#send-hello-dialog form").attr('action').indexOf('send')) + 'hello_exists';
        $.post(action, $("form#send-hello-form").serialize(), function(data) {
            if(data.status) {
                $("form#send-hello-form").removeClass('active');
                $("div#send-hello-dialog p.message").addClass('active');
            } else {
                $("div#send-hello-dialog p.message").removeClass('active');
                $("form#send-hello-form").addClass('active');
            }
            $(".overlay").append($(dialog_id));
            $(dialog_id).alignCenter();
            $(dialog_id).show();
        }, 'json').error(function() {
            });
    });

    $("div.confirmation-dialog a.confirm-save-favorite").click(function(e) {
        e.preventDefault();
        $.closeDialogWindow();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();

        var dialog_id = "#" + $(this).data("dialog");
        var from_member_id = $(this).data("from-member-id");
        var to_member_id = $(this).data("to-member-id");
        var favorite_user = $(this).data("username");
        $(dialog_id  + " #form_member_id").val(from_member_id);
        $(dialog_id  + " #form_favorite_member_id").val(to_member_id);
        $(dialog_id  + " p span.readonly-text").text(favorite_user);
        $(dialog_id  + " p span.readonly-text").text(favorite_user);

        var action = $("form#save-favorite-form").attr('action').substr(0,$("#save-favorite-dialog form").attr('action').indexOf('save')) + 'favorite_exists';
        $.post(action, $("form#save-favorite-form").serialize(), function(data) {
            var heading = data.status ? "Your favorite saved!" : "Saving favorite Failed!";
            if(data.status) {
                $("form#save-favorite-form").removeClass('active');
                $("div#save-favorite-dialog p.message").addClass('active');
            } else {
                $("div#save-favorite-dialog p.message").removeClass('active');
                $("form#save-favorite-form").addClass('active');
            }
            $(".overlay").append($(dialog_id));
            $(dialog_id).alignCenter();
            $(dialog_id).show();
        }, 'json').error(function() {
            });
    });
});

$.fn.showInteractionConfirmationDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();

        var dialog_id = "#" + $(this).data("confirmation-dialog");
        var profile_picture = $(this).data("profile-picture");
        var username = $(this).data("username");
        $(".confirmation-dialog .dialog-content img.dialog-logo").attr("src", profile_picture);
        $(".confirmation-dialog .dialog-content p.username span").html(username);
        var from_member_id = $(this).data("from-member-id");
        var to_member_id = $(this).data("to-member-id");
        $yes_button = $("div.confirmation-dialog a.yes-button");
        $yes_button.data("from-member-id", from_member_id);
        $yes_button.data("to-member-id", to_member_id);
        $yes_button.data("username", username);

        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};

$.fn.showUpgradeDialog = function() {
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

