$(document).ready(function(){
    $(".date-picker").datepicker({
        format: 'yyyy-mm-dd'
    }); 


    $("#sponsor-delete").click(function(e){
    	var url = $(this).attr("url");
            console.log(url);
        $(".move-to-trash:checked").each(function(){
            var sponsor_id = $(this).data("sponsor-id");

            $.post(url, {
                sponsor_id: sponsor_id
            }, function(data){
                if(data.status){
                    $("#" + sponsor_id).fadeOut();
                } else {
                    console.log(data.message);
                }
                heading ="Delete Sponsor!";
                $("div#notification-container div.detail h3").html(heading);
                $("div#notification-container div.detail p").html(data.message);
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            }, "json").error(function() {

                $("div#notification-container div.detail h3").html("Error!");
                $("div#notification-container div.detail p").html("Error occured while trying to delete banner. Please try again.");
                $("div#notification-container").slideDown("fast", function() {
                    setTimeout(function() {
                        $("div#notification-container").fadeOut("slow");
                    }, 4000);
                });
            });
        });
        e.preventDefault();
    });   
});
