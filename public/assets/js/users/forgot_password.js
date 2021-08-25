$(document).ready(function(){
    console.log("ready negn");
    $("#forget-password-form").submit(function(e){
        $("#forget-password-form .error").hide();
        if(!hasForgetPasswordFormPassedValidation()){
            e.preventDefault();
            console.log("validation failed");
            return false;
        }
        console.log("validation passed");
    });

});

function hasForgetPasswordFormPassedValidation(){
    var validationPassed=true;
    if (isEmail($("#forget-password-form #email").val())) {
        $("#forget-password-form #email").parent().find("span.invalid-email").hide();
        if (isLongerThan($("#forget-password-form #email").val(), 255)) {
            $("#forget-password-form #email").parent().find("span.too-long").css("display","block");
            validationPassed=false;
            console.log("validation failed too long");
        } else {
            $("#forget-password-form #email").parent().find("span.too-long").hide();
        }
    } else {
        validationPassed = false;
        console.log("validation failed invalid email");
        $("#forget-password-form #email").parent().find("span.invalid-email").css("display","block");
    }

    return validationPassed;
}

function isEmail(user_input) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(user_input);
}

function isEmpty(user_input) {
    return !!!user_input;
}