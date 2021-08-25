$(document).ready(function(){
    $(".date-picker").datepicker({
	    format: 'mm-dd-yyyy'
	});

    $('#edit-form').submit(function () {
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

    if (isEmpty($("#edit-form #first_name").val())) {
        validationPassed = false;
        $("#edit-form #first_name").parent().find("span.empty").css("display", 'block');
    } else {
        $("#edit-form #first_name").parent().find("span.empty").css("display", 'none');
        if (isLongerThan($("#edit-form #first_name").val(), 255)) {
            $("#edit-form #first_name").parent().find("span.too-long").css("display", 'block');
        } else {
            $("#edit-form #first_name").parent().find("span.too-long").css("display", 'none');
        }
    }

    if (isEmpty($("#edit-form #last_name").val())) {
        validationPassed = false;
        $("#edit-form #last_name").parent().find("span.empty").css("display", 'block');
    } else {
        $("#edit-form #last_name").parent().find("span.empty").css("display", 'none');
        if (isLongerThan($("#edit-form #last_name").val(), 255)) {
            $("#edit-form #last_name").parent().find("span.too-long").css("display", 'block');
        } else {
            $("#edit-form #last_name").parent().find("span.too-long").css("display", 'none');
        }
    }
    
    if (isEmpty($("#edit-form #city").val())) {
        validationPassed = false;
        $("#edit-form #city").parent().find("span.empty").css("display", 'block');
    } else {
        $("#edit-form #city").parent().find("span.empty").css("display", 'none');
        if (isLongerThan($("#city").val(), 255)) {
            $("#edit-form #city").parent().find("span.too-long").css("display", 'block');
        } else {
            $("#edit-form #city").parent().find("span.too-long").css("display", 'none');
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