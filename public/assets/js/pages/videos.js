$(document).ready(function() {
   
	 items = $("#home-middle-player div"),
    itemAmt = items.length;
      
    var w = 300;
    
    $('.ad-image').width(w);
    
    setInterval(function(){
       
        $('.ad-image').first().animate({
            marginLeft: -w 
        }, 'slow', function () {

            $(this).appendTo($(this).parent()).css({marginLeft: 0});
        });
    }, 10000);   

    $("#home-middle-left-scroller a").click(function(e) {
             e.preventDefault();
        $('.ad-image').first().animate({
            marginLeft: -w 
        }, 'slow', function () {

            $(this).appendTo($(this).parent()).css({marginLeft: 0});
        });
});

$("#home-middle-right-scroller a").click(function(e) {
            e.preventDefault();

        $('.ad-image').last().animate({
            marginLeft: +w 
        }, 'slow', function () {

            $(this).prependTo($(this).parent()).css({marginLeft: 0});
        });
}); 

items2 = $("#home-bottom-player div"),
    itemAmt2 = items2.length;
    console.log(itemAmt2);
      
    var w = 200;
    
    $('.ad-image-2').width(w);
    
    setInterval(function(){
       
        $('.ad-image-2').first().animate({
            marginLeft: -w 
        }, 'slow', function () {

            $(this).appendTo($(this).parent()).css({marginLeft: 0});
        });
    }, 5000);   

    $("#home-bottom-left-scroller a").click(function(e) {
             e.preventDefault();
        $('.ad-image-2').first().animate({
            marginLeft: -w 
        }, 'slow', function () {

            $(this).appendTo($(this).parent()).css({marginLeft: 0});
        });
});

$("#home-bottom-right-scroller a").click(function(e) {
            e.preventDefault();

        $('.ad-image-2').last().animate({
            marginLeft: +w 
        }, 'slow', function () {

            $(this).prependTo($(this).parent()).css({marginLeft: 0});
        });
}); 


	$("#view-more-anchor").click(function(){
        var $viewMoreAnchor = $(this);
        var currentPageNo = parseInt($viewMoreAnchor.data('page-no'));

        $.ajax({
	        method: "post",
	        url: $(this).attr("url"),
            data: {page_no: currentPageNo},
	        success: function (response) {  
	        	var responseJSON = JSON.parse(response);
	        	if (responseJSON.status) {
	        	    $(responseJSON.html).insertBefore("#videos-view-more");
                    $viewMoreAnchor.data('page-no', currentPageNo + 1);
	        	}
	        	if (responseJSON.identifier == 1) {
	        	    $("#videos-view-more").remove();
		        }
	        },
	        error: function () {
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


    $("#admin-notification").click();
});





