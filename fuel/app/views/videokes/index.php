<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($current_user) && $user->id == $current_user->id) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user, "friends" => $friends, "followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $count)); ?>
        <?php } ?>
    </div>

    <div class="videokes-center content-box clearfix" id="videos-content">
        <div class="vids">
            <div class="title">
                <p class="pull-left main-title">MY VIDEOS <span class="red">(<span id="number-of-videos"><?php echo sizeof($videokes); ?></span>)</span></p>

                <p class="pull-left middle-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <p class="pull-right right-button">
                    <a class="black-btn" id="manage-videokes-button" href="#" data-state="done-editing">Manage</a>
                    <a class="red-btn" href="<?php echo Uri::create('videos/new'); ?>">Add Video</a>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>

            <div class="video-list user-videos" id="manage-videokes">
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

			<div class="clearfix"></div>
		</div>


	</div>

	<div class="clearfix separator"></div>


</div>
