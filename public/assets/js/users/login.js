$(document).ready(function () {
    $("#login-form").submit(function () {
        console.log("login submitted");
        $("#login-form .error").hide();
        if (!hasLoginFormPassedValidation()) {
            e.preventDefault();
            return false;
        }
    });


});

function hasLoginFormPassedValidation() {

    var validationPassed = true;

    if (isEmpty($("#login-form .username").val())) {
        validationPassed = false;
        $("#login-form .username").parent().find("span.empty").css("display","block");
    } else {
        $("#login-form .username").parent().find("span.empty").hide();
    }


    if (isEmpty($("#login-form .password").val())) {
        validationPassed = false;
        $("#login-form .password").parent().find("span.empty").css("display","block");
    } else {
        $("#login-form .password").parent().find("span.empty").hide();
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
