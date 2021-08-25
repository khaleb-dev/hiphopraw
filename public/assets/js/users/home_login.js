$(document).ready(function(){
	
	 $("#upgrade-hello-dialog").hide();
	 
	/* $("#view-more-anchor").click(function(){
			$.ajax({
		        method: "post",
		        url: $(this).attr("url"),
		        success: function (response) {  
		        	var responseJSON = JSON.parse(response);
		        	//$("#friend-"+ sender_id).hide();
		        	//console.log(response.random_videokes);
		        	 if (responseJSON.status) {	
		        	 $(responseJSON.html).insertBefore(".more-comment");
		        	 }	
		        	 if (responseJSON.identifier == 1) {	
		        		 $(".more-comment").remove();
			        	 }	
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
		});*/
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 $(".public-button-request-container").click(function(){
		    $("#upgrade-hello-dialog").show();		   	    
		  });
	 $(".public-button-follower-container").click(function(){
		    $("#upgrade-hello-dialog").show();		   	    
		  });
	 $(".public-send-message").click(function(){
		    $("#upgrade-hello-dialog").show();		   	    
		  });
	 $(document).mouseup(function (e)
				{
				    var container = $("#upgrade-hello-dialog");

				    if (!container.is(e.target)
				        && container.has(e.target).length === 0) 
				    {
				        container.hide();
				    }
				});	
	 
	 $(".comment-reply-box").hide();
	 $("a.reply-to-comment").on('click', function(e){	        
	        var id = $(this).attr('id');
	        var comment_id = id.substr(id.lastIndexOf('-') + 1);
	        $("#reply-image-"+ comment_id).hide();
	        $("div#comment-div-" + comment_id).show();	            	            
	        $.closeDialogWindow();
	        e.preventDefault();
	    }); 
	 
	 $("a.remove-comment").on('click', function(e){
	        $(this).css('background','none').html('deleting...');
	        var id = $(this).attr('id');
	        var which = $(this).attr('url');
	        var comment_id = id.substr(id.lastIndexOf('-') + 1);

	        $.post($(this).attr('href'), null, function(response) {
	            if(response.status) {
	             if(which == 0) {
	                $("div#comment-" + comment_id).slideUp();
	             }
	             else{
	            	 $("div#reply-" + comment_id).slideUp(); 
	             }

	            }
	            $.closeDialogWindow();
	        }, 'json');

	        e.preventDefault();
	    });
	
	
	
    $('form a').click(function(e){
        var url = $(this).closest('form').attr('action');
        var id = $(this).data('id');
        $.post(url, {id: id},function(r){
            $('div#videoke_' + id).remove();
            $('h3.clearfix span.count').text(parseInt($('h3.clearfix span.count').text()) - 1);
            $("div#notification-container div.detail h3").html('Success!');
            $("div#notification-container div.detail p").html('Videoke was successfully deleted!');
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });

        }).error(function(e){
            $("div#notification-container div.detail h3").html("Error!");
            $("div#notification-container div.detail p").html("An unknown error occured while trying to respond to friend request. Please try again later.");
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });
    });

    /*$("#manage-videokes-button").click(function(e){
        e.preventDefault();
        $(".actions").show();
        $("#manage-videokes p.back a").addClass('toggle_edit');
    });

    $("#manage-videokes p.back a.toggle_edit").click(function(e){
        e.preventDefault();
        $(".actions").hide();
        $("#manage-videokes p.back a").removeClass('toggle_edit');
    });*/


    $("div#edit-videokes-button-container a").click(function(e){
        e.preventDefault();
        if($(this).data("state") === 'editing'){
            $(this).data("state", "done editing");
            // Change text and icon of button
            $(this).html("<i class='icon-edit'></i> Edit Videokes");
            // hide the actions buttons
            $(".item form").hide();
        } else {
             $(this).data("state", "editing");
            // Change text and icon of button
            $(this).html("<i class='icon-check'></i> Done Editing");
            // hide the actions buttons
            $(".item form").show();
        }
    });
});
