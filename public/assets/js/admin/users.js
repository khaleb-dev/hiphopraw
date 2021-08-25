$(document).ready(function() {
    $("form a").click(function(e) {
        var action_url = $(this).parent().parent().attr("action");
        var action = $(this).data("action");
        var item_id = "#user-" + $(this).data("user-id");
        var heading = "";
        var current_item = $(this);

        $.post(action_url, {
            user_id: $(this).data("user-id"),
            action: action
        }, function(data) {
            if(action === "Block"){
                current_item.data("action", "Unblock");
                current_item.attr("data-action", "Unblock");
                current_item.children().last().text("Unblock User");
                
                heading = "Block User!";
            } else if(action === "Unblock"){
                current_item.data("action", "Block");
                current_item.attr("data-action", "Block");
                current_item.children().last().text("Block User");
                
                heading = "Unblock User!";
            }
            
            // Show no users message if there aren't any
            // this should be changed when paging is implemented.
            if($(".items").children().length === 0 ){
                $(".items").append("<p class='highlight-box'>No Friends added yet!</p>");
            }

            $("div#notification-container div.detail h3").html(heading);
            $("div#notification-container div.detail p").html(data.message);
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });

        }, 'json').error(function() {

            $("div#notification-container div.detail h3").html("Error!");
            $("div#notification-container div.detail p").html("Error occured while trying to block user. Please try again.");
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });

        e.preventDefault();
    });
    $("#admin-notification").click();
});