<div class="container">
    <?php if(count($banners) > 0): ?>
        <div class="header-slider" style="">
            <div id="left">
                <a href="#" data-direction="left"><?php echo Asset::img('left-slide-arrow.png'); ?> </a>
            </div>
            <div id="visible-top-videos">
                <div id="top-videos-items" class="clearfix" data-left="0" data-banners ="<?=count($banners)?>">
<!--                    <div id="main-image">-->
<!--                        <a href = "#">--><?php ////echo Asset::img('slide-image1.png'); ?><!-- </a>-->
<!--                    </div>-->
<!--                    <div id="main-image">-->
<!--                        <a href = "http://www.whereweallmeet.com">--><?php ////echo Asset::img('wwambanner.jpg'); ?><!-- </a>-->
<!--                        <a href = "#">--><?php ////echo Asset::img('hhr1.jpg'); ?><!-- </a>-->
<!--                    </div>-->
<!--                    <div id="main-image">-->
<!--                        <a href = "#">--><?php ////echo Asset::img('top100ad.jpg'); ?><!-- </a>-->
<!--                    </div>-->
                    
                    <?php foreach ($banners as $banner) : ?>
                        <div id="main-image">
                            <a href="<?php echo $banner->web_address; ?>" target="_blank"><?php echo Asset::img(Model_Banner::get_banner($banner)) ?></a>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <div id="right">
                <a href="#" data-direction="right"><?php echo Asset::img('right-slide-arrow.png'); ?> </a>
            </div>
            <div></div>
        </div>
    <?php endif; ?>
<div class="top-video-gallery">
    <div class="title">
        <p class="pull-left middle-title-setting">HHR <span class="red">TOP 100</span>
        </p>

        <p class="pull-left middle-title">HHR - The <span class="red">New</span> place for <span
                class="red">Hip Hop</span>
        </p>
        <br>

        <p>
        <hr style="height:1px;border:none;background-color:rgb(45,45,45); margin-left:0; margin-top:5px;width:100%; margin-top:0px;margin-bottom:0px;"/>
        </p>

    </div>
    <div class="video-gallery">
        <?php
        /*echo "<pre>";
        echo print_r($top_100_videos);
        echo "</pre>";*/
        $i=1;
        $number_of_videos = sizeof($top_100_videos);
        $displayed_videos = 0;
        foreach ($top_100_videos as $video) {
            $top_video_view = View::forge("videokes/partials/single_item");
            $top_video_view->videoke = $video;
            echo "<div class='video-with-descrip'>";
            echo '<div class="top_vid_rank">';
            echo '<span style="color: rgb(186,186,186)">#' . $i++ . '</span>';
            echo " </div>";

            echo $top_video_view;
            echo "</div >";
            $displayed_videos++;
            if ($displayed_videos > $number_of_videos || $displayed_videos >=30)
                break;
        }
        ?>
  <?php if($displayed_videos >= 30): ?>
        <div class="my_friend1">
            <p>
            <hr style="height:2px;border:none;background-color:#E3E3E3; margin-top:5px;;width:98%;"/>
            </p>           
            <div id="more-video"><p id = "view-more-anchor" url = "<?php echo Uri::create('users/top_video_show_more'); ?>">&or; more <span class="red">videos<span> </p></div>
        </div>
    <?php endif; ?>    
    </div>

</div>
</div>
</div>

</div>