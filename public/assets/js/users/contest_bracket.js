$(document).ready(function() {
     
     $("#hiphop-contest-list").hide();
     $("#model-contest-list").hide();
     $("#after-selection-hiphop").hide();
    $("#after-selection-model").hide();
     


     $("#hiphop-list").click(function(e){
            $("#videos-container").hide();
            $("#before-selection").hide();
            $(".info").hide();
            $("#thedivider").hide();
            // $("#after-selection-hiphop").show();
            $("#hiphop-contest-list").show();
        });
    $("#model-list").click(function(e){
        $("#videos-container").hide();
         $("#before-selection").hide();
         $(".info").hide();
         $("#thedivider").hide();
         // $("#after-selection-model").show();
        
        $("#model-contest-list").show();
     });

/*var item_width = 762;
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
    }); */

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





