$(document).ready(function(){
 $("#hihop-list").hide();
 $("#model-vid-list").hide();

 $("#vid-list").click.function(){
 	$("#videos-container").hide()
 	$("#hihop-list").show();
 }
 $("#model-list").click.function(){
 	$("#videos-container").hide()
 	$("#model-vid-list").show();
 }


});