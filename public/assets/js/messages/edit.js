$(document).ready(function(){
	$("#form_is_draft").change(function(){
		if($(this).is(":checked")){
			$("p.submit input[type=submit]").val("Save Draft");
		} else {
			$("p.submit input[type=submit]").val("Send");
		}
	});
});
