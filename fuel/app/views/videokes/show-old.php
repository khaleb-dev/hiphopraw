<div id="center" class="clearfix">
    <div id="content" class="with-sidebar-right">

        <div class="content-box">
           <span id="videoke-info" data-view-counted="false" data-videoke-id="<?php echo $videoke->id?>" data-update-count="<?php echo URI::create("videokes/update_count");  ?>" data-attr="views" data-to-update="#videoke-views"></span> 
           <div class="flowplayer first-frame" data-swf="player/flowplayer.swf"
                data-key="$400714113257224"
                data-logo="http://www.hiphopraw.com/assets/img/hhr-logo-large.png">
                <video preload="none" width="622" height="375" >
                    <?php foreach (Model_Videoke::get_formats() as $key => $value) { ?>
                        <source src="<?php echo $videoke->get_video($value['extension']); ?>" type='<?php echo $value['type']; ?>'/>
                    <?php } ?>
                </video>
            </div>
            <h2 id="videoke-title"><?php echo $videoke->title; ?></h2>
            <div id="owner-info" class="clearfix">
                <div id="profile-picture">
                    <?php echo Html::img(Model_User::get_picture($user, "message")); ?>	
                </div>
                <div id="general">
                    <p>
                        <?php echo Html::anchor("users/show/" . $user->id, $user->username, array("class" => "text")); ?>
                        <?php echo Html::anchor("videokes/index/" . $user->id, $videokes_count . " videokes", array("class" => "text")); ?> 
                    </p>
                    <?php if ($current_user) { ?>
                        <p>
                            <?php echo Html::anchor("users/show/" . $user->id, "<i class='icon-user'></i> View Profile", array("class" => "button grey")); ?>
                            <?php if($current_user->id != $user->id){ ?>
                                <?php echo View::forge("messages/partials/form_modal", array("user" => $user)); ?>
                            <?php } ?>
                            <?php echo View::forge("invites/partials/form", array("user" => $user, "videoke_id" => $videoke->id)); ?>
                        </p>
                    <?php } ?>
                </div>            		
                <div id="videoke-sepcific">
                    <h4>Views (<span id="videoke-views"><?php echo $videoke->views; ?></span>)</h4>
                    <?php echo View::forge("videokes/partials/ratings_stats", array("user" => $user, "videoke" => $videoke)); ?>
                    <p>
                        <?php echo View::forge("videokes/partials/rating_modal", array("user" => $user, "videoke" => $videoke)); ?>
                    </p>
                </div>
            </div>

            <div id="text-info">
                <p id="published">Published on <?php echo Date::forge($videoke->created_at)->format("%m %d, %Y"); ?> &nbsp; &nbsp;| &nbsp; &nbsp; Category: <?php echo $videoke->category->name; ?></p>

                <h4>Short Description:</h4>
                <p id="description">
                    <?php echo $videoke->description; ?>
                </p>
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
                        <?php echo View::forge("comments/partials/list", array("comments" => $comments)); ?>
                    <?php } else { ?>
                        <?php if ($current_user) { ?>
                            <p id="be-the-first" class="highlight-box">Be the first to comment on this Videoke!</p>
                        <?php } else { ?>
                            <p class="highlight-box">No comment made on this Videoke yet!</p>
                        <?php } ?>	
                    <?php } ?>
                </div>

                <?php if ($current_user) { ?>	
                    <?php echo View::forge("comments/partials/form", array("videoke" => $videoke)); ?>
                <?php } ?>				
            </div>
        </div> 
    </div>


    <div id="sidebar-right">
        <h2 id="watch-more">Watch More <?php echo $videoke->category->name; ?></h2>
        <div class="content-box">
            <?php if (count($category_videokes) > 0) { ?>
                <?php foreach ($category_videokes as $cat_videoke) { ?>
                    <?php $vid_owner = \Model\Auth_User::find($cat_videoke->user_id); ?>
                    <div class="category-videoke clearfix">
                        <?php echo Html::anchor("videokes/show/" . $cat_videoke->id, Html::img($cat_videoke->get_picture($vid_owner, Model_Videoke::THUMB_SIDEBAR))); ?>
                        <div>
                            <h5><?php echo Html::anchor("videokes/show/" . $cat_videoke->id, $cat_videoke->title); ?></h5>
                            <p>By: <?php echo Html::anchor("users/show/" . $vid_owner->id, $vid_owner->username); ?></p>
                            <p><?php echo $cat_videoke->views; ?> Views</p>
                        </div>
                    </div>				
                <?php } ?>
            <?php } else { ?>
                <?php echo '<p class="no-videokes">No more videos in this Category!</p>'; ?>
            <?php } ?>
        </div>	
    </div>
