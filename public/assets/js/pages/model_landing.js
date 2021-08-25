var SUCCESS = "success";
var NO_ERROR = "NO_ERROR";
var UNKNOWN_ERROR = "UNKNOWN_ERROR";
var INPUT_VALIDATION_ERROR = "INPUT_VALIDATION_ERROR";
var CANNOT_SEND_EMAIL = "CANNOT_SEND_EMAIL";
var USER_NAME_ALREADY_TAKEN = "USER_NAME_ALREADY_TAKEN";
var EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER = "EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER";

var WRONG_CREDENTIALS = "WRONG_CREDENTIALS";
var USER_BLOCKED = "USER_BLOCKED";
var USER_INACTIVE = "USER_INACTIVE";



$(document).ready(function () {

 $(".sign-up-form .error").hide();
 $("div#sign-up-form-success").hide();
 $("div#sign-up-form-error").hide();


 $(".sign-up-form").submit(function () {
        console.log("sign up submitted");
        if (validateSignUpForm()) {
            submitSignUpForm();
            console.log("sign up form is ajaxed");
        } else {
            console.log("validationFailed");
        }
        return false;
    });




});



function validateSignUpForm() {
    $(".error").hide();
    var validationPassed = true;
    if (isEmpty($(".sign-up-form #first_name").val())) {
        validationPassed = false;
        $(".sign-up-form #first_name").parent().find("span.empty").show();
    } else {
        $(".sign-up-form #first_name").parent().find("span.empty").hide();
        if (isLongerThan($(".sign-up-form #first_name").val(), 255)) {
            $(".sign-up-form #first_name").parent().find("span.too-long").show();
        } else {
            $(".sign-up-form #first_name").parent().find("span.too-long").hide();
        }
    }

    if (isEmpty($(".sign-up-form #last_name").val())) {
        validationPassed = false;
        $(".sign-up-form #last_name").parent().find("span.empty").show();
    } else {
        $(".sign-up-form #last_name").parent().find("span.empty").hide();
        if (isLongerThan($(".sign-up-form #last_name").val(), 255)) {
            $(".sign-up-form #last_name").parent().find("span.too-long").show();
        } else {
            $(".sign-up-form #last_name").parent().find("span.too-long").hide();
        }
    }

    if (isEmpty($(".sign-up-form #username").val())) {
        validationPassed = false;
        $(".sign-up-form #username").parent().find("span.empty").show();
    } else {
        $(".sign-up-form #username").parent().find("span.empty").hide();
        if (isLongerThan($(".sign-up-form #username").val(), 255)) {
            $(".sign-up-form #username").parent().find("span.too-long").show();
        } else {
            $(".sign-up-form #username").parent().find("span.too-long").hide();
        }
    }



    if (isEmail($(".sign-up-form #email").val())) {
        $(".sign-up-form #email").parent().find("span.invalid-email").hide();
        if (isLongerThan($(".sign-up-form #email").val(), 255)) {
            $(".sign-up-form #email").parent().find("span.too-long").show();
        } else {
            $(".sign-up-form #email").parent().find("span.too-long").hide();
        }
    } else {
        validationPassed = false;
        $(".sign-up-form #email").parent().find("span.invalid-email").show();
    }

    if (isEmpty($(".sign-up-form #password").val())) {
        validationPassed = false;
        $(".sign-up-form #password").parent().find("span.empty").show();
    } else {
        $(".sign-up-form #password").parent().find("span.empty").hide();
        if (isLongerThan($(".sign-up-form #password").val(), 255)) {
            $(".sign-up-form #password").parent().find("span.too-long").show();
        } else {
            $(".sign-up-form #password").parent().find("span.too-long").hide();
        }
        if (passwordsMatch($(".sign-up-form #password").val(), $(".sign-up-form #confirm_password").val())) {
            $(".sign-up-form #confirm_password").parent().find("span.mismatch").hide();
        } else {
            validationPassed = false;
            $(".sign-up-form #confirm_password").parent().find("span.mismatch").show();
        }
    }
    if (isEmpty($(".sign-up-form #city").val())) {
        validationPassed = false;
        $(".sign-up-form #city").parent().find("span.empty").show();
    } else {
        $(".sign-up-form #city").parent().find("span.empty").hide();
        if (isLongerThan($("#city").val(), 255)) {
            $(".sign-up-form #city").parent().find("span.too-long").show();
        } else {
            $(".sign-up-form #city").parent().find("span.too-long").hide();
        }
    }
    return validationPassed;
}



