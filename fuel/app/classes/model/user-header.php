<div id="top-template-wrap">
    <div id="top-template">
    <!--        spacing to the left of the logo-->

    <!--        the hiphopraw logo-->
    <div id="hhr-logo-header">
        <a href = "#">
            <?php echo Asset::img('user-hhr-header-logo.png', array('id' => 'hhr-logo-header')); ?>
        </a>
    </div>
    
    <div id="header-dropdown">
        <a href = "#"><?php echo Asset::img('header-dropdown.png', array('id' => 'header-dropdown')); ?></a>            
    </div>


     <div id="header-search-container" url="<?php echo Uri::create('users/global_search/')?>">
      <input  id="search-header" name="search-header" placeholder="Search..." type="text">
      <span><a href = "#"><?php echo Asset::img('header-search.png', array('id' => 'header-search')); ?></a></span>
        
      <div id="search-overlay">
    
          <input id="display-search" type="text" autocomplete="off" readonly="readonly" /> <!--mirrored input that shows the actual input value-->

           <div id="results">
      
              <ul id="search-data"></ul>
           </div>
      </div>

    </div>



    <div id="header-email">
	<div class="circle" style=" position: absolute; top:12px;"><a><?php echo count($header_new_messages); ?></a></div>
        <a id="header-message-dropdown" > <?php echo Asset::img('message-icone.png', array('id' => 'header-email-img')); ?></a>
    </div>

	 <div class="drop-down-messages">
      <div id="title">
         <p class="pull-left middle-title-setting1">Unread Messages  
                    </p>                
           
          <br>
          <p>
                    <hr style="height:2px;border:none;background-color:#E3E3E3;  margin-top:5px;width:100%; margin-top:0px;margin-bottom:0px;"/>
                    </p>
        </div>
       <?php if($header_new_messages){
            foreach ($header_new_messages as $header_message):?>
            <?php $message = Model_Message::find($header_message); ?>
            <?php $friend = Model_User::find($message->from_user_id); ?>

            
             
          <div  id = "header-message-<?php echo $message->id?>">
               <div id="image" >
      
              <?php echo Html::anchor("users/show/" . $message->from_user_id, Html::img(Model_User::get_picture($friend, "message"))); ?>
             <?php echo Html::anchor("messages/show/$message->id" , substr($message->detail, 0, 150)).'...'; ?> <?php echo $message->title ?>
               </div>
              <div id="name-mutual"><div id="name"><span class="red"><?php echo $friend->username;?></span></div>
              <div></div>
             </div>

         </div>
           <?php  
              endforeach;
                }
             else{
               ?>
                <p class = "no-message-data1">No Unread Messages!</p>
               <?php } ?>
           <br>
          <div class="view-more" id = "url-holder" url = "<?php echo Uri::create('friendships/update')?>">
                <p>
                    <hr style="height:2px;border:none;background-color:#E3E3E3;  margin-top:5px;width:91%; margin-top:0px;margin-bottom:0px;"/>
                    </p>
             <a style="text-decoration:none;">&or; View more Messages</a>
        </div>
  </div>
	
	
    <div id="header-notification" >
	<div class="circle" style=" position: absolute; top:12px;"><a><?php echo count($header_new_comments); ?></a></div>
        <a href = "#" id="header-comments-dropdown"><?php echo Asset::img('notifcation-icon.png', array('id' => 'header-notification-img')); ?></a>
    </div>


    <div id="header-friends">

	<div class="circle" style=" position: absolute; top:12px;"><a><?php echo count($header_new_friends); ?></a></div>
        <a href = "#" id="header-friends-dropdown"><?php echo Asset::img('friend-icon.png', array('id' => 'header-friends-img')); ?></a>
		
    </div>

    <div id="header-profile">
         <?php echo Html::anchor("users/home_login/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile"),array('id' => 'header-small-profile-pic'))); ?>
       <p><a href = "#"><strong><?php echo Html::anchor("users/home_login/" . $current_user->id, strlen($current_user->username)>15?substr($current_user->username, 0,15)."...":$current_user->username, array("title"=>strlen($current_user->username)>15?$current_user->username:"")) ?></strong></a></p><a href = "#"><?php echo Asset::img('header-name-dropdown.png', array('id' => 'header-name-dropdown')); ?></a>
    </div>



    <div class = "drop-down-lists">
           <ul class = "hidden-list">
                <li><a href="<?php echo Uri::create('users/home');?>">RAW HIPHOP VIDEOS</a> </li>
                <li><a href="<?php echo Uri::create('users/model');?>">RAW ELITE MODEL VIDEOS</a> </li>
                <li><a href="<?php echo Uri::create('users/top_video');?>">HHR TOP 100 VIDEOS</a> </li>
                <li><a href="<?php echo Uri::create("users/hhrnews");?>">HHR NEWS</a> </li>
                <li><a href="<?php echo Uri::create("users/contest_bracket");?>">HHR CURRENT CONTEST</a> </li>
           </ul>
    </div>
    
    <div class="drop-down-friends">
    <div id="title">
         <p class="pull-left middle-title-setting1">Friend Request  
                    </p>
                   
                  <!-- <p class="pull-left middle-title"><span class="red">Setting</span>
                    </p>
            -->
          <br>
          <p>
                    <hr style="height:2px;border:none;background-color:#E3E3E3;  margin-top:5px;width:100%; margin-top:0px;margin-bottom:0px;"/>
                    </p>
    </div>
    <?php if($header_new_friends){
            foreach ($header_new_friends as $header_friend):?>
             <?php $mutual_friends =  Model_User::mutual_friends($header_friend, $current_user);?>
     <div class="image-accept-declaine" id = "header-friend-<?php echo $header_friend->id?>">
      <div id="image" >
    <?php echo Html::anchor("users/show/" . $header_friend->id, Html::img(Model_User::get_picture($header_friend, "profile"))); ?>
    </div>
    <div id="name-mutual"><div id="name"><span class="red"><?php echo $header_friend->username;?></span></div>
    <div id="mutual"><?php echo count($mutual_friends);?> Mutual friends</div>
    </div>

       <div id="accept"><a href = "#" class = "header-request" from = "<?php echo $header_friend->id;?>"  to = "<?php echo $current_user->id;?>" status = "<?php echo Model_Friendship::STATUS_ACCEPTED;?>"><?php echo Asset::img('accept.png'); ?>Accept</a></div>
     <div id="decline"><a href = "#" class = "header-request" from = "<?php echo $header_friend->id;?>"  to = "<?php echo $current_user->id;?>" status = "<?php echo Model_Friendship::STATUS_REJECTED;?>"><?php echo Asset::img('reject.png'); ?>Decline</a></div>

     </div>
   <?php  
              endforeach;
                }
             else{
               ?>
                <p class = "no-message-data1">No pending friend requests!</p>
               <?php } ?>
     <br>
     <div class="view-more" id = "url-holder" url = "<?php echo Uri::create('friendships/update')?>">
     <p>
                    <hr style="height:2px;border:none;background-color:#E3E3E3;  margin-top:5px;width:91%; margin-top:0px;margin-bottom:0px;"/>
                    </p>
     <a style="text-decoration:none;">&or; View more Requests</a>
     </div>
  </div>

  
  
  <div class="drop-down-comments">
    <div id="title">
         <p class="pull-left middle-title-setting1">New Comments 
                    </p>
                   
                  <!-- <p class="pull-left middle-title"><span class="red">Setting</span>
                    </p>
            -->
          <br>
          <p>
          <hr style="height:2px;border:none;background-color:#E3E3E3;  margin-top:5px;width:100%; margin-top:0px;margin-bottom:0px;"/>
                    </p>
    </div>
            <?php if($header_new_comments){

               foreach ($header_new_comments as $header_comment):?>

               <?php $friend = Model_User::find($header_comment->user_id); ?>
                    
               
      <div id="image" >
              <?php echo Html::anchor("users/show/" . $header_comment->user_id, Html::img(Model_User::get_picture($friend, "profile"))); ?>
              <?php echo Html::anchor("users/show/".$header_comment->user_id, $friend->username ); ?>
       </div>     

       <div id="name-mutual"><div id="name"><span class="red"> <?php echo Html::anchor("users/comments/".$this->current_user->id, $header_comment->detail ) ?></span></div>
              <div></div>     
   
            <?php  
              endforeach;
                }
             else{
                 ?>
                <p class = "no-message-data1">No new comments!</p>
               <?php } ?>
     <br>
     <div class="view-more" id = "url-holder" url = "<?php echo Uri::create('friendships/update')?>">
     <p>
          <hr style="height:2px;border:none;background-color:#E3E3E3;  margin-top:5px;width:91%; margin-top:0px;margin-bottom:0px;"/>
      </p>
     <a style="text-decoration:none;">&or; View more Comments</a>
     </div>
  </div>

</div>

    <div class = "drop-down-logout">
           <ul class = "hidden-list-logout">
            <?php echo Html::anchor(Uri::create('pages/settings'), '<li>Settings</li>' ); ?>
           <?php echo Html::anchor(Uri::create('users/edit'), '<li>Edit Profile</li>' ); ?> 
           <?php echo Html::anchor(Uri::create('users/logout'), '<li>Logout</li>' ); ?>                                                           
           </ul>
    </div>
    
</div>
</div>