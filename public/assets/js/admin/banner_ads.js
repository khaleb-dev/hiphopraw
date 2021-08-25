$(document).ready(function(){
	
    $("#notification-delete").click(function(e){
        var url = $(this).attr("url");
            console.log(url);
        $(".move-to-trash:checked").each(function(){
            var notification_id = $(this).data("notification-id");
            $.post(url, {
                notification_id: notification_id
            }, function(data){
                if(data.status){
                    $("#" + notification_id).fadeOut();
                } else {
                    console.log(data.message);
                }
                heading ="Delete Notification!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(data.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }, "json").error(function() {

                $("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured while trying to delete Notification. Please try again.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            });
        });
        e.preventDefault();
    });
    
    $("#banner-delete").click(function(e){
        var url = $(this).attr("url");
            console.log(url);
        $(".banner-move-to-trash:checked").each(function(){
            var banner_id = $(this).data("banner-id");
            $.post(url, {
                banner_id: banner_id
            }, function(data){
                if(data.status){
                    $("#" + banner_id).fadeOut();
                } else {
                    console.log(data.message);
                }
                heading ="Delete Banner!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(data.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }, "json").error(function() {

                $("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured while trying to delete banner. Please try again.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            });
        });
        e.preventDefault();
    });
	
});
