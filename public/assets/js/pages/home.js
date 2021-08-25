$(document).ready(function() {

    $("#youtube-video").hide();
   
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
    }, 5000);   

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


$(".videos-home a").click(function(e) {

         e.preventDefault();

         video_id = $(this).data("video-id");
         url = $(this).attr("url");

         console.log("we are here");
         console.log(video_id);
         console.log(url);
         var base_url = $("#chat-base-url").text();

         $.ajax({
          type: "POST",
          url: url,
            data: {video_id: video_id},
          success: function (response) {  
            var responseJSON = JSON.parse(response);
             if (responseJSON.status) { 
               console.log(responseJSON.youtube);

                if(responseJSON.youtube == 1){

                  link = responseJSON.ulink;
                  console.log(link);
                         
                      $("#basic-playlist").hide();

                      $("#first-u-video").hide();
                      $("#youtube-video").show();

                     $("#youtube-video").html(link);

                }else{
                  link = base_url+'uploads/'+responseJSON.user_name +'/videokes/'+responseJSON.video+'.mp4';
                  poster_link = base_url+'uploads/'+responseJSON.user_name+'/videokes/thumb_172x114_'+responseJSON.video+'.jpg';
                  back_ground = base_url+'uploads/'+responseJSON.user_name+'/videokes/thumb_172x114_'+responseJSON.video+'.jpg';
                 

                      $("#youtube-video").hide();

                      $("#basic-playlist").show();


                      player = document.getElementById('basic-playlist');

                      video = document.getElementById('video');
                      source = document.getElementById('source');

                      console.log(link);
                      console.log(video);
                      console.log(source);

                      document.getElementById('basic-playlist').style.backgroundImage ='url('+back_ground+')';
                      $("#video").attr("poster", poster_link);
                      $("#video").attr("src", link);
                      if(video){
                       video.play();
                       }
                      
                }
               
             }  
             
          },
          error: function () {
            
          }
      });

});



/*var currentIndex = 0,
  items = $("#home-middle-player div"),
  itemAmt = items.length;
  console.log(itemAmt);
  console.log($("#visible-banners").width());

function cycleItems() {
  var item = $("#home-middle-player div").eq(currentIndex);
   $("#home-middle-player div").eq(currentIndex-1).hide();
  item.css('display','inline-block');
}

var autoSlide = setInterval(function() {
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
}, 10000);

$("#home-middle-left-scroller a").click(function(e) {
    e.preventDefault();
  clearInterval(autoSlide);
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
});

$("#home-middle-right-scroller a").click(function(e) {
    e.preventDefault();
  clearInterval(autoSlide);
  currentIndex -= 1;
  if (currentIndex < 0) {
    currentIndex = itemAmt - 1;
  }
  cycleItems();
}); 


*/


	$("#view-more-anchor").click(function(){
		var $viewMoreAnchor = $(this);
        var currentPageNo = parseInt($viewMoreAnchor.data('page-no'));

        $.ajax({
	        type: "POST",
	        url: $viewMoreAnchor.attr("url"),
          data: {page_no: currentPageNo},
	        success: function (response) {  
	        	var responseJSON = JSON.parse(response);
	        	//$("#friend-"+ sender_id).hide();
	        	//console.log(response.random_videokes);
	        	 if (responseJSON.status) {	
	        	    $(responseJSON.html).insertBefore("#home-view-more");
                     $viewMoreAnchor.data('page-no', currentPageNo + 1);
	        	 }	
	        	 if (responseJSON.identifier == 1) {	
	        		 $("#home-view-more").remove();
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
	
	$("#upload-button").click(function(){
		openSignUpForm();
		window.scrollTo(0, 140);
        e.preventDefault();
	});	
	
	$("#join-hip-pop-row").click(function(){
		openSignUpForm();
		 div_hide();
		//window.scrollTo(0, 80);
        e.preventDefault();
	});	
	$("#learn-more-new").click(function(){
	  div_show();

	 e.preventDefault();
	});

    $("#admin-notification").click();
});


function div_show() {
document.getElementById('abc').style.display = "block";
}
function div_hide() {
document.getElementById('abc').style.display = "none";
}
function check(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('abc');
var obj2 = document.getElementById('learn-more-new');
checkParent(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function checkParent(t) {
while (t.parentNode) {
if (t == document.getElementById('abc')) {
return false
} else if (t == document.getElementById('close')) {
return true
}
t = t.parentNode
}
return true
}

function closeSignUpForm() {
    $("form#sign-up-form").hide();
    $("div#sign-up-container").hide();
    $("div#login-sign-up-form-overlay").hide();
    resetSignUpForm();
}

function closeAllDialogs(){
    closeErrorDialog();
    closeSignUpForm();
    closeSignUpSuccessfulDialog();
}

function openSignupErrorDialog() {
    closeAllDialogs();
    $("div#login-sign-up-form-overlay").show();
    $("div#login-sign-up-form-overlay").attr("cancelable", "true");
    $("div#sign-up-container").show();
    $("div#sign-up-form-error").show();
    console.log("Signup error opened");
}

function closeErrorDialog() {
    $("div#sign-up-form-error").hide();
    $("div#sign-up-container").hide();
    $("div#login-sign-up-form-overlay").hide();
}

function openSignUpSuccessfulDialog() {
    closeAllDialogs();
    $("div#login-sign-up-form-overlay").show();
    $("div#login-sign-up-form-overlay").attr("cancelable", "true");
    $("div#sign-up-container").show();
    $("div#sign-up-form-success").show();
    console.log("Signup success opened");
}

function closeSignUpSuccessfulDialog() {
    $("div#sign-up-form-success").hide();
    $("div#sign-up-container").hide();
    $("div#login-sign-up-form-overlay").hide();
}



