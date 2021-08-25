<div class="other-profile-container">
   <div class = "home-background-container">
   </div>
   <div class = "counter-nav">
      <div class = "top-list">
        <ul>
         <?php if($current_user): ?>
         <li><a href="<?php echo Uri::create('users/show/'. $user->id);?>">Videos</a></li>
         <li><a href="<?php echo Uri::create('users/friends/'. $user->id);?>">Friends</a></li>
         <li><a href="<?php echo Uri::create('users/followers/'. $user->id);?>">Followers</a></li>
         <li><a href="<?php echo Uri::create('users/comment/'. $user->id);?>">Comments</a></li>
          <?php else: ?>
          <li><a href="<?php echo Uri::create('pages/show_profile/'. $user->id);?>">Videos</a></li>
         <li><a href="<?php echo Uri::create('pages/friends/'. $user->id);?>">Friends</a></li>
         <li><a href="<?php echo Uri::create('pages/followers/'. $user->id);?>">Followers</a></li>
         <li><a href="<?php echo Uri::create('pages/comment/'. $user->id);?>">Comments</a></li>
         <?php endif; ?>
        </ul>
     </div>
     <div class = "bottom-list">
        <ul>
         <?php if($current_user): ?>
         <li><a href="<?php echo Uri::create('users/show/'. $user->id);?>"><?php echo $videokes_count; ?></a></li>
         <li><a href="<?php echo Uri::create('users/friends/'. $user->id);?>"><?php echo $friends_count; ?></a></li>
          <li><a href="<?php echo Uri::create('users/followers/'. $user->id);?>"><?php echo $followers_count; ?></a> </li>
         <li><a href="<?php echo Uri::create('users/comment/'. $user->id);?>"><?php echo $comments_counter; ?></a> </li>
         <?php else: ?>
          <li><a href="<?php echo Uri::create('pages/show_profile/'. $user->id);?>"><?php echo $videokes_count; ?></a></li>
         <li><a href="<?php echo Uri::create('pages/friends/'. $user->id);?>"><?php echo $friends_count; ?></a></li>
          <li><a href="<?php echo Uri::create('pages/followers/'. $user->id);?>"><?php echo $followers_count; ?></a> </li>
         <li><a href="<?php echo Uri::create('pages/comment/'. $user->id);?>"><?php echo $comments_counter; ?></a> </li>
         <?php endif; ?>
        </ul>
     </div>
      <div class = "link-active">
         <?php echo Asset::img('user/active-line.png'); ?>
     </div>
     <?php if($current_user): ?>
     <?php if($current_user->id != $user->id): ?>    
         <?php if (!Model_Follower::follower_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    <?php echo View::forge("followers/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "Followers/create")); ?>
                <?php } ?> 
     <?php endif; ?>
      <?php else:?>
      <button class = "public-button-follower-container"><?php echo Asset::img('user/follow.png', array('class' => 'follower-img')); ?><?php echo Form::submit("#", "Follow This Artist",array("class"=>"follow-request-actual-button")); ?></button>
     <?php endif; ?>
   </div>
  <div class="main-profile-con">
   <div class = "profile-nav">
     <div class = "top-nav">
       <div class = "profile-picture">
        <?php if($current_user): ?>
         <?php echo Html::anchor("users/show/" . $user->id, Html::img(Model_User::get_picture($user, "profile"))); ?> 
         <?php else:?>
         <?php echo Html::anchor("pages/show_profile/" . $user->id, Html::img(Model_User::get_picture($user, "profile"))); ?>
         <?php endif; ?>
       </div>
       <div class = "name">
        <p> <?php echo $user->username; ?> </p>
       </div>
       <div class = "line">
       </div>
       <div class = "location">
        <?php if($user->facebook_link === '1'): ?>
       <p> <span>Fan</span> - <?php echo $user->city . ", " . $user->state; ?></p>
       <?php else: ?>
      <p> <span><?php if(isset($user->category)){echo Model_Category::find($user->category)->name;} ?></span> - <?php echo $user->city . ", " . $user->state; ?></p>
       <?php endif; ?>
       </div>
        <?php if ($current_user) { ?>
       <?php if($current_user->id != $user->id): ?>
     
       <div class = "send-friend-request">
       <?php if (!Model_Friendship::request_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    <?php echo View::forge("friendships/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "friendships/create")); ?>
                <?php } ?>
       </div>
       <div class = "send-message">         
      <?php echo View::forge("messages/partials/form_modal", array("user" => $user)); ?>
       </div>
      
            
     <!--   <div class = "send-message">
        <a href = "#"><?php //echo Asset::img('user/message.png', array('id' => 'message-img')); ?></a>
       </div>-->
  <!--       <div class = "send-chat">
        <a href = "#"><?php //echo// Asset::img('user/chat.png', array('id' => 'chat-img')); ?></a>
       </div>-->
        <?php endif; ?>
         <?php } ?> 
        <?php if (!$current_user) { ?>
       <div class = "send-friend-request">
        <button class = "public-button-request-container"><?php echo Asset::img('user/friend.png', array('class' => 'friend-img')); ?><?php echo Form::submit("#", "Send Friend Request",array("class"=>"friend-request-actual-button")); ?></button>
       </div>
       <div class = "public-send-message">         
      <a href="#" role="button" class="" data-target="#" data-toggle="modal"><i class='icon-envelope'></i> Send a Message</a>
       </div>
         <?php } ?>
     </div>
     <div class = "bottom-nav">
      <h4>ABOUT ME</h4>
       <div class = "line-break">
       </div>
      <p>
       <?php echo $user->about_me(); ?>
      </p>
   <!--   <p class="social-link-title">FACEBOOK</p>
     <p><a class="red" href = "http://<?php //echo $user->facebook_link; ?>"><?php //echo $user->facebook_link; ?></a></p>
     <div class="social-links"></div>
     <p class="social-link-title">INSTAGRAM</p>
     <p><a class="red" href = "http://<?php //echo $user->instagram_link; ?>"><?php //echo $user->instagram_link; ?></a></p>
     <div class="social-links"></div>
     <p class="social-link-title">TWITTER</p>
     <p><a class="red" href = "http://<?php //echo $user->twitter_link; ?>"><?php //echo $user->twitter_link; ?></a></p> -->
     </div>
   </div>
   <div id = "white-container">
       <div class="comments">
            <!-- first comment -->
            
             <?php if(isset($comments)):?>
                
                <?php foreach($comments as $comment):                
	                 $comment_by = Model_User::find($comment->user_id);
                ?>
            <div class="comment-inner" id="comment-<?php echo $comment->id?>">
                <div class="profile-pic pull-left">
                   <?php if($current_user): ?>
                  <?php echo Html::anchor("users/show/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?> 
                  <?php else:?>
                  <?php echo Html::anchor("pages/show_profile/" . $comment_by->id, Html::img(Model_User::get_picture($comment_by, "profile"))); ?>
                  <?php endif; ?>            
                </div>
                <div class="pull-left comment-text-holder">
                    <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $comment_by->username; ?></span> <span class="dark">commented on your page</span> <span class="red"><?php echo Date::forge($comment->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                         <?php if($current_user): ?>
                           <a href="#" class = "reply-to-comment" id="reply-to-comment-<?php echo $comment->id?>"><?php  echo Asset::img("videoke/Comment-reply.jpg",array('id'=>"reply-image-$comment->id")); ?></a>                         
                           <?php if($current_user->id ==  $comment_by->id): ?>
                            <a href="<?php echo Uri::create('comments/remove/'.$comment->id)?>" class = "remove-comment" id="remove-comment-<?php echo $comment->id?>" url="0"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                           <?php endif; ?>
                           <?php endif; ?>
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
                        <?php if($current_user): ?>
                       <?php echo Html::anchor("users/show/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?> 
                       <?php else:?>
                       <?php echo Html::anchor("pages/show_profile/" . $reply_by->id, Html::img(Model_User::get_picture($reply_by, "profile"))); ?>
                       <?php endif; ?>                         
                    </div>
                    <div class="pull-left comment-text-holder">
                        <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red"><?php echo $reply_by->username;?></span> <span class="dark">commented on your page</span> <span class="red"><?php echo Date::forge($reply->created_at)->format("%m %d, %Y at %H:%M"); ?></span>
                        </span>
                        <span class="pull-right">
                            <?php if($current_user): ?>
                            <?php if($current_user->id == $reply_by->id): ?>
                            <a href="<?php echo Uri::create('comments/remove/'.$reply->id)?>" class = "remove-comment" id="remove-comment-<?php echo $reply->id?>" url="1"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                            <?php endif; ?>
                            <?php endif; ?>
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
                	<?php if($current_user): ?>
                <div class="comment-reply-box" id="comment-div-<?php echo $comment->id;?>">
                    <div class="profile-pic-reply pull-left">
                       <?php echo Html::anchor("users/show/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile"))); ?>
                    </div>
                    <div class="pull-left reply-input">
                        <form class="comment-reply" id="comment-reply-<?php echo $comment->id;?>" action="<?php echo Uri::create('comments/show_replay/'.$user->id) ?>" method="post">
                            <textarea class="pull-left" id="reply-message-<?php echo $comment->id ?>" name="message"></textarea>
                            <input type="hidden" name="parent_comment_id" value="<?php echo $comment->id; ?>" />
                            <input type="hidden" name="comment_to" value="<?php echo $comment->id; ?>" />
                            <button class="pull-left red-reply-btn" type="submit" name="comment-reply" id="comment-reply-button-<?php echo $comment->id?>">Reply</button>                         
                        </form>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <?php endif; ?>
            </div>

            <hr class="comment-large-separator"/>

             <?php endforeach;?>
                
                <?php 
               endif; ?>
             <?php if($comments_counter == 0):
                
               echo '<p class="nodata-comments">No comments to display!</p>';
               endif; ?>
            
            
             <?php if($comments_counter > 5):?>
            <p class="more-comment"><a href="#" class="more-comment red"> > VIEW MORE COMMENTS </a></p>
            <?php endif; ?>
        </div> <!-- end of comments -->
   </div>
</div>
   <div class="clr"></div>
</div>
 <?php if (!$current_user) { ?>
<div id="upgrade-hello-dialog" class="public-profile-dialog-upgrade-common dialog">
                  
            <div id="upgrade-content" class="clearfix">
               <h5>You must sign up inorder to interact with the members of the platform.</h5> 
            </div>         
</div>
  <?php } ?> 
