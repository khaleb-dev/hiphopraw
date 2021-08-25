$(document).ready(function () {
    $("div#bottom-section #get-started-content #get-started-today a").click(function(e){
        e.preventDefault();
        $("#wrapper div#content div#build-profile-container #profile-picture-section").show();
        $("#wrapper div#content #build-profile-container div#bottom-section").show();
        $("div#bottom-section #get-started-content").hide();
        $("div#bottom-section #complete-profile-content").show();
        $("#wrapper div#content #build-profile-container #finish-container").hide();
    });

    $("div#bottom-section #complete-profile-content #finish-button-container a").click(function(e){
        e.preventDefault();
        $("#wrapper div#content div#build-profile-container #profile-picture-section").hide();
        $("#wrapper div#content #build-profile-container div#bottom-section").hide();
        $("div#bottom-section #get-started-content").hide();
        $("div#bottom-section #complete-profile-content").hide();
        $("#wrapper div#content #build-profile-container #finish-container").show();
    });
});