function isEmpty(user_input) {
    return !!!user_input;
}

function isLongerThan(user_input, length) {
    try {
        return  user_input.length > length;
    } catch (err) {
        return false;
    }
}

function isEmail(user_input) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(user_input);
}

function passwordsMatch(pass1, pass2) {
    return pass1 === pass2;
}

function resetSignUpForm() {
    $(".sign-up-form .error").hide();
    $(".submit-wait").hide();
    $('.sign-up-form .input-field').val("");
}

function submitSignUpForm() {    


    var signUpFormOptions = {
        beforeSend: function () {
            console.log('i am here');
        },
        uploadProgress: function (event, position, total, percentComplete) {
            console.log('here i am again');

        },
        success: function (responseStr) {
            console.log('i guess i am here');
            //console.log(responseStr);
            responseJson = JSON.parse(responseStr);
            console.log(responseJson);
            console.log(responseJson.sign_up_status);
            if (responseJson.sign_up_status == SUCCESS) {
                console.log("sign up successful");
                $('.sign-up-form .input-field').val("");
               var heading = "";
               var message ="";
               heading ="Sign Up Successful";
               message = "A confirmation email has been sent to your email address. Please activate your account. <br/>If you dont find the email in your inbox, please check the spam folder."
               $("div#notification-container div.detail h3").html(heading);
               $("div#notification-container div.detail p").html(message);
               $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                      $("div#notification-container").fadeOut("slow");
                    }, 6000);
                });
                

            } else {
                console.log("sign up failed");
                $('.sign-up-form .input-field').val("");
                 var heading = "";
                 var message ="";
                 heading ="Sign Up Failed";
                 message = responseJson.error;
                        $("div#notification-container div.detail h3").html(heading);
                        $("div#notification-container div.detail p").html(message);
                        $("div#notification-container").slideDown("fast", function() {
                                setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                             }, 10,000);
                        });

            }
        },
        complete: function () {
             console.log('things are complete');
            //$(".submit-wait").hide();
        },
        error: function (response) {
            console.log("error");
             $('.sign-up-form .input-field').val("");
             var heading = "";
             var message ="";
             heading ="Sign Up Failed";
             message = response['error'];
            $("div#notification-container div.detail h3").html(heading);
            $("div#notification-container div.detail p").html(message);
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 6000);
            });
            
           
        }
    };
    $(".sign-up-form").ajaxSubmit(signUpFormOptions);
}



function handleSignUpErrors(responseJson) {
    if (responseJson.error === INPUT_VALIDATION_ERROR) {
        validateSignUpForm();
    }
    if (responseJson.error === USER_NAME_ALREADY_TAKEN) {
        $(".sign-up-form #username").parent().find("span.duplicate").show();
    }
    if (responseJson.error === EMAIL_ADDRESS_ALREADY_ASSOCIATED_WITH_ANOTHER_USER) {
        $(".sign-up-form #email").parent().find("span.duplicate").show();
    }
}
function openSignUpForm() {
    closeAllDialogs();

    $("div#login-sign-up-form-overlay").show();
    $("div#sign-up-container").show();
    $("form.sign-up-form").show();
    console.log("Signup form opened");
}

function closeSignUpForm() {
    $("form.sign-up-form").hide();
    $("div#sign-up-container").hide();
    $("div#login-sign-up-form-overlay").hide();
    resetSignUpForm();
}

function closeAllDialogs(){
    closeErrorDialog();
    closeSignUpForm();
    closeSignUpSuccessfulDialog();
}

function openSignupErrorDialog() {
    closeAllDialogs();
    $("div#login-sign-up-form-overlay").show();
    $("div#login-sign-up-form-overlay").attr("cancelable", "true");
    $("div#sign-up-container").show();
    $("div.sign-up-form-error").show();
    console.log("Signup error opened");
}

function closeErrorDialog() {
    $("div.sign-up-form-error").hide();
    $("div#sign-up-container").hide();
    $("div#login-sign-up-form-overlay").hide();
}

function openSignUpSuccessfulDialog() {
    //closeAllDialogs();
    //$("div#login-sign-up-form-overlay").show();
    //$("div#login-sign-up-form-overlay").attr("cancelable", "true");
   // $("div#sign-up-container").show();
    $("div#sign-up-form-success").show();
    console.log("Signup success opened");
}

function closeSignUpSuccessfulDialog() {
    $("div#sign-up-form-success").hide();
    $("div#sign-up-container").hide();
    $("div#login-sign-up-form-overlay").hide();
}