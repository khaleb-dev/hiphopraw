<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($user) && isset($current_user) && $user->id == $current_user->id) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $videokes_count)); ?>
        <?php } ?>
    </div>
    <div id="content" class="with-sidebar-left profile">
        <div class="content-box clearfix">
            <h3>All Videos(<?php echo $videokes_count; ?>)</h3>
            <div class="items videos">
                <?php $i = 0; ?>
                <?php foreach ($videokes as $videoke) { ?>
                    <div class="item" <?php echo ($i + 1) % 4 == 0 ? "class='last'" : ""; ?>>
                        <?php echo Html::anchor("videokes/show/" . $videoke->id, Html::img($videoke->get_picture($videoke->user, Model_Videoke::THUMB_CONTENT))); ?>
                        <h3><?php echo Html::anchor("videokes/show/" . $videoke->id, $videoke->title); ?></h3>
                        <p class="views">Views(<?php echo $videoke->views; ?>) By: <?php echo $videoke->user->username; ?></p>
                    </div>
                    <?php $i += 1; ?>
                <?php } ?>
                <?php if(count($videokes) > 5) { ?>
                    <p class="more"><?php echo Html::anchor("videokes/index/$user->id", "More Videos"); ?></p>
                <?php } ?>
            </div>
        </div>
        <div id="comments">
            <h2><span>Comments</span></h2>
            <div class="content-box">

                <?php if (!$current_user) { ?>
                    <p class="highlight-box">
                        <?php echo Html::anchor(Router::get("login"), "Sign in"); ?> now to post a comment!
                    </p>
                <?php } ?>

                <div class="comment-list">
                    <?php if (count($comments) > 0) { ?>
                        <?php echo View::forge("comments/partials/list", array("comments" => $comments, "addReplyLink" => true)); ?>
                        <?php if($comments_count > Model_User::PROFILE_COMMENTS_LIMIT) { ?>
                            <p class="more"><?php echo Html::anchor("/comments/index/$user->id", "View More"); ?></p>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="highlight-box">No comments made yet!</p>
                    <?php } ?>
                </div>				
            </div>
        </div>
    </div>

    
</div>