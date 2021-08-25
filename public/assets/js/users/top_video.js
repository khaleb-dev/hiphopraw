$(document).ready(function() {

   



   
	$("#view-more-anchor").click(function(){
		$.ajax({
	        method: "post",
	        url: $(this).attr("url"),
	        success: function (response) {  
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

   /* var item_width = 762;
    var banner_count = $("#top-videos-items div").length;
    $("#top-videos-items").width(item_width * banner_count);

	$("#left a, #right a").click(function(e){
		e.preventDefault();
        var direction = $(this).data("direction");       
        var inner_container =$("#top-videos-items");
        var container_width = $("#visible-top-videos").width();

        var inner_width = inner_container.width();       
        var max_left = Math.abs(container_width - inner_width);
        var current_left = inner_container.data('left');
        var new_left = 0;       
        if(direction === "left"){
            new_left = current_left - item_width;
            console.log(new_left);
            console.log(max_left);
            if(new_left >= -max_left){
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        } else {
            new_left = current_left + item_width;
            if(new_left <= 0){
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        }
    }); 

 setInterval(function(){
    var inner_container =$("#top-videos-items");
    var banners = inner_container.data('banners');
     
     if banners 
             $('#left a').click();
       
        }

        if(i>banners){
          for(j=banners; j>=0; j--){
            $('#right a').click(); 
       
           }  
           if(j==0){
             i=0;
           }
        }                
      

  },10000); */

var currentIndex = 0,
  items = $("#top-videos-items div"),
  itemAmt = items.length;

function cycleItems() {
  var item = $("#top-videos-items div").eq(currentIndex);
  items.hide();
  item.css('display','inline-block');
}

setInterval(function() {
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
}, 10000);

$("#left a").click(function() {
  //clearInterval(autoSlide);
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
});

$("#right a").click(function() {
 // clearInterval(autoSlide);
  currentIndex -= 1;
  if (currentIndex < 0) {
    currentIndex = itemAmt - 1;
  }
  cycleItems();
});



	
	
	
});





