$(document).ready(function() {

    if($("div#refer_friend-invitation-dialog").length > 0){
		if($("div#dating-agent-invitation-dialog").length > 0)
		{
			$('dating-agent-invitation-dialog').showDatingAgentInvitationPopup();
			$('a.dating-agent-invitation-reply').replyDatingAgentInvitation();
		}
		else{
			$('refer_friend-invitation-dialog').showReferFriendInvitationPopup();
			$('a.refer_friend-invitation-reply').replyReferFriendInvitation();
		}
			
	}
    else if($("div#dating-agent-invitation-dialog").length > 0){
		
		if($("div#refer_friend-invitation-dialog").length > 0){
			$('refer_friend-invitation-dialog').showReferFriendInvitationPopup();
			$('a.refer_friend-invitation-reply').replyReferFriendInvitation();
		}
		else{
			$('dating-agent-invitation-dialog').showDatingAgentInvitationPopup();
			$('a.dating-agent-invitation-reply').replyDatingAgentInvitation();
		}
    }
    $leftcount = 0;
    $rightcount = 0;
    
    setInterval($(document).swapImages, 4000);
    $("a#continue").continueSignUp();
    $("a#privacy-policy, a#terms-and-conditions").showTextDialog();
    $("#login-here, #signup-her, #signup-him, #sign-up-now, #upload-photo").showDialog();
    $('.dialog').click(function(e) {
        e.stopPropagation();
    });

    $(".alert").showAlert();
    $(".alert i.close").closeAlert();
    
    $("#tabs ul li").click(function(e) {
        var tab_id = $(this).data("tab-id");
        $(".content").hide();
        $("#" + tab_id).show();
        $("#tabs ul li.active").removeClass("active");
        $(this).addClass("active");
        e.preventDefault();
    });

    $('#link-buttons-container a').click(function(e) {
        $('#link-buttons-container input').click();
    });
    
    $('#profile-photo-select a').click(function(e) {
        $('#profile-photo-select input').click();
    });

    $("#profile-picture").change(function(e){
        $("#profile-photo-select span").html($(this).val());
    });

    $('#additional-profile-link a').click(function(e) {
        e.preventDefault();
        $("#basic-information-inner").addClass("active-form");
        $("#complete-interest-link").addClass("active-form");
        $("#additional-profile-link").addClass("hide-block");
        $("#upgrade-now-container").addClass("hide-block");
    });
    
    $('#complete-interest-link a').click(function(e) {
        e.preventDefault();
        $("#profile-interest-container").addClass("active-form");
        $("#basic-information").addClass("hide-block");
    });
    
    $('#looking-for-link a').click(function(e){
        e.preventDefault();
        $("#profile-looking-for-container").addClass("active-form");
        $("#profile-interest-container").addClass("hide-block");
    });
    
//    $("#select-all").change(function(e){
//        e.preventDefault();
//        if($(this).is(":checked")){
//            $(".checkbox-item:enabled").attr("checked", "checked");
//        } else {
//            $(".checkbox-item:enabled").removeAttr("checked");
//        }
//    });

    $("#select-all").click(function(e){
        //e.preventDefault();
        if($(this).is(":checked")){
            $(".checkbox-item").attr("checked", "checked");
        }
        else {
            $(".checkbox-item").removeAttr("checked");
        }

    });

    $('.checkbox-item').click(function(e){
            //e.preventDefault();
            var checkedCount = $('.checkbox-item:checked').length;
            var totalCount = $('.checkbox-item').length;
            $('#select-all').attr('checked', checkedCount === totalCount);
        }
    );

    $("form#send-message-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');

                $("div#notification-container h4").html("Message Sent");
                $("div#notification-container p").html(data.message);
                $("div#notification-container").showNotification();
                $.clearDialogForm();
                $.closeDialogWindow();
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');

                $("div#notification-container h4").html("Message Sent");
                var validation_errors = "";
                for(var i = 0; i < data.validation.length; i++){
                    validation_errors += "<p>" + data.validation[i] + "</p>";
                }
                $("div#notification-container p").html(validation_errors);
                $("div#notification-container").showNotification();
            }
        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occured while trying to send your message. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    });

    $("form#send-hello-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "Hello sent successfully!" : "Sending Hello failed!";
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
                $("div#notification-container p").html("Error occured while trying to send your hello. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    });

    $("form#save-favorite-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "Your favorite saved!" : "Saving favorite Failed!";
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
                $("div#notification-container p").html("Error occured while trying to save your favorite. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    });


});

$.fn.swapImages = function() {
    $('div#man').animate({
        'backgroundPositionX': 680
    }, 600, function() {
        $limit = "-2880px";
        $top = $(this).css('backgroundPositionY');
        if ($limit != $top) {
            $(this).css({
                'backgroundPositionY': '-=480'
            });
        } else {
            $(this).css({
                'backgroundPositionY': '0'
            });
        }
    }).animate({
        'background-position-x': 0
    }, 600);

    $('div#woman').animate({
        'background-position-x': -680
    }, 600, function() {
        $limit = "-2880px";
        $top = $(this).css('backgroundPositionY');
        if ($limit != $top) {
            $(this).css({
                'backgroundPositionY': '-=480'
            });
        } else {
            $(this).css({
                'backgroundPositionY': '0'
            });
        }
    }).animate({
        'background-position-x': 0
    }, 600);
};

$.fn.continueSignUp = function() {
    $(this).click(function(e) {
        // Hide heading
        $("#title, #sub-title").hide();
        // Replace note
        $("#note").html($("#note").data("finish"));
        // Hide form part 1
        $("#sign-up-form-1").hide();
        // Show from part 2
        $("#sign-up-form-2").show();
        e.preventDefault();
    });
};

$.fn.showDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay, .close-dialog").closeDialog();
        var dialog_id = "#" + $(this).data("dialog");
        $(".overlay").append($(dialog_id));
        if (dialog_id == "#sign-up") {
            var type = $(this).data("type");
            var seeking = type == "Man" ? 'Woman' : "Man";
            $('#i_am_a').val(type);
            $('#looking-for').val(seeking);
            $("div.dialog-content div.banner").hide();
            $("div.dialog-content div#sign-up-banner-" + type).show();
        }
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};

$.fn.showTextDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay, .close-dialog").closeDialog();
        var dialog_id = "#" + $(this).data("dialog");
        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};

