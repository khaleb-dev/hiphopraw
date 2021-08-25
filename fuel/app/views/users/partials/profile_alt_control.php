<div id="profile-control" class="sidebar-content profile-control content-box">
    <div>

        <a id="enter-video-contest" href="<?php echo Uri::create('users/my_contest').'/'.$current_user->id;?>"><?php echo Asset::img("enter_contest.png"); ?></a>

        <div class="username-holder">
        <a class="pull-right" href="<?php echo Uri::create('users/show')."/".$current_user->id;?>"><span id="view-profile" class="red"> <span class="red"> >> </span>View Profile</span></a>
        <p id="user-full-name"><?php echo $current_user->username; ?></p>
        </div>

        <div class="line-separator"></div>

        <div id="user-info-container">
            <div id="profile-picture">
               <?php echo Html::anchor("#", Html::img(Model_User::get_picture($current_user, "profile"))); ?> 
            </div>
            <div id="user-info">
                <?php if($current_user->facebook_link != '1'|| empty($current_user->facebook_link)): ?>
                <a href="<?php echo Uri::create('videos/index').'/' . $current_user->id;?>"><span class="block"><?php echo Asset::img("videos.png") ?>&nbsp; MY Videos</span></a>
                <?php endif; ?>
                <a href="<?php echo Uri::create('messages/index').'/'. Model_Message::INBOX .'/'. $current_user->id;?>"><span class="block"><?php echo Asset::img("messages.png") ?>&nbsp; MY Messages</span></a>
                <a href="<?php echo Uri::create('users/my_contest').'/'.$current_user->id;?>"><span class="block"><?php echo Asset::img("contests.png") ?>&nbsp; MY Contest</span></a>
                <!--<a href="<?php //echo Uri::create('pages/my_contests').'/'.$current_user->id;?>"><span class="block"><?php// echo Asset::img("contests.png") ?>&nbsp;Contests</span></a>-->
                <!-- <a href="#"><span class="block">&nbsp;<?php //echo Asset::img("likes.png") ?>&nbsp; MY Likes</span></a> -->
                <a href="<?php echo Uri::create('users/comments').'/' . $current_user->id;?>"><span class="block"><?php echo Asset::img("comments.png") ?>&nbsp; MY Comments</span></a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class ="left-sidebar-inner-wrapper">
            <span id="user-full-name"><a  href="<?php echo Uri::create('users/my_friends') ?>">Friends (<?php echo $friends_count;?>)</a></span>

            <div class="inner-line-separator"></div>

            <div class ="friends-container" id="friends-container">
              <?php if($friends):?>
               <?php $friends_display = 0;?>
                <?php foreach ($friends as $friend):?>
                <?php echo Html::anchor("users/show/" . $friend->id, Html::img(Model_User::get_picture($friend, "profile"))); ?> &nbsp; <span><?php echo Html::anchor("users/show/" . $friend->id, $friend->username);?></span>
                  <?php $friends_display++;?>  
                  <?php if($friends_display >= 5):?>
                  <?php break;?> 
                  <?php endif;?>            
                <?php endforeach;?>
                  <p class="see-all pull-right"> <a class="red" href="<?php echo Uri::create('users/my_friends') ?>">> See All</a></p>
                <?php else:?>
                <p class = "no-message-data-profile">You haven't added any friends yet!</p>
                <?php endif;?>

            </div>

            <span id="user-full-name">Categories</span>

            <div class="inner-line-separator"></div>

            <div id="friends-container" class="categories">

                <a href="<?php echo Uri::create("users/home");?>"><span class="block"><?php echo Asset::img("user/sidebar-vid.jpg") ?> Raw HIPHOP Videos</span></a>
                <a href="<?php echo Uri::create("users/model");?>"><span class="block"><?php echo Asset::img("user/sidebar-model.jpg") ?> Raw Elite Model Videos</span></a>
                <a href="<?php echo Uri::create("users/hhrnews");?>"><span class="block"><?php echo Asset::img("user/sidebar-top.jpg") ?> HHR News</span></a>
                <a href="<?php echo Uri::create("users/top_video");?>"><span class="block"><?php echo Asset::img("user/sidebar-elite.jpg") ?> HHR top 100 Videos</span></a>
               <!-- <a href="#"><span class="block"><?php //echo Asset::img("user/sidebar-contest.jpg") ?> HHR Contest</span></a>-->
                <a href="<?php echo Uri::create("users/contest_bracket");?>" ><span class="block"><?php echo Asset::img("user/sidebar-contest.jpg") ?>HHR Contest</a>

            </div>

            <span id="user-full-name"><a  href="<?php echo Uri::create('users/my_followers') ?>">Followers (<?php echo $followers_count;?>)</a></span>

            <div class="inner-line-separator"></div>

            <div class="friends-container">

               <?php if($followers):?>
                <?php $followers_display = 0;?>
                <?php foreach ($followers as $follower):?>
                <?php echo Html::anchor("users/show/" . $follower->id, Html::img(Model_User::get_picture($follower, "profile"))); ?> &nbsp; <span><?php echo Html::anchor("users/show/" . $follower->id, $follower->username);?></span>
                <?php $followers_display++;?>  
                  <?php if($followers_display >= 5):?>
                  <?php break;?> 
                  <?php endif;?>  
                <?php endforeach;?>
                <p class="see-all pull-right"> <a class="red" href="<?php echo Uri::create('users/my_followers') ?>">> See All</a></p>
                <?php else:?>
                <p class = "no-message-data-profile">You haven't added any followers yet!</p>

                <?php endif;?>
                <div class="clearfix"></div>
            </div>



            <!-- <div class="sidebar-transparent">
                <?php echo Asset::img("user/sidebar-transparent.jpg") ?>
            </div> -->
        </div>
    </div>
</div>
