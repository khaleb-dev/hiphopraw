$(document).ready(function() {
    $("#script a").click(function(e) {
        var action_url = $(this).parent().parent().attr("action");
        var action = $(this).data("action");
        var video_id = "#videoke-" + $(this).data("video-id");
        var heading = "";
        var current_item = $(this);

        $.post(action_url, {
            video_id: $(this).data("video-id"),
            action: action
        }, function(data) {
            if(action === "Block"){
                current_item.data("action", "Unblock");
                current_item.attr("data-action", "Unblock");
                current_item.children().last().text("Unblock");
                
                heading = "Block Video!";
            } else if(action === "Unblock"){
                current_item.data("action", "Block");
                current_item.attr("data-action", "Block");
                current_item.children().last().text("Block");
                
                heading = "Unblock Video!";
            } else if(action === "Delete"){
                heading ="Delete Video!";
                $(video_id).remove();
            }
            
            // Show no videos message if there aren't any
            // this should be changed when paging is implemented.
            if($(".items").children().length === 0 ){
                $(".items").append("<p class='highlight-box'>No videos uploaded yet!</p>");
            }

            $("div#notification-container div.detail h3").html(heading);
            $("div#notification-container div.detail p").html(data.message);
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });

        }, 'json').error(function() {

            $("div#notification-container div.detail h3").html("Error!");
            $("div#notification-container div.detail p").html("Error occured while trying to block/delete video. Please try again.");
            $("div#notification-container").slideDown("fast", function() {
                setTimeout(function() {
                    $("div#notification-container").fadeOut("slow");
                }, 4000);
            });
        });

        e.preventDefault();
    });
    $("#video-save-selected").click(function(e){
        var selected_videos = [];
        $(".check-each:checked").each(function(){
            var video_id = $(this).data("video-id");
            var page_name = $('#single_select_'+ video_id).val();
            selected_videos.push({
                video_id: video_id,
                page_name: page_name
            });
        });
        $.post($(".check-button").attr("url"), {
            selected_videos: JSON.stringify(selected_videos)
        } , function(response) {
            if(response.status){
                heading = "Feature Video!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(response.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        }, "json").error(function() {

                $("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured while trying to make videos featured. Please try again.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            });
        e.preventDefault();
    });

$("#featured b").click(function(e) {
    
    page = $(this).data("value");

    if(page=='home'){
    div_show1();
    }
    else if(page=='models'){
    div_show2();
    }
    else if(page=='news'){
    div_show3();
    }

});
$("#select_all_home").click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
    else{
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});

$("#select_all_models").click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
    else{
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});

$("#select_all_news").click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
    else{
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
}); 


$(".delete-features").click(function(e){
    var delete_videos = [];

    $('#check-feature:checked').each(function() {
            var  feature_id = $(this).data('value');          
             delete_videos.push({
                feature_id: feature_id
             });
             checkremove = 'tbody.check_feature_'+ feature_id;
             $(checkremove).fadeOut("fast");            
             console.log(checkremove);
                    
    });


    

    $.post($(".delete-features").attr("url"), {
            delete_videos: JSON.stringify(delete_videos)
        } , function(response) {
            if(response.status){  

                heading = "Delete Featured Video!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(response.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }
        }, "json").error(function() {

                $("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured while trying to delete featured videos.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            });
        e.preventDefault();

    });
});


function div_show1() {
document.getElementById('featured-videos-popup').style.display = "block";
}
function div_show2() {
document.getElementById('featured-videos-popup1').style.display = "block";
}
function div_show3() {
document.getElementById('featured-videos-popup2').style.display = "block";
}



function check(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('featured-videos-popup');
var obj2 = document.getElementById('btn');
checkParent(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function check1(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('featured-videos-popup1');
var obj2 = document.getElementById('btn');
checkParent1(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function check2(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('featured-videos-popup2');
var obj2 = document.getElementById('btn');
checkParent2(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}



function checkParent(t) {
while (t.parentNode) {
if (t == document.getElementById('featured-videos-popup')) {
return false
} else if (t == document.getElementById('close')) {
return true
}
t = t.parentNode
}
return true
}

function checkParent1(t) {
while (t.parentNode) {
if (t == document.getElementById('featured-videos-popup1')) {
return false
} else if (t == document.getElementById('close1')) {
return true
}
t = t.parentNode
}
return true
}

function checkParent2(t) {
while (t.parentNode) {
if (t == document.getElementById('featured-videos-popup2')) {
return false
} else if (t == document.getElementById('close2')) {
return true
}
t = t.parentNode
}
return true
}