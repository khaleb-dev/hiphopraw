$(document).ready(function () {

    $.fn.setNavigation();
    $("span#prev a, span#next a").moveSection();

    if($("a#profile-picture-container").data("picture-uploaded") == 0) {
        $("#upload-photo").click()
    }
});

$.fn.setNavigation = function () {
    var active_section = $("form section.active");
    var first_section = $("form section").first();
    var last_section = $("form section").last();

    if (active_section.attr("id") == first_section.attr("id")) {
        $("span#prev").removeClass("active");
    } else {
        $("span#prev").addClass("active");
    }

    if (active_section.attr("id") == last_section.attr("id")) {
        $("span#next").removeClass("active");
    } else {
        $("span#next").addClass("active");
    }

    $("div#upload-photo-dialog a#skip-button").click(function(e){
        e.preventDefault();
        $.closeDialogWindow();
    });
};

$.fn.focusForm = function () {
    var form_top = $("#profile-edit").position().top;
    $("body").animate({
        scrollTop: form_top - 20
    });
};

$.fn.setTitleText = function () {
    var active_section = $("section.active");
    $("#section-title").text(active_section.data("heading-text"));
    $("#nav-button").html(active_section.data("nav-button-text"));
    if (active_section.attr("id") === "your-match") {
        $("#nav-button").data("action", "submit");
    } else {
        $("#nav-button").data("action", "next");
    }
}

$.fn.moveSection = function () {
    $(this).click(function (e) {
        e.preventDefault();

        if ($(this).data("action") === "submit") {
            //Append is_completed field for the final submit
            var input = $("<input>").attr("type", "hidden").attr("name", "is_completed").val(1);
            $("form#edit-profile-form").append($(input)).submit();
        } else {

            if ($(this).data("action") == "next") {
                $.ajax({
                    type: "POST",
                    url: $("form#edit-profile-form").attr("action"),
                    data: $("form#edit-profile-form").serialize()
                });
            }

            var active_section = $("form section.active");
            var new_active_section;

            if ($(this).parent().attr("id") === "prev") {
                new_active_section = active_section.prev("section");
            } else {
                new_active_section = active_section.next("section");
            }

            active_section
                .hide()
                .removeClass("active");
            new_active_section
                .show()
                .addClass("active");

            $.fn.setTitleText();
            $.fn.focusForm();
            $.fn.setNavigation();
        }
    });
};