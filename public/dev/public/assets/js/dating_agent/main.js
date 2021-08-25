$(document).ready(function () {	

    $('button#post-comment-button').click(function(){
        if(! $('textarea#comment-message').val().trim().length > 0){
            return false;
        }
    });
    $("a.remove-comment").on('click', function(e){
        $(this).css('background','none').html('<i class="fa fa-spinner fa-spin"></i>');
        var id = $(this).attr('id');
        var comment_id = id.substr(id.lastIndexOf('-') + 1);

        $.post($(this).attr('href'), null, function(response) {
            if(response.status) {
                $("div#comment-" + comment_id).slideUp();
                $("div#separate-" + comment_id).slideUp();

            }
            $.closeDialogWindow();
        }, 'json');

        e.preventDefault();
    });
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

//	$("input#send-refer-me").click(function(){
//        if($('select#profile_to').val() === ''){
//            return false;
//        }else{
//            $(this).attr('disabled', 'disabled');
//            $(this).addClass('disabled');
//        }
//    })

	$("form#refer-me").submit(function(e) {
        if($('select#profile_to').val() === ''){
            return false;
        }else{
            $(this).attr('disabled', 'disabled');
            $(this).addClass('disabled');
        }

        $.post(this.action, $(this).serialize(), function(data){
            var heading = data.status ? "You\'ve successfully invited your friend.!" : "Invitation failed. Please try again later!";
            if(data.status === true){
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
                $("body").append($(".overlay div.dialog"));
                $("div.dialog").hide();
                $(".overlay").detach();
            }else{
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container").showNotification();
            $('input#send-refer-me').removeAttr('disabled').removeClass('disabled');
        }, 'json')
        e.preventDefault();
    });
	
	$("form#post-comment").submit(function(e) {
        $('button#post-comment-button').attr('disabled', 'disabled');
        $('button#post-comment-button').addClass('disabled');
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "Comment Posted!" : "Comment not posted. Please try again later!";
            if(data.status) {
                $('textarea#comment-message').val('');
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
                $("div.comments").prepend(data.comment);
                $("p.nodata-message").remove();
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container").showNotification();
            $('button#post-comment-button').removeAttr('disabled');
            $('button#post-comment-button').removeClass('disabled');
        }, 'json');
        e.preventDefault();
    });
	
	$("button.reply-button").click(function(e) {
        var id = $(this).attr('id');
        var comment_id = id.substr(id.lastIndexOf('-') + 1);

        if(! $("textarea#reply-message-"+comment_id ).val().trim().length > 0){
            return false;
        }
        $('button#comment-reply-button-'+comment_id).attr('disabled', 'disabled');
        $('button#comment-reply-button-'+comment_id).addClass('disabled');

        $.post($('form#comment-reply-'+comment_id).attr('action'), $('form#comment-reply-'+comment_id).serialize(), function(data) {
            var heading = data.status ? "Comment Replied!" : "Comment not Replied. Please try again later!";
            if(data.status) {
            	if(isNaN(data.parent_comment_id)){
            		$("div.comments").prepend(data.comment);
            	}else{
            		$("form#comment-reply-"+data.parent_comment_id).before(data.comment);
            	}
                $('textarea#reply-message-'+comment_id).val('');
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
                
                $("p.nodata-message").remove();
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container").showNotification();

            $('button#comment-reply-button-'+comment_id).removeAttr('disabled');
            $('button#comment-reply-button-'+comment_id).removeClass('disabled');
        }, 'json');
        e.preventDefault();
    });


	
	$("a#send-message").showDialog();
	$("a#report-me").showDialog();
	$("a#refer-me").showDialog();
	
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


