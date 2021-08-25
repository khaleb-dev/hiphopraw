<div class="videos" id="videoke_<?= $videoke->id ?>">

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
        <span class="red">&nbsp;</span>
        <?php if($current_user) {?>

            <?php if($videoke->youtube_link == 1) { ?>
             
            <a href=" <?php echo Uri::create("videos/show") . "/" . $videoke->id; ?> ">   
               <div class="real-video">
                 <?php echo Html::img($videoke->get_youtube_picture($videoke->user,$videoke->thumb_name), array("width" => "172", "height" => "140")); ?>
                        <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                    </span>
                </div>
            </a>


            <?php } else {?>
                    <a href=" <?php echo Uri::create("videos/show") . "/" . $videoke->id; ?>">          
                         <div class="real-video">
                            <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT)); ?>
                            <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                            </span>
                         </div>
                    </a>
        
                    <?php } ?>
         <?php }else {?>
        
              <?php if($videoke->youtube_link == 1) { ?>



            <a href=" <?php echo Uri::create("pages/show") . "/" . $videoke->id; ?> ">   
                 <div class="real-video">
                 <?php echo Html::img($videoke->get_youtube_picture($videoke->user, $videoke->thumb_name), array("width" => "172", "height" => "140")); ?>
                    <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                    </span>
                </div>
            </a>
            <?php }else{?>
                 <a href=" <?php echo Uri::create("pages/show") . "/" . $videoke->id; ?>">          
                         <div class="real-video">
                        <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT)); ?>
                            <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                          </span>
                        </div>
                    </a>
             <?php } ?>
        <?php } ?>
  
     <?php }else {
        ?>
        <span class="red">This video is being processed!</span>
        <?php if($videoke->youtube_link == 1) { ?>

            <div class="real-video">

                 <?php echo Html::img($videoke->get_youtube_picture($videoke->user,$videoke->thumb_name), array("width" => "172", "height" => "140")); ?>
                        <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                          </span>
                 </div>


        <?php } else {?>
        <div class="real-video">
            <?php echo Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT)); ?>
                        <span class="play">
                            <?php echo Asset::img("playIcon.png"); ?>
                          </span>
        </div>
        <?php } ?>
    <?php
    }
    ?>
    <div class="like-reader">
        <p> <?php echo Asset::img("user/like.png"); ?> <?php echo $videoke->likes; ?></p>
    </div>
    <div class="preview-reader">
        <p><?php echo $videoke->views; ?> <?php echo Asset::img("user/preview.png"); ?></p>
    </div>
    <p class="model-name"><?php echo $videoke->title; ?></p>

    <p class="user-name-duration">
        <span class="user-name">By: <?php
        if($videoke->user->stage_name){
          echo $videoke->user->stage_name;
          }
        else{
        echo $videoke->user->username;
        }
         ?></span>
            <span class="how-long">
                <?php

                $upload_timestamp_seconds = $videoke->created_at;
                $upload_date = new DateTime();
                $upload_date->setTimestamp($upload_timestamp_seconds);
                //echo $upload_date->format('Y-m-d H:i:s') . "<br />";

                $now = new DateTime();
                //echo $now->format('Y-m-d H:i:s') . "<br />";
                $diff = $now->diff($upload_date);
                if ($diff->y == 1) {
                    echo $diff->y . " year ago";
                } elseif ($diff->y > 1) {
                    echo $diff->y . " years ago";
                } elseif ($diff->m == 1) {
                    echo $diff->m . " month ago";
                } elseif ($diff->m > 1) {
                    echo $diff->m . " months ago";
                } elseif ($diff->d == 1) {
                    echo $diff->d . " day ago";
                } elseif ($diff->d > 1) {
                    echo $diff->d . " days ago";
                } elseif ($diff->h == 1) {
                    echo $diff->h . " hour ago";
                } elseif ($diff->h > 1) {
                    echo $diff->h . " hours ago";
                } elseif ($diff->i == 1) {
                    echo $diff->i . " minute ago";
                } elseif ($diff->i > 1) {
                    echo $diff->i . " minutes ago";
                } elseif ($diff->s == 1) {
                    echo $diff->s . " second ago";
                } else {
                    echo $diff->s . " seconds ago";
                }
                ?>
            </span>
    </p>
    <?php echo View::forge("videokes/partials/action_buttons", array("videoke" => $videoke)); ?>
</div>

