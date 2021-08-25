$(document).ready(function () {
    $("p.more-less-button a").click(function(e){
        e.preventDefault();
        $(this).parent().parent().children("div.more-text").slideToggle();
        var moreAndLess = $(this).text() == 'Read More' ? 'Read Less' : 'Read More';
        $(this).text(moreAndLess);
    });
    $(".modal-container").click(function(e){
        e.stopPropagation();
    });
    $("#get-started-container #get-started-list div a").showDialog();
    $("#footer-section #footer-content p a").showDialog();
});

$.fn.showDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        });
        $(".overlay, button.close").closeDialog();
        var dialog_id = "#" + $(this).data("dialog");
        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};
$.fn.alignCenter = function() {
    var top =  $(window).scrollTop() + ($(window).height()/2 - $(this).height()/2);
    var left = $(window).width() / 2 - $(this).width() / 2;
    top = top <= 0 ? 10 : top;
    left = left <= 0 ? 10 : left;
    $(this).css({
        top: top,
        left: left
    });
};
$.fn.closeDialog = function(){
    $(this).click(function(e){
        e.preventDefault();
        $("body").append($(".overlay div.modal-container"));
        $("div.modal-container").hide();
        $(".overlay").detach();
    });
};