/**
 * Created by SileshiGezahegn on 9/19/14.
 */
flowplayer(function (api, root) {
    api.bind("resume", function(){
        var currentIndex=api.video.index;
        var title=$('.fp-playlist *[data-index='+currentIndex+"]").data("title");
        $("#featured-video-title").html(title);
        return true;
    });
});
