<div class="videos-home" id="videoke_<?= $videoke->id ?>">

    <!--        <div class="time-reader">-->
    <!--            <p>02:52</p>-->
    <!--        </div>-->

    <!--    change the code below with the call from the videoke object, i.e. $is_processed=$videoke->is_processed();-->
    <?php
    if (!function_exists('hasVideoFinishedProcessing')) {
        function hasVideoFinishedProcessing($video)
        {
            $now = new DateTime();
            $now_timestamp_seconds = $now->getTimestamp();
            $upload_timestamp_seconds = $video->created_at;
            $ten_minutes_in_seconds = 10 * 60;
            return (($now_timestamp_seconds - $upload_timestamp_seconds) > $ten_minutes_in_seconds);
        }
    }

    ?>

    <?php
    $is_processed = hasVideoFinishedProcessing($videoke);
    if ($is_processed) {

        ?>
       
        <?php if($current_user) {?>

            <?php if($videoke->youtube_link == 1) { ?>
             
            <a href=" " url=" <?php echo Uri::create("pages/get_video_info"); ?> " data-video-id="<?=$videoke->id; ?>">
               <div class="real-video-home">
                 <?php echo Html::img($videoke->get_youtube_picture($videoke->user,$videoke->thumb_name), array("width" => "172", "height" => "140")); ?>
                  
                </div>
                    <span class="play">
                        <?php echo Asset::img("playIcon.png"); ?>
                      </span>
            </a>


            <?php } else {?>
                    <a href=" " url=" <?php echo Uri::create("pages/get_video_info"); ?> " data-video-id="<?=$videoke->id; ?>">    
                         <div class="real-video-home">
                            <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_HOME), array("width" => "172", "height" => "140")); ?>
                         </div>
                          <span class="play">
                        <?php echo Asset::img("playIcon.png"); ?>
                      </span>
                    </a>
        
                    <?php } ?>
         <?php }else {?>
        
              <?php if($videoke->youtube_link == 1) { ?>



            <a href=" " url=" <?php echo Uri::create("pages/get_video_info"); ?> " data-video-id="<?=$videoke->id; ?>">
                 <div class="real-video-home">
                 <?php echo Html::img($videoke->get_youtube_picture($videoke->user, $videoke->thumb_name)); ?>
                    <span class="play">
                        <?php echo Asset::img("playIcon.png"); ?>
                      </span>
                </div>
            </a>
            <?php }else{?>
                 <a href=" " url=" <?php echo Uri::create("pages/get_video_info"); ?> " data-video-id="<?=$videoke->id; ?>">          
                         <div class="real-video-home">
                          <!-- <div class="non-youtube"> -->
                        <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_HOME)); ?>

                          <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                          </span>
                        <!-- </div> -->
                        </div>
                    </a>
             <?php } ?>
        <?php } ?>
  
     <?php }else {
        ?>
        <span class="red">This video is being processed!</span>

        <div class="real-video-home">
            <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_HOME), array("width" => "400", "height" => "200")); ?>
            <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
            </span>
        </div>
    <?php
    }
    ?>
    
    
    
</div>

