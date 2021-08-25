$(document).ready(function(){

	

	items = $("#home-middle-player div"),
    itemAmt = items.length;
    console.log(itemAmt);
      
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


	$(".scroller a").click(function(e){
		e.preventDefault();

		var direction = $(this).data("direction");
		
		var month = $(this).data("month");
		var month_row = $("#" + month);

		var container_width = $(".scroll-container").width();
		var item_width = 181;

		var inner_width = month_row.width();

		var max_left = Math.abs(container_width - inner_width);
		var current_left = month_row.data('left');
		var new_left = 0;

		if(direction === "left"){
			new_left = current_left - item_width;

			if(new_left >= -max_left){
				month_row.data('left', new_left);
				month_row.animate({
					left: new_left
				}, 'slow');
			}
		} else {
			new_left = current_left + item_width;

			if(new_left <= 0){
				month_row.data('left', new_left);
				month_row.animate({
					left: new_left
				}, 'slow');
			}

		}
	});

});