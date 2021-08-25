<div class="other-profile-container">
   <div class = "home-background-container">
   </div>
   <div class = "counter-nav">
      <div class = "top-list">
        <ul>
         <li><a href="<?php echo Uri::create('users/show/'. $user->id);?>">Videos</a></li>
         <li><a href="<?php echo Uri::create('users/friends/'. $user->id);?>">Friends</a></li>
         <li><a href="<?php echo Uri::create('users/followers/'. $user->id);?>">Followers</a></li>
         <li><a href="<?php echo Uri::create('users/comments/'. $user->id);?>">Comments</a></li>
        </ul>
     </div>
     <div class = "bottom-list">
        <ul>
         <li><a href="<?php echo Uri::create('users/show/'. $user->id);?>"><?php echo $videokes_count; ?></a></li>
         <li><a href="<?php echo Uri::create('users/friends/'. $user->id);?>"><?php echo $friends_count; ?></a></li>
         <li><a href="<?php echo Uri::create('users/followers/'. $user->id);?>"><?php echo $followers_count; ?></a> </li>
         <li><a href="<?php echo Uri::create('users/comments/'. $user->id);?>"><?php echo $comments_counter; ?></a> </li>
        </ul>
     </div>
      <div class = "link-active">
         <?php echo Asset::img('user/active-line.png'); ?>
     </div>
      <?php if($current_user->id != $user->id): ?>    
         <?php if (!Model_Follower::follower_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    <?php echo View::forge("followers/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "Followers/create")); ?>
                <?php } ?> 
     <?php endif; ?>
   </div>
 <div class="main-profile-con">
   <div class = "profile-nav">
     <div class = "top-nav">
       <div class = "profile-picture">
         <?php echo Html::anchor("users/show/" . $user->id, Html::img(Model_User::get_picture($user, "profile"))); ?>
       </div>
       <div class = "name">
        <p> <?php echo $user->username; ?> </p>
       </div>
       <div class = "line">
       </div>
       <div class = "location">
      <p> <span>Hip Hop Artist</span> - <?php echo $user->city . ", " . $user->state; ?></p>
       </div>
       <?php if($current_user->id != $user->id): ?>
       <?php if ($current_user) { ?>
       <div class = "send-friend-request">
       <?php if (!Model_Friendship::request_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    <?php echo View::forge("friendships/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "friendships/create")); ?>
                <?php } ?>
       </div>
       <div class = "send-message">         
      <?php echo View::forge("messages/partials/form_modal", array("user" => $user)); ?>
       </div>
       <?php } ?> 
            
     <!--   <div class = "send-message">
        <a href = "#"><?php //echo Asset::img('user/message.png', array('id' => 'message-img')); ?></a>
       </div>-->
  <!--       <div class = "send-chat">
        <a href = "#"><?php //echo// Asset::img('user/chat.png', array('id' => 'chat-img')); ?></a>
       </div>-->
        <?php endif; ?>
     </div>
     <div class = "bottom-nav">
      <h4>ABOUT ME</h4>
       <div class = "line-break">
       </div>
      <p>
       <?php echo $user->about_me(); ?>
      </p>

      <p class="social-link-title">FACEBOOK</p>
      <p><a class="red" href = "http://<?php echo $user->facebook_link; ?>"><?php echo $user->facebook_link; ?></a></p>
      <div class="social-links"></div>
      <p class="social-link-title">INSTAGRAM</p>
      <p><a class="red" href = "http://<?php echo $user->instagram_link; ?>"><?php echo $user->instagram_link; ?></a></p>
       <div class="social-links"></div>
      <p class="social-link-title">TWITTER</p>
      <p><a class="red" href = "http://<?php echo $user->twitter_link; ?>"><?php echo $user->twitter_link; ?></a></p>
     </div>
   </div>
   <div id = "white-container">
     <div id = "advert-description">
     <p>FILTER:</p>
     <ul>
        <li><a href="#">A</a></li>
        <li><a href="#">B</a></li>
        <li><a href="#">C</a></li>
        <li><a href="#">D</a></li>
        <li><a href="#">E</a></li>
        <li><a href="#">F</a></li>
        <li><a href="#">G</a></li>
        <li><a href="#">H</a></li>
        <li><a href="#">I</a></li>
        <li><a href="#">J</a></li>
        <li><a href="#">K</a></li>
        <li><a href="#">L</a></li>
        <li><a href="#">M</a></li>
        <li><a href="#">N</a></li>
        <li><a href="#">O</a></li>
        <li><a href="#">P</a></li>
        <li><a href="#">Q</a></li>
        <li><a href="#">R</a></li>
        <li><a href="#">S</a></li>
        <li><a href="#">T</a></li>
        <li><a href="#">U</a></li>
        <li><a href="#">V</a></li>
        <li><a href="#">W</a></li>
        <li><a href="#">X</a></li>
        <li><a href="#">Y</a></li>
        <li><a href="#">Z</a></li>
     </ul>
     <div id = "fliter-container">
      <input id ="input-field-filter" name="search-filter" placeholder="Find a Folower..." type="text">
      <span><button name = "fliter-button" value = "Find">Find</button></span>
      </div>
    </div>
    <div class="clr"></div>
    
   <div class = "friends-row">
       <?php
      $counter = 0; 
   if($followers){
  foreach ($followers as $follower):
   echo View::forge("users/partials/single_item",array("follower" => $follower,"user" => $user)); 
    $counter++;
   endforeach;
      }
   else{
    ?>
    <p class = "no-message-data">No followers added yet!</p>
    <?php } ?>
    <div class="clr"></div>
   </div>
   <?php if($counter >= 20):?>
   <a href = "#" id = "anchor-view"><?php echo Asset::img('user/view-picture.png'); ?> &nbsp;VIEW MORE FOLLOWERS</a>
   <?php endif;?>

   <!-- comments page -->
       <div class="comments">
           <!-- first comment -->
           <div class="comment-inner">
               <div class="profile-pic pull-left">
                   <?php  echo Asset::img("videoke/profile-pic1.jpg"); ?>
               </div>
               <div class="pull-left comment-text-holder">
                   <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red">User</span> <span class="dark">commented on your page</span> <span class="red">Jan 14,2014 at 12:37 am</span>
                        </span>
                        <span class="pull-right">
                            <a href="#"><?php  echo Asset::img("videoke/Comment-reply.jpg"); ?></a>
                            <a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                       <div class="clearfix"></div>
                   </div>
                   <hr class="comment-inner-separator"/>
                   <p class="comment-text">Our personal dating Concierge Agents take the work out of the online will us help you improve the quality and quantity of your dates and maximize your online experience</p>
               </div>
               <div class="clearfix"></div>

               <div class="replied-comments">
                   <div class="profile-pic pull-left">
                       <?php  echo Asset::img("videoke/profile-pic2.jpg"); ?>
                   </div>
                   <div class="pull-left comment-text-holder">
                       <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red">User</span> <span class="dark">commented on your page</span> <span class="red">Jan 14,2014 at 12:37 am</span>
                        </span>
                        <span class="pull-right">
                            <a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                           <div class="clearfix"></div>
                       </div>
                       <hr class="comment-inner-separator"/>
                       <p class="comment-text">Our personal dating Concierge Agents take the work out of the online will us help you</p>
                   </div>
                   <div class="clearfix"></div>
               </div>

               <div class="comment-reply-box-small">
                   <div class="profile-pic-reply pull-left">
                       <?php  echo Asset::img("videoke/profile-pic3.jpg"); ?>
                   </div>
                   <div class="pull-left reply-input">
                       <form>
                           <textarea class="pull-left" name="comment-reply"></textarea>
                           <button class="pull-left red-reply-btn" type="submit" name="comment-reply">Reply</button>
                       </form>
                   </div>

                   <div class="clearfix"></div>
               </div>
           </div>

           <hr class="comment-large-separator"/>

           <!-- second comment -->
           <div class="comment-inner">
               <div class="profile-pic pull-left">
                   <?php  echo Asset::img("videoke/profile-pic1.jpg"); ?>
               </div>
               <div class="pull-left comment-text-holder">
                   <div class="comment-inner-title">
                        <span class="pull-left">
                            <span class="red">User</span> <span class="dark">commented on your page</span> <span class="red">Jan 14,2014 at 12:37 am</span>
                        </span>
                        <span class="pull-right">
                            <a href="#"><?php  echo Asset::img("videoke/Comment-reply.jpg"); ?></a>
                            <a href="#"><?php  echo Asset::img("videoke/commennt-close.jpg"); ?></a>
                        </span>
                       <div class="clearfix"></div>
                   </div>
                   <hr class="comment-inner-separator"/>
                   <p class="comment-text">Our personal dating Concierge Agents take the work out of the online will us help you</p>
               </div>

               <div class="clearfix"></div>
               <div class="comment-reply-box">
                   <div class="profile-pic-reply pull-left">
                       <?php  echo Asset::img("videoke/profile-pic3.jpg"); ?>
                   </div>
                   <div class="pull-left reply-input">
                       <form>
                           <textarea class="pull-left" name="comment-reply"></textarea>
                           <button class="pull-left red-reply-btn" type="submit" name="comment-reply">Reply</button>
                       </form>
                   </div>

                   <div class="clearfix"></div>
               </div>
           </div>

           <hr class="comment-large-separator"/>

           <p class="more-comment"><a href="#" class="more-comment red"> > VIEW MORE COMMENTS </a></p>

       </div> <!-- end of comments -->

   </div>
</div>
   <div class="clr"></div>
</div>

      

