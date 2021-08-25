$(document).ready(function() {
	 $(".actions").hide();
	 $("#hiphop-list").hide();
 	 $("#model-vid-list").hide();
 	 $(".after-selection-hiphop").hide();
 	  $(".after-selection-model").hide();
 	 


 	 $("#vid-list").click(function(e){
            $("#contest-time").hide();
 			$("#videos-container").hide();
 		    $(".before-selection").hide();
 		    $("#active-contests").hide();
 		     $(".after-selection-hiphop").show();
 			$("#hiphop-list").show();
 		});
    $("#model-list").click(function(e){
         $("#contest-time").hide();
 		$("#videos-container").hide();
 		 $(".before-selection").hide();
 		  $("#active-contests").hide();
 		  $(".after-selection-model").show();
 		$("#model-vid-list").show();
	 });
     $("#back-hiphop").click(function(e){
             $(".after-selection-hiphop").hide();
            $("#hiphop-list").hide();
             $("#contest-time").show();
            $("#videos-container").show();
            $(".before-selection").show();
            $("#active-contests").show();
    });
     $("#back-model").click(function(e){
            $(".after-selection-model").hide();
        $("#model-vid-list").hide();
        $("#videos-container").show();
        $(".before-selection").show();
     $("#active-contests").show();


    });

    $(".check-all-hiphop").click(function(e){

    				
        if(this.checked) { // check select status
            $('.check-each-hiphop').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.check-each-hiphop').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
   
    
	});

   $(".check-all-model").click(function(e){

    				
        if(this.checked) { // check select status
            $('.check-each-model').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.check-each-model').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
   
    
	});



    $("#hiphop-submit").click(function(e){
    	var selected_videos = [];
        $(".check-each-hiphop:checked").each(function(){
            var video_id = $(this).data("video-id");
            var contest_id=Number($(this).data("contest-id"));
            selected_videos.push({

            	video_id: video_id,
                contest_id: contest_id
                });

        });

        console.log( JSON.stringify(selected_videos));
        console.log("url is");
       	console.log($("#hiphop-submit").attr("url"));

        $.post( $("#hiphop-submit").attr("url"), { selected_videos: JSON.stringify(selected_videos) },
         function(response) {
            if(response.status){
                console.log("you did it");
                 heading = "Submit Contest Video!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(response.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        }, "json").error(function() {

        		$("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured your video may already be submitted to this contest.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });

            });
        e.preventDefault();

    });

	$("#model-submit").click(function(e){
    	var selected_videos = [];
        $(".check-each-model:checked").each(function(){
            var video_id = $(this).data("video-id");
            var contest_id=Number($(this).data("contest-id"));
            selected_videos.push({

            	video_id: video_id,
                contest_id: contest_id
                });

        });

        console.log( JSON.stringify(selected_videos));
        console.log("url is");
       	console.log($("#model-submit").attr("url"));

        $.post( $("#model-submit").attr("url"), { selected_videos: JSON.stringify(selected_videos) },
         function(response) {
            if(response.status){
                console.log("you did it");
                 heading = "Submit Contest Video!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(response.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        }, "json").error(function() {

        		$("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured your video may already be submitted to this contest.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });

            });
        e.preventDefault();

    });

	    $("form a").click(function(e) {
	        var status = $(this).data("status");
	        var action_url = $(this).parent().parent().attr("action");
	        var item_id = "#friend-" + $(this).data("item-id");
	       // var button_class = ".response-button-" + $(this).data("item-id");
	        var heading = "";


	        $.post(action_url, {
	            sender_id: $(this).data("sender-id"),
	            receiver_id: $(this).data("receiver-id"),
	            status: status
	        }, function(data) {

	            if(status === "blocked"){
	                heading ="Friend has been blocked!";
	                $.blockFriend(item_id);   
	            }else if(status === "deleted"){
	                heading= "Friend has been deleted!";
	                $.deleteFriend(item_id);
	            }

	            // Show no friends message if there aren't any
	            // this should be changed when paging is implemented.
	            /*if($("#manage-friends .items").children().length === 0 ){
	                $("#manage-friends .items").append("<p class='highlight-box'>No Friends added yet!</p>");
	            }
*/
	            /*if($("#new-friends .items").children().length === 0 ){
	                $("#new-friends .items").append("<p class='highlight-box'>No new Friend Requests sent yet!</p>");
	            }*/

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
	 
	 
	 
	$(".middle-title").click(function(e){
        e.preventDefault();
        if($(this).data("state") === 'editing'){
            $(this).data("state", "done editing");
            // Change text and icon of button
            $(this).html("MANAGE FRIEND");
            // hide the actions buttons
            $(".actions").hide();
        } else {
             $(this).data("state", "editing");
            // Change text and icon of button
            $(this).html("DONE MANAGING");
            // hide the actions buttons
            $(".actions").show();
        }
    });
		
	
	$("#arrow a, #right-arrow a").click(function(e){
		e.preventDefault();
        var direction = $(this).data("direction");       
        var inner_container =$("#friends-items");
        var container_width = $("#visible-friends").width();
        var item_width = 163;
        var inner_width = inner_container.width();       
        var max_left = Math.abs(container_width - inner_width);
        var current_left = inner_container.data('left');
        var new_left = 0;       
        if(direction === "left"){
            new_left = current_left - item_width;
            console.log(new_left);
            console.log(max_left);
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
	$('.latest-friends').hide();
	$(".middle-title-setting").hide();
	$("#chk_new").click(function(){
	    $(".latest-friends").toggle();
	    $(".middle-title-setting").toggle();
	  });
	
	$(".request").click(function(){
		var receiver_id = $(this).attr("to");
		var sender_id = $(this).attr("from");
		var status = $(this).attr("status");
		
		 var data = new Object();
		 data.receiver_id = receiver_id;
		 data.sender_id = sender_id;
		 data.status = status;
		$.ajax({
	        method: "post",
	        url: $("#right-arrow").attr("url"),
	        data: data,
	        success: function (response) {  
	        	var responseJSON = JSON.parse(response);
	        	$("#friend-"+ sender_id).hide();
	        	 if (responseJSON.identifer) {	
	        	 $(responseJSON.html).insertAfter("#reference");
	        	 $(".no-message-data").remove();
	        	 }
	        	$("div#notification-container div.detail h3").html("Success");
                $("div#notification-container div.detail p").html(responseJSON.message);
                
                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
	        
	        },
	        error: function () {
	        	$("div#notification-container div.detail h3").html("error");
                $("div#notification-container div.detail p").html("there is an error encountered.");
                
                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
	        }
	    });
	});
		
	
	
	
	
	
});



$.blockFriend = function(item_id){
    // Remove friend item from friend list
    $(item_id).remove();
    // Decrement the friend list count
   // $.changeCount(".friends-count", false);   
};

$.deleteFriend = function(item_id){
    // Remove friend item from friend list
    $(item_id).remove();
    // Decrement the friend list count
   // $.changeCount(".friends-count", false);   
};