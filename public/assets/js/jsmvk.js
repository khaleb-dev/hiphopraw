$(document).ready(function() {
	 $(".alert").showAlert();
	 $(".alert i.close").closeAlert();
	 $(".send-chat-request").showInteractionConfirmationDialog();
	
	$("div.confirmation-dialog a.no-button").click(function(e) {
        e.preventDefault();
        $.closeDialogWindow();
    });
    var page = $('#page').val();
    $('#top-navigation-bar li').each(function(){
        $(this).removeClass('active');
        if ($(this).children('a').text().trim() == page){
            $(this).addClass('active');
        }
    });
    $('#white-container .top-list li a').click(function(e){
        var targetDiv = $(this).attr('data-target');
        $('.top-list li').removeClass('active');
        $(this).closest('li').addClass('active');
        $('.profile-tabs').addClass('hide');
        $(targetDiv).removeClass('hide');
        e.preventDefault();
    });
    var activeTab = $('#activeTab').val();
    $('#'+activeTab).addClass('active');

    $("#upgrade-hello-dialog").hide();
     $("#public-button-follow").click(function(){
            $("#upgrade-hello-dialog").show();              
          });
	/*$("#home-middle-left-scroller a, #home-middle-right-scroller a").click(function(e){
		e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$("#banner-items");
        var container_width = $("#visible-banners").width();
        var item_width = 300;
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
    });*/
	
	
    $("div#notification-container i.icon-remove-circle").click(function(e) {
        e.preventDefault();
        $("div#notification-container").fadeOut("fast");
    });

    $(".modal input[type=button]").click(function(e){
        e.preventDefault();
        $(this).closest('form').trigger("submit");
    });

    $("form#modal-message-form").submit(function(e) {
        console.log(this.action);

        e.preventDefault();
        $.post(this.action, $(this).serialize(), function(data) {
            console.log("hello");
            if (data.status) {
                $("div#notification-container div.detail h3").html(data.heading);
                $("div#notification-container div.detail p").html(data.message);
                
                $.clearModalForm();
                $("div.modal").modal('hide');
                
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            } else {
                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container div.detail h3").html(data.heading);
                var validation_error = "";
                for(var i = 0; i < data.validation.length; i++){
                    validation_error += "<p>" + data.validation[i] + "</p>";
                }
                $("div#notification-container div.detail p").html(validation_error);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        }, 'json').error(function(e) {
            console.log("hi we are here");
            //console.log(e);
            $("div#notification-container div.detail h3").html("Error!");
            $("div#notification-container div.detail p").html("Error occured while trying to send your message. Please try again.");

            $.clearModalForm();
            $("div.modal").modal('hide');
            
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });
    });
    
    
    $("form#follower-request-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            
            var heading = data.status ? "following!" : "Something Went Wrong!";
            $("div#notification-container div.detail h3").html(heading);
            $("div#notification-container div.detail p").html(data.message);
            $("form#follower-request-form").remove();
            $("div#notification-container").slideDown("fast", function(){
                setTimeout(function(){                    
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
            
        }, 'json').error(function() {
            
            $("div#notification-container div.detail h3").html("Error!");
            $("div#notification-container div.detail p").html("Error occured while trying to follow this person. Please try again.");
            $("div#notification-container").slideDown("fast", function(){
                setTimeout(function(){
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });

        e.preventDefault();
    });
    
    
    

    $("form#friend-request-form").submit(function(e) {
        $.post(this.action, $(this).serialize(), function(data) {
            
            var heading = data.status ? "Friend Request Sent!" : "Something Went Wrong!";
            var res = data.res;

            console.log(res['request_status']);
            console.log(res['email']);
            $("div#notification-container div.detail h3").html(heading);
            $("div#notification-container div.detail p").html(data.message);
            $("form#friend-request-form").remove();
            $("div#notification-container").slideDown("fast", function(){
                setTimeout(function(){                    
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
            
        }, 'json').error(function() {
            
            $("div#notification-container div.detail h3").html("Error!");
            $("div#notification-container div.detail p").html("Error occured while trying to send your friend request. Please try again.");
            $("div#notification-container").slideDown("fast", function(){
                setTimeout(function(){
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });

        e.preventDefault();
    });

    $.hideReadMoreLink();

    $("a#read-more").click(function(e){
        e.preventDefault();
        //$("span#more").toggle();
        if($(this).html() === "Read More"){
            $("span#more").fadeIn();
            $(this).html("Less");
        } else {
            $("span#more").fadeOut();
            $(this).html("Read More");
        }
    });

    $("#notifications-icons a").tooltip({
        placement: 'bottom'
    });  
});

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

$.clearModalForm = function(){
    $("div.modal input[type=text], div.modal textarea").val("");
};

$.hideReadMoreLink = function(){
    if($("p#about-me").length > 0 && $("p#about-me").html().length < 50){
        $("a#read-more").hide();
    }
};

$.fn.showInteractionConfirmationDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })

        //$(".overlay, .close-dialog").closeDialog();

        console.log($(this).data("confirmation-dialog"));

        var dialog_id = "#" + $(this).data("confirmation-dialog");
        //var profile_picture = $(this).data("profile-picture");
        var username = $(this).data("username");
        console.log(username);
        //$(".confirmation-dialog .dialog-content img.dialog-logo").attr("src", profile_picture);
        $(".confirmation-dialog .dialog-content p.username span").html(username);
        
        var from_member_id = $(this).data("from-member-id");
        var to_member_id = $(this).data("to-member-id");
        $yes_button = $("div.confirmation-dialog a.yes-button");
        $yes_button.data("username", username);

        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
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

$.fn.closeDialog = function(){
    $(this).click(function(e){
        e.preventDefault();
        $("body").append($(".overlay div.dialog"));
        $("div.dialog").hide();
        $(".overlay").detach();
    });
};

$.closeDialogWindow = function(){
    $("body").append($(".overlay div.dialog"));
    $("div.dialog").hide();
    $(".overlay").detach();
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