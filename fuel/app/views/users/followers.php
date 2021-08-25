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

