$(document).ready(function() {

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
 // clearInterval(autoSlide);
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

$("#left-arrow-contest a, #right-arrow-contest a").click(function(e){
		e.preventDefault();
        var direction = $(this).data("direction");
        var inner_container =$("#banner-contest-items");
        var container_width = $("#visible-banners-contest").width();
        var item_width = 368;
        var inner_width = inner_container.width();
        var max_left = Math.abs(container_width - inner_width);
        var current_left = inner_container.data('left');
        var new_left = 0;
        if(direction === "left"){        	
            new_left = current_left - item_width;
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
});