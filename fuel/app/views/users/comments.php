<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php if (isset($current_user) && $user->id == $current_user->id) { ?>
            <?php echo View::forge("users/partials/profile_alt_control", array("user" => $user, "friends" => $friends, "followers" => $followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>
        <?php } else { ?>
            <?php echo View::forge("users/partials/profile_connect_control", array("user" => $user, "videokes_count" => $count)); ?>
        <?php } ?>
    </div>

    <div class="videokes-center content-box clearfix comments-videokes">
        <div class="message-title">
            <div class="title">
                <p class="pull-left main-title">MY COMMENTS</p>

                <p class="pull-right right-title">HHR - The <span class="red">New</span> place for <span class="red">Hip Hop</span>
                </p>

                <div class="clearfix"></div>
                <hr class="divider"/>
            </div>
        </div>
        <div class="comments">
            <!-- first comment -->
            
             <?php if($comments):?>
                <?php $displayed_comments = 0;?>
                <?php foreach($comments as $comment):                
	                 $comment_by = Model_User::find($comment->user_id);
                ?>
            <div class="comment-inner" id="comment-<?php echo $comment->id?>">
                <div class="profile-pic pull-left">
                    <?php echo Html::anchor("users/show/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?>
                </div>
                <div class="pull-left comment-text-holder">
                    <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $comment_by->username; ?></span> <span class="dark">commented on your page</span> <span class="red"><?php echo Date::forge($comment->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                          <a href="#" class = "reply-to-comment" id="reply-to-comment-<?php echo $comment->id?>"><?php  echo Asset::img("videoke/Comment-reply.jpg",array('id'=>"reply-image-$comment->id")); ?></a> 
                            <a href="<?php echo Uri::create('comments/remove/'.$comment->id)?>" class = "remove-comment" id="remove-comment-<?php echo $comment->id?>" url="0"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <hr class="comment-inner-separator"/>
                    <p class="comment-text"><?php echo $comment->detail; ?></p>
                </div>
                <div class="clearfix"></div>

                <?php 
                	$replies = Model_Comment::get_comment_replies($comment->id);
                	if(false !== $replies):
                	foreach($replies as $reply):                	
                	$reply_by = Model_User::find($reply->user_id);
                	?>
                <hr class="comment-middle-separator"/>

                <div class="replied-comments" id="reply-<?php echo $reply->id?>">
                    <div class="profile-pic pull-left">
                        <?php echo Html::anchor("users/show/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?>
                    </div>
                    <div class="pull-left comment-text-holder">
                        <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $reply_by->username;?></span> <span class="dark">commented on your page</span> <span class="red"><?php echo Date::forge($reply->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                            <a href="<?php echo Uri::create('comments/remove/'.$reply->id)?>" class = "remove-comment" id="remove-comment-<?php echo $reply->id?>" url="1"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                            <div class="clearfix"></div>
                        </div>
                        <hr class="comment-inner-separator"/>
                        <p class="comment-text"><?php echo $reply->detail; ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                 <?php 
                	endforeach;
                	endif;
                	?>
                <div class="comment-reply-box" id="comment-div-<?php echo $comment->id;?>">
                    <div class="profile-pic-reply pull-left">
                       <?php echo Html::anchor("users/show/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile"))); ?>
                    </div>
                    <div class="pull-left reply-input">
                        <form class="comment-reply" id="comment-reply-<?php echo $comment->id;?>" action="<?php echo Uri::create('comments/home_replay') ?>" method="post">
                            <textarea class="pull-left" id="reply-message-<?php echo $comment->id ?>" name="message"></textarea>
                            <input type="hidden" name="parent_comment_id" value="<?php echo $comment->id; ?>" />
                            <input type="hidden" name="comment_to" value="<?php echo $comment->id; ?>" />
                            <button class="pull-left red-reply-btn" type="submit" name="comment-reply" id="comment-reply-button-<?php echo $comment->id?>">Reply</button>                         
                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

            <hr class="comment-large-separator"/>
             <?php 
             $displayed_comments++;
             if ($displayed_comments >=10)
             	break;
             ?>
             <?php endforeach;?>
                
                <?php 
              if($displayed_comments >= 10):?>
              <p class="more-comment"><a href="#" id = "view-more-anchor" url = "<?php echo Uri::create('users/comments_show_more'); ?>" class="more-comment red"> > VIEW OLDER COMMENTS </a></p>
            <?php   endif;
                else:
                		echo '<p class="nodata-comments">No comments to display!</p>';
               endif; ?>
            
            
            

           

        </div> <!-- end of comments -->


    </div>

    <div class="videokes-right content-box clearfix">
        <p class="header-text">VIDEO SUGGESTIONS</p>
        <hr class="divider"/>
        <?php
        if (isset($suggestions)) {
            //                echo "<pre>";
            //                print_r($videokes);
            //                echo "</pre>";
            if (sizeof($suggestions) > 0) {
                foreach ($suggestions as $video) {
                    $view = View::forge('videokes/partials/single_item');
                    $view->videoke = $video;
                    echo $view;
                    echo '<div class="clearfix"></div><hr class="thin-divider" />';
                }
            } else {
                echo "No Video Suggestions";
            }
        } else {
            echo "No Videos uploaded";
        }
        ?>
        <p><a class="red pull-right see-more-link" href="#">&gt; SEE MORE</a></p>
        <div class="clearfix"></div>

    </div>

    <div class="clearfix separator"></div>

</div>

