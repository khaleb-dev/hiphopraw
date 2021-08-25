$(document).ready(function() {

	 $("#upgrade-hello-dialog").hide();
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
	
   
 
});
