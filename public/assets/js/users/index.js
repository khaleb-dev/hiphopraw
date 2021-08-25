$(document).ready(function(){

	$(".send-message-button").click(function(e){
		e.preventDefault();

		var username = $(this).data("username");
		var user_id = $(this).data("user-id");

		// Set user name
		$("#message-form-modal span#username").html(username);	
		 
		// Set user id
		$("#message-form-modal input#user-id").val(user_id);	

		// Pop open the message form
		$("#message-form-modal").modal('show');
	});

});