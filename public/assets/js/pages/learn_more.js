$(document).ready(function() {
$("#learn-more-new").click(function(){
		openSignUpForm();
		//window.scrollTo(0, 80);
        e.preventDefault();
	});	
	
}
function closeSignUpForm() {
      $("div#sign-up-container").hide();
      resetSignUpForm();
}
function closeAllDialogs(){
    closeErrorDialog();
    closeSignUpForm();
    closeSignUpSuccessfulDialog();
}
function openSignupErrorDialog() {
    closeAllDialogs();
     $("div#sign-up-container").show();
   }
   function closeErrorDialog() {
    $("div#sign-up-container").hide();
 }
 function openSignUpSuccessfulDialog() {
    closeAllDialogs();
     $("div#sign-up-container").show();
   }
   function closeSignUpSuccessfulDialog() {
      $("div#sign-up-container").hide();
   }
