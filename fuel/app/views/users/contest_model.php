<div id="center" style="width:1100px;" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends" => $friends, "followers" => $followers, "friends_count" => $friends_count, "followers_count" => $followers_count)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>


    <div class="my-contest-gallery videokes-center contet-box clearfix">

            <div id="submit-video">
                <a>Submit a video to <span class="red">current contest</span> </a>
               <!-- <a class="button1 pull-right">Join Contest</a>-->
                
            </div>


            <div class="video-list" id="manage-videokes">
                <?php
                if (isset($videokes)) {
                    //                echo "<pre>";
                    //                print_r($videokes);
                    //                echo "</pre>";
                    if (sizeof($videokes) > 0) {
                        foreach ($videokes as $videoke) {
                            $view = View::forge('videokes/partials/single_item');
                            $view->videoke = $videoke;
                            echo $view;
                        }
                    } else {
                        echo "No Videos uploaded yet";
                    }
                } else {
                    echo "No Videos uploaded";
                }
                ?>
                <div class="clearfix"></div>
            </div>
     <div class="right-image">
    <div id="image1-right">
        <a>SUGGESTED ADVERTISEMENT</a>
    </div>
    <div id="image1-right1"><a><?php echo Asset::img('advert-1.jpg'); ?></a></div>
    <div id="image2-right1"><a><?php echo Asset::img('banckmarck.png'); ?></a></div>
    <div id="image3-right1"><a><?php echo Asset::img('advert-3.jpg'); ?></a></div>
</div>

</div>
    </div>       