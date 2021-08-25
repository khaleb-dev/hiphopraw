$(document).ready(function() {

    $("#view-more-anchor").click(function() {
        $.ajax({
            method: "post",
            url: $(this).attr("url"),
            success: function(response) {
                var responseJSON = JSON.parse(response);
                //$("#friend-"+ sender_id).hide();
                //console.log(response.random_videokes);
                if (responseJSON.status) {
                    $(responseJSON.html).insertBefore(".my_friend1");
                }
                if (responseJSON.identifier == 1) {
                    $(".my_friend1").remove();
                }
            },
            error: function() {
                $("div#notification-container div.detail h3").html("error");
                $("div#notification-container div.detail p").html("there is an error encountered.");

                $.clearModalForm();
                $("div.modal").modal('hide');

                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        });
    });

    $("#left a, #right a").click(function(e) {
        e.preventDefault();
        var direction = $(this).data("direction");
        var inner_container = $("#top-videos-items");
        var container_width = $("#visible-top-videos").width();
        var item_width = 762;
        var inner_width = inner_container.width();
        var max_left = Math.abs(container_width - inner_width);
        var current_left = inner_container.data('left');
        var new_left = 0;
        if (direction === "left") {
            new_left = current_left - item_width;
            console.log(new_left);
            console.log(max_left);
            if (new_left >= -max_left) {
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        } else {
            new_left = current_left + item_width;
            if (new_left <= 0) {
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        }
    });



});





