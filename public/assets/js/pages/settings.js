$(function () {
    $("#old_password").keyup(function(){

        if(isEmpty($('#old_password').val())){
            $('#password-settings p b.required-ast').css("display", 'none');
            console.log("current password input field value empty");
        }else{
            $('#password-settings p b.required-ast').css("display", 'inline');
            console.log("current password input field value not empty");
        }
    });

    $('#settings-form').submit(function () {
        $(".error").css("display", 'none');
        if (hasFormPassedValidation()) {
            console.log("validation passed");
        } else {
            console.log("validation failed");
            return false;
        }
    });
});

function hasFormPassedValidation() {

    var validationPassed = true;

    if (isEmail($("#settings-form #email").val())) {
        $("#settings-form #email").parent().find("span.invalid-email").css("display", 'none');
        if (isLongerThan($("#settings-form #email").val(), 255)) {
            $("#settings-form #email").parent().find("span.too-long").css("display", 'block');
        } else {
            $("#settings-form #email").parent().find("span.too-long").css("display", 'none');
        }
    } else {
        validationPassed = false;
        $("#settings-form #email").parent().find("span.invalid-email").css("display", 'block');
    }
    if (!isEmpty($('#old_password').val())) {
        if (isEmpty($("#settings-form #new_password").val())) {
            validationPassed = false;
            $("#settings-form #new_password").parent().find("span.empty").css("display", 'block');
        } else {
            $("#settings-form #new_password").parent().find("span.empty").css("display", 'none');
            if (isLongerThan($("#settings-form #new_password").val(), 255)) {
                $("#settings-form #new_password").parent().find("span.too-long").css("display", 'block');
            } else {
                $("#settings-form #new_password").parent().find("span.too-long").css("display", 'none');
            }
            if (passwordsMatch($("#settings-form #new_password").val(), $("#settings-form #confirm_password").val())) {
                $("#settings-form #confirm_password").parent().find("span.mismatch").css("display", 'none');
            } else {
                validationPassed = false;
                $("#settings-form #confirm_password").parent().find("span.mismatch").css("display", 'block');
            }
        }
    }
    if (isEmpty($("#settings-form #city").val())) {
        validationPassed = false;
        $("#settings-form #city").parent().find("span.empty").css("display", 'block');
    } else {
        $("#settings-form #city").parent().find("span.empty").css("display", 'none');
        if (isLongerThan($("#city").val(), 255)) {
            $("#settings-form #city").parent().find("span.too-long").css("display", 'block');
        } else {
            $("#settings-form #city").parent().find("span.too-long").css("display", 'none');
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