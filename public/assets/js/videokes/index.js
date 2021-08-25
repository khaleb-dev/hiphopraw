$(document).ready(function () {


    $(".edit-video").click(function () {
        $(".grey-btn").hide();
        var videoke_id = $(this).data("id");
        var data = new Object();
        data.videoke_id = videoke_id;
        $.ajax({
            method: "post",
            url: $(this).attr("url"),
            data: data,
            success: function (response) {
                var responseJSON = JSON.parse(response);
                $(".videos").hide();
                $("#videoke_" + videoke_id).show();
                //if (responseJSON.identifer) {
                $(responseJSON.html).insertAfter("#videoke_" + videoke_id);
                //$(".no-message-data").remove();
                //$("div#notification-container div.detail h3").html("Success");
                //$("div#notification-container div.detail p").html(responseJSON.message);

                //  $.clearModalForm();
                // $("div.modal").modal('hide');

                /*$("div#notification-container").slideDown("fast", function() {
                 setTimeout(function() {
                 $("div#notification-container").fadeOut("slow");
                 }, 4000);
                 });*/

            },
            error: function () {
                $("div#notification-container div.detail h3").html("error");
                $("div#notification-container div.detail p").html("there is an error encountered.");

                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function () {
                    setTimeout(function () {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        });
    });


    $("form a.cancel-delete").click(function(e){
        e.preventDefault();
        $(this).parent().find("a.delete-video").data("state","ready");
        $(this).parent().find("a.delete-video").html("<span>Delete</span>");
        $(this).hide();
    });

    $(document).on('click','form a.delete-video', function (e) {
        e.preventDefault();
        if ($(this).data("state") === "deleting") {
            console.log("not allowed because already deleting this video");
            return false;
        } else if ($(this).data("state") === "ready") {
            console.log("State changed to Confirming");
            $(this).data("state", "confirming");
            $(this).html("<span>Confirm</span>");
            $(this).parent().find("a.cancel-delete").show();
            return false;
        } else if ($(this).data("state") === "confirming") {
            $(this).parent().find("a.cancel-delete").hide();
            console.log("State changed to deleting");
            $(this).data("state", "deleting");
            $(this).css("color", "grey");
            $(this).html("Deleting");

            var url = $(this).closest('form').attr('action');
            var id = $(this).data('id');

            $.post(url, {id: id},function (r) {
                $('div#videoke_' + id).remove();
                var numberOfVideos = $('#number-of-videos').html();
                $('#number-of-videos').html(numberOfVideos - 1);
//            $('h3.clearfix span.count').text(parseInt($('h3.clearfix span.count').text()) - 1);
//            $("div#notification-container div.detail h3").html('Success!');
//            $("div#notification-container div.detail p").html('Video is successfully deleted!');
//            $("div#notification-container").slideDown("fast", function() {
//                setTimeout(function() {
//                    $("div#notification-container").fadeOut("slow");
//                }, 4000);
//            });


            }).error(function (e) {
//            $("div#notification-container div.detail h3").html("Error!");
//            $("div#notification-container div.detail p").html("An unknown error occured while trying to delete video. Please try again later.");
//            $("div#notification-container").slideDown("fast", function() {
//                setTimeout(function() {
//                    $("div#notification-container").fadeOut("slow");
//                }, 4000);
//            });
                console.log("State changed to ready");
                alert("An unknown error occured while trying to delete video. Please try again later.");
                $(this).data("state", "ready");
                $(this).css("color", "black");
                $(this).html("Delete");
            });
            return false;
        }
    });

    $("#manage-videokes-button").click(function (e) {
        e.preventDefault();
        if ($(this).data("state") === 'editing') {
            exitEditingState();
        } else {
            enterEditingState();
        }
        console.log("manage videokes clicked");
        e.preventDefault();
        $(".actions").show();
        $("#manage-videokes div.clearfix").addClass('toggle_edit');
    });

});
function exitEditingState() {
    $("#manage-videokes-button").data("state", "done-editing");
    // hide the actions buttons
    $(".videos form").hide();
    //reset the  action buttons
    $(".delete-video").data("state", "ready");
    $(".delete-video").html("Delete");
    $(".cancel-delete").hide();

    $(".videos").css("height", "185px");
    $("#manage-videokes-button").html("Manage");
    $("#upload-video-form").hide();
    $(".divider").hide();
    $(".videos").show();
    $(".grey-btn").show();
}
function enterEditingState() {

    $("#manage-videokes-button").data("state", "editing");


    // show the actions buttons
    $(".videos").css("height", "220px");
    $(".videos form").show();
    $(".cancel-delete").hide();
    $("#manage-videokes-button").html("Done Managing");
}