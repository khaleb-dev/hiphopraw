$(document).ready(function() {

	$("#view-more-anchor").click(function(){
		var $viewMoreAnchor = $(this);
        var currentPageNo = parseInt($viewMoreAnchor.data('page-no'));

        $.ajax({
	        type: "POST",
	        url: $viewMoreAnchor.attr("url"),
            data: {page_no: currentPageNo},
	        success: function (response) {  
	        	var responseJSON = JSON.parse(response);
	        	//$("#friend-"+ sender_id).hide();
	        	//console.log(response.random_videokes);
	        	 if (responseJSON.status) {	
	        	    $(responseJSON.html).insertBefore(".profile-view-more");
                     $viewMoreAnchor.data('page-no', currentPageNo + 1);
	        	 }	
	        	 if (responseJSON.identifier == 1) {	
	        		 $(".profile-view-more").remove();
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
	});	

});