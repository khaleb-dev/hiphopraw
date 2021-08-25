$(document).ready(function(){
	


	$(".message-reply-box").hide();


	$("a.reply-to-comment").on('click', function(e){	        
	        var id = $(this).attr('id');
	        var comment_id = id.substr(id.lastIndexOf('-') + 1);
	        $("#reply-image-"+ comment_id).hide();
	        $("div#comment-div-" + comment_id).show();	            	            
	        $.closeDialogWindow();
	        $(this).hide();
	        e.preventDefault();
	    }); 
	
	 $("a.remove-message").on('click', function(e){
	        $(this).css('background','none').html('deleting...');
	        var id = $(this).attr('id');
	        console.log(id);
	        var message_id = id.substr(id.lastIndexOf('-') + 1);
	        $.post($(this).attr('href'), null, function(response) {	        	
	            if(response.status) {
	                $("div#" + message_id).slideUp();

	            }
	            $.closeDialogWindow();
	        }, 'json');

	        e.preventDefault();
	    });
	 
	  $("a.remove-reply-message").on('click', function(e){
	        $(this).css('background','none').html('deleting...');
	        var id = $(this).attr('id');
	        console.log(id);
	        var message_id = id.substr(id.lastIndexOf('-') + 1);
	        $.post($(this).attr('href'), null, function(response) {	        	
	            if(response.status) {
	                $("div#reply-" + message_id).slideUp();

	            }
	            $.closeDialogWindow();
	        }, 'json');

	        e.preventDefault();
	    });
	
	
	
	 $("#message-delete-selected").click(function(e){
			
			$(".delete-each:checked").each(function(){
				var message_id = $(this).data("message-id");
				$.post($(".delete-button").attr('url') + message_id, null, function(response) {				
					if(response.status){
						$("#" + message_id).fadeOut();
					} 
				}, "json");
			});
			
			e.preventDefault();
		});
		

	
	
	$("#message-delete").click(function(e){
	if($('.move-to-trash').is(":checked")) {
		$(".delete-each").each(function(){
			var message_id = $(this).data("message-id");
			 $.post($(".delete-button").attr('url') + message_id, null, function(response) {
				if(response.status){
					$("div#" + message_id).fadeOut();
				} else {
					console.log(data.message);
				}
			}, "json");
		});
		
		e.preventDefault();
	}
	});
	
	
	
});

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