flowplayer(function (api, root) {
    console.log("flow player api bind started");
    api.bind("resume", function(){
        var view_counted = $("#videoke-info").data("view-counted");
        console.log("resumed");
        if(view_counted === false){
            var vid = $("#videoke-info").data("videoke-id");
            var url = $("#videoke-info").data("update-count");
            var attr = $("#videoke-info").data("attr");
            var to_update = $("#videoke-info").data("to-update");

            $("#videoke-info").data("view-counted", "true");

            $.post(url, {id: vid, attr: attr}, function(data) {
                if (data.status) {
                    $(to_update).html(data.count);
                }
            }, 'json');
        }
        return true;
    });
    console.log("flow player api bind completed");
});

$(document).ready(function() {
	 $(".comment-reply-box").hide();
	 $(document).on('click','a.reply-to-comment', function(e){	        
	        var id = $(this).attr('id');
	        var comment_id = id.substr(id.lastIndexOf('-') + 1);
	        $("#reply-image-"+ comment_id).hide();
	        $("div#comment-div-" + comment_id).show();	            	            
	        //$.closeDialogWindow();
	        e.preventDefault();
	    });
	 $(document).on('click','a.remove-comment', function(e){
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
	$("#left-scroller a, #right-scroller a").click(function(e){
		e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$("#video-items");
        var container_width = $("#visible-videos").width();
        var item_width = 193;
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
    });
	
	
	
	   $("#post-comment").submit(function(e) {
	       // e.preventDefault();
		    var urll = $("#total-views").attr("url");
	        $.post(this.action, $(this).serialize(), function(data) {
	        	
	            if (data.status) {	            	
	            	$.get(urll + "/" + data.comment_id, null, function(ddata) {	
	                $(ddata.html).insertAfter("#comment-title"); 
	                $('#reply-to-comment-'+ data.comment_id).remove();
	                $('.show-nodata-comments').remove();
	                $("div#notification-container div.detail h3").html(data.heading);
	                $("div#notification-container div.detail p").html(data.description);

	                $.clearModalForm();
	                $("div.modal").modal('hide');

	                $("div#notification-container").slideDown("fast", function() {
	                    setTimeout(function() {
	                        $("div#notification-container").fadeOut("slow");
	                    }, 4000);
	                });
	            	}, 'json');
	            }
	            else {
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
	        }, 'json').error(function() {
	            $("div#notification-container div.detail h3").html("Error!");
	            $("div#notification-container div.detail p").html("Error occured while trying to post this comment. Please try again.");
	            
	            $.clearModalForm();
	            $("div.modal").modal('hide');

	            $("div#notification-container").slideDown("fast", function() {
	                setTimeout(function() {
	                    $("div#notification-container").fadeOut("slow");
	                }, 4000);
	            });
	        });
	        return false;
	    });
	   $(document).on('submit','.comment-reply', function(e){
		    var urll = $("#reply-id-holder").attr("url");
	        $.post(this.action, $(this).serialize(), function(data) {
	        	
	            if (data.status) {	            	
	            	$.get(urll + "/" + data.comment_id, null, function(ddata) {	
	                $(ddata.html).insertBefore("#comment-div-" + data.parent_comment_id); 	                	                
	                $("div#notification-container div.detail h3").html(data.heading);
	                $("div#notification-container div.detail p").html(data.description);

	                $.clearModalForm();
	                $("div.modal").modal('hide');

	                $("div#notification-container").slideDown("fast", function() {
	                    setTimeout(function() {
	                        $("div#notification-container").fadeOut("slow");
	                    }, 4000);
	                });
	            	}, 'json');
	            }
	            else {
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
	        }, 'json').error(function() {
	            $("div#notification-container div.detail h3").html("Error!");
	            $("div#notification-container div.detail p").html("Error occured while trying to post this comment. Please try again.");
	            
	            $.clearModalForm();
	            $("div.modal").modal('hide');

	            $("div#notification-container").slideDown("fast", function() {
	                setTimeout(function() {
	                    $("div#notification-container").fadeOut("slow");
	                }, 4000);
	            });
	        });
	        return false;
	    });
	  /* $(".comment-reply").submit(function(e) {
	        e.preventDefault();
	        $.post(this.action, $(this).serialize(), function(data) {
	        	
	            if (data.status) {
	                $("div#notification-container div.detail h3").html(data.heading);
	                $("div#notification-container div.detail p").html(data.description);               
	                $.clearModalForm();
	                $("div.modal").modal('hide');
	                $("textarea.message-text").val('');
	                $("div#notification-container").slideDown("fast", function() {
	                    setTimeout(function() {
	                        $("div#notification-container").fadeOut("slow");
	                    }, 4000);
	                });
	            } else {
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
	        }, 'json').error(function() {
	            $("div#notification-container div.detail h3").html("Error!");
	            $("div#notification-container div.detail p").html("Error occured while trying to post this reply. Please try again.");
	            
	            $.clearModalForm();
	            $("div.modal").modal('hide');

	            $("div#notification-container").slideDown("fast", function() {
	                setTimeout(function() {
	                    $("div#notification-container").fadeOut("slow");
	                }, 4000);
	            });
	        });
	        return false;
	    });
	*/
	
	
	$(".rating").click(function(){
		var rating = $(this).attr("value");
		var videoke_id = $("#form_id").attr("value");
		
		 var data = new Object();
		 data.rating = rating;
		 data.videoke_id = videoke_id;
		$.ajax({
	        method: "post",
	        url: $("#btn-rate").attr("url"),
	        data: data,
	        success: function (responseStr) {
	        	var responseJSON = JSON.parse(responseStr);
	        	$("div#notification-container div.detail h3").html(responseJSON.status);
                $("div#notification-container div.detail p").html(responseJSON.description);
                
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
                $("div#notification-container div.detail p").html("there is an error encountered while trying to rate the video.");
                
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
	
	
	
	$("#button-follow").click(function(){
		var current_user_id = $("#current-user-id").attr("value");
		var user_id = $("#user-id").attr("value");
		 var data = new Object();
		 data.current_user_id = current_user_id;
		 data.user_id = user_id;
		$.ajax({
	        method: "post",
	        url: $("#button-follow").attr("url"),
	        data: data,
	        success: function (responseStr) {
	        	var responseJSON = JSON.parse(responseStr);
	        	$("div#notification-container div.detail h3").html(responseJSON.status);
                $("div#notification-container div.detail p").html(responseJSON.message);
                
                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
	        	if(responseJSON.status = "success"){
	        		$('button#button-follow').html('FOLLOWING');
	        	}
	        },
	        error: function () {
	        	$("div#notification-container div.detail h3").html("error");
                $("div#notification-container div.detail p").html("there is an error encountered while trying to follow this user.");
                
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
	
	$("#hidden-element").hide();	
	$("#show-less").hide();
	$("#middle-text p#show-more").click(function(){
		    $("#hidden-element").show();
		    $("#show-more").hide();
		    $("#show-less").show();
		    
		  });
	 $("#middle-text p#show-less").click(function(){
		    $("#hidden-element").hide();
		    $("#show-less").hide();
		    $("#show-more").show();
		   	    
		  });
	 $("#upgrade-hello-dialog").hide();
	 $("#public-button-follow").click(function(){
		    $("#upgrade-hello-dialog").show();		   	    
		  });
	 $("#public-btn-rate").click(function(){
		    $("#upgrade-hello-dialog").show();		   	    
		  });
	 $("#public-comment-counter-img").click(function(){
		    $("#upgrade-hello-dialog").show();		   	    
		  });
	 $("#public-share-counter-img").click(function(){
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
	
    $("form#comment-form").submit(function(e) {

        $.post(this.action, $(this).serialize(), function(data) {
            if (data.status) {
                console.log("Comment added");
                $.get("/users/" + data.user_id + "/comments/show/" + data.comment_id, null, function(ddata) {
                    $(ddata.html).insertBefore("#comment-form");
                }, 'json');
                $("#be-the-first").remove();
            } else {
                $(".error").remove();
                $("<div class='error'>" + data.validation.detail + "</div>").insertBefore("#comment-form");
            }
        }, 'json').error(function() {
            $(".error").remove();
            $("<div class='error'>Error occured while trying to submit your comment. Please try again.</div>").insertBefore("#comment-form");
        });

        e.preventDefault();
    });

    /*$("video").on("play", function(e) {
        var vid = $(this).data("videoke-id");
        var url = $(this).data("update-count");
        var attr = $(this).data("attr");
        var to_update = $(this).data("to-update");

        $.post(url, {id: vid, attr: attr}, function(data) {
            if (data.status) {
                $(to_update).html(data.count);
            }
        }, 'json');
    });*/





    $("#like, #dislike").click(function(e) {
        e.preventDefault();
        var vid = $(this).data("videoke-id");
        var url = $(this).data("update-count");
        var attr = $(this).data("attr");
        var to_update = $(this).data("to-update");

        $.post(url, {id: vid, attr: attr}, function(data) {
            if (data.status) {
                $(to_update).html(data.count);
            }
        }, 'json');
    });

    $("#modal-invite-form").submit(function(e) {
        e.preventDefault();
        $.post(this.action, $(this).serialize(), function(data) {
        	
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
        }, 'json').error(function() {
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
        return false;
    });

});


$(document).ready(function() {
 $("#sent-message-read-more").click(function(){
	  div_show();
          e.preventDefault();
	});
  $("#sent-message-read-more-yt").click(function(){
	  div_show_yt();
          e.preventDefault();
	});

});
function div_show() {
document.getElementById('message').style.display = "block";
}
function div_show_yt() {
document.getElementById('message-yt').style.display = "block";
}
function div_hide() {
document.getElementById('message').style.display = "none";
}
function div_hide_yt() {
document.getElementById('message-yt').style.display = "none";
}

function check(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('message');
var obj2 = document.getElementById('sent-message-read-more');
checkParent(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function checkParent(t) {
while (t.parentNode) {
if (t == document.getElementById('message-yt')) {
return false
} else if (t == document.getElementById('close')) {
return true
}
t = t.parentNode
}
return true
}

function check1(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('message-yt');
var obj2 = document.getElementById('sent-message-read-more-yt');
checkParent1(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function checkParent1(t) {
while (t.parentNode) {
if (t == document.getElementById('message-yt')) {
return false
} else if (t == document.getElementById('close1')) {
return true
}
t = t.parentNode
}
return true
}