$.fn.showDatingAgentInvitationPopup = function() {
    $("body").append("<div class='overlay'></div>");
    $(".overlay").height($('body').height());
    $(".overlay, .close-dialog").closeDialog();
    var dialog_id = "#dating-agent-invitation-dialog";
    $(".overlay").append($(dialog_id));
    $(dialog_id).alignCenter();
    $(dialog_id).show();
};
$.fn.showReferFriendInvitationPopup = function() {
    $("body").append("<div class='overlay'></div>");
    $(".overlay").height($('body').height());
    $(".overlay, .close-dialog").closeDialog();
    var dialog_id = "#refer_friend-invitation-dialog";
    $(".overlay").append($(dialog_id));
    $(dialog_id).alignCenter();
    $(dialog_id).show();
};

$.fn.replyDatingAgentInvitation = function(){
    $('a.dating-agent-invitation-reply').click(function(e){
        $.post($(this).attr('href'), null, function(data) {
            if(data.accepted){
                window.location.replace(data.url);
            }
            else if(data.rejected){
                $("body").append($(".overlay div.dialog"));
                $("div.dialog").hide();
                $(".overlay").detach();
            }
        }, 'json');
        e.preventDefault();
    })
};
$.fn.replyReferFriendInvitation = function(){
    $('a.refer_friend-invitation-reply').click(function(e){
        $.post($(this).attr('href'), null, function(data) {
            if(data.accepted){
                window.location.replace(data.url);
            }
            else if(data.rejected){
                $("body").append($(".overlay div.dialog"));
                $("div.dialog").hide();
                $(".overlay").detach();
            }
        }, 'json');
        e.preventDefault();
    })
};

$.fn.alignCenter = function() {
    var top =  $(window).scrollTop() + ($(window).height()/2 - $(this).height()/2);
    var left = $(window).width() / 2 - $(this).width() / 2;
    top = top <= 0 ? 10 : top;
    left = left <= 0 ? 10 : left;
    $(this).css({
        top: top,
        left: left
    });
};

$.fn.showAlert = function() {
    var top =  $(window).scrollTop() + 20;
    var left = $(window).width() / 2 - $(this).width() / 2;
    $(this).css({
        top: top,
        left: left
    });
    setTimeout($.fn.fadeAlert, 6000);
};

$.fn.closeAlert = function() {
    $(this).click(function(e){
        e.preventDefault();
        $(".alert").hide();
    });
};

$.fn.fadeAlert = function(){
    $(".alert").fadeOut(3000);
}

$.fn.closeDialog = function(){
    $(this).click(function(e){
        e.preventDefault();
        $("body").append($(".overlay div.dialog"));
        $("div.dialog").hide();
        $(".overlay").detach();
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

function moveLeft()
{
    if ($leftcount < 0)
    {
        $('#slider').animate({
            'marginLeft': '+=' + 150 + 'px'
        }, 300, "linear", function() {
            });
        $leftcount += 1;
        $rightcount -= 1;
    }
}

function moveRight($imgcount)
{
    if ($rightcount < $imgcount-3)
    {
        $('#slider').animate({
            'marginLeft': '-=' + 150 + 'px'
        }, 300, "linear", function() {
            });
        $rightcount += 1;
        $leftcount -= 1;
    }
}