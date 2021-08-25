$(document).ready(function() {

    $("form a").click(function(e) {
        var status = $(this).data("status");
        var action_url = $(this).parent().parent().attr("action");
        var item_id = "#friend-" + $(this).data("item-id");
        var button_class = ".response-button-" + $(this).data("item-id");
        var heading = "";


        $.post(action_url, {
            sender_id: $(this).data("sender-id"),
            receiver_id: $(this).data("receiver-id"),
            status: status
        }, function(data) {

            if(status === "accepted"){
                heading = "Friend Request Accepted!";
                $.acceptRequest(item_id);
            }else if(status === "rejected"){
                heading ="Friend Request Rejected!";
                $.rejectRequest(item_id);
            }else if(status === "blocked"){
                heading ="Friend has been blocked!";
                $.blockFriend(item_id);   
            }else if(status === "deleted"){
                heading= "Friend has been deleted!";
                $.deleteFriend(item_id);
            }

            // Show no friends message if there aren't any
            // this should be changed when paging is implemented.
            if($("#manage-friends .items").children().length === 0 ){
                $("#manage-friends .items").append("<p class='highlight-box'>No Friends added yet!</p>");
            }

            if($("#new-friends .items").children().length === 0 ){
                $("#new-friends .items").append("<p class='highlight-box'>No new Friend Requests sent yet!</p>");
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
            $("div#notification-container div.detail p").html("Error occured while trying to respond to friend request. Please try again.");
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });

        e.preventDefault();
    });

    $("form a").mouseenter(function(e) {
        var text = $(this).data("text");
        $("<div id='button-action'></div>")
                .css('left', e.pageX + 10)
                .css('top', e.pageY - 30)
                .html(text)
                .appendTo("body")
                .fadeIn();
    });

    $("form a").mouseleave(function(e) {
        $("#button-action").remove();
    });

    $("form a").mousemove(function(e) {
        $("#button-action")
                .css('left', e.pageX + 10)
                .css('top', e.pageY - 30);
    });

    $("div#edit-friends-button-container a").click(function(e){
        e.preventDefault();
        if($(this).data("state") === 'editing'){
            $(this).data("state", "done editing");
            // Change text and icon of button
            $(this).html("<i class='icon-edit'></i> Edit Friends");
            // hide the actions buttons
            $("div#manage-friends .item form").hide();
        } else {
             $(this).data("state", "editing");
            // Change text and icon of button
            $(this).html("<i class='icon-check'></i> Done Editing");
            // hide the actions buttons
            $("div#manage-friends .item form").show();
        }
    });


});

$.rejectRequest = function(item_id){
    // Remove friend item from pending list
    $(item_id).remove();
    // Decrement the pending list count
    $.changeCount(".pending-count", false);
}

$.acceptRequest = function(item_id){
    // Move friend item from pending list to friends list
    $("#manage-friends .items p").remove();
    $(item_id).appendTo("#manage-friends .items");
    // Decrement the pending list count
    $.changeCount(".pending-count", false);
    // Increment the friend list counts
    $.changeCount(".friends-count", true);

    // Remove accept/reject action buttons
    $(item_id + " form.accept-reject").remove();

    // Show block/delete action buttons
    $(item_id + " form.pending").removeClass("pending");
};

$.blockFriend = function(item_id){
    // Remove friend item from friend list
    $(item_id).remove();
    // Decrement the friend list count
    $.changeCount(".friends-count", false);   
};

$.deleteFriend = function(item_id){
    // Remove friend item from friend list
    $(item_id).remove();
    // Decrement the friend list count
    $.changeCount(".friends-count", false);   
};

$.changeCount = function(class_selector, up){
   $(class_selector).each(function(){
        var count = $(this).text() * 1;
        if(up){
           $(this).text(count + 1); 
       } else {
           $(this).text(count - 1);
       }
        
    });
};
