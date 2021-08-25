<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends"=>$total_friends, "followers"=>$followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>

    <div id="content" class="with-sidebar-left profile">

        <div class="my-friends" class="content-box">
		 <div class="title" style="border-bottom:2px solid rgb(51,51,51);height:26px; ">
                    <p class="pull-left middle-title-setting">PENDING FRIEND REQUEST
                    </p>
                      <p class="pull-left middle-title">SHOW PENDING FRIEND REQUEST
                    </p>
                        <p class="pull-left middle-title-squer" style="float:right;"><input type="checkbox" id="chk_new"  name="CheckAll"></a></p>
                           

                </div>

                
            <div class="latest-friends">

			     <div id="arrow"><a href="#" data-direction="left"><?php echo Asset::img('videoke/left-scroller.png'); ?> </a></div>
			     
			     <div id="visible-friends">
                  <div id="friends-items" class="clearfix" data-left="0">
                 
                 
                 
                 <?php     
             if($new_friends){
            foreach ($new_friends as $friend):?>
                <div class="friends-pic" id = "friend-<?php echo $friend->id?>">
				 <div id="pic1"><?php echo Html::anchor("users/show/" . $friend->id, Html::img(Model_User::get_picture($friend, "profile"))); ?></div>
				 <div id="name-of-member"><?php echo $friend->username;?></div>
				   <div id="accept-reject">
				  <div id="accept" ><a href = "#" class = "request" from = "<?php echo $friend->id;?>"  to = "<?php echo $current_user->id;?>" status = "<?php echo Model_Friendship::STATUS_ACCEPTED;?>"><?php echo Asset::img('accept.png'); ?>Accept</a></div>
				   <div id="reject1" ><a href = "#" class = "request" from = "<?php echo $friend->id;?>"  to = "<?php echo $current_user->id;?>" status = "<?php echo Model_Friendship::STATUS_REJECTED;?>"><?php echo Asset::img('reject.png'); ?>Decline</a></div>
				   </div>
				 </div>
            <?php  
              endforeach;
                }
             else{
               ?>
                <p class = "no-message-data">No pending friend requests!</p>
               <?php } ?>
                 				 				 
                </div>
				 </div>
				 
				 <div id="right-arrow" url = "<?php echo Uri::create('friendships/update')?>"><a href="#" data-direction="right"><?php echo Asset::img('videoke/right-scroller.png'); ?> </a></div>     
				 <div class="clearfix"></div>       
          </div>
    
    
	          <div class="my_friend1" >
                    <p class="pull-left middle-title-setting">MY FRIENDS
                    </p>
                    <p class="pull-left middle-title-squer">Filter. &nbsp; 
                        <!-- <a>A| </a><a>B| </a><a>C| </a><a>D| </a><a>E| </a><a>F| </a><a>G| </a><a>H| </a><a>I| </a><a>J| </a><a>K| </a><a>L| </a><a>M| </a><a>N| </a><a>O| </a><a>P| </a><a>Q| </a><a>R| </a><a>S| </a><a>T| </a><a>U| </a><a>V| </a><a>W| </a><a>X| </a><a>Y| </a><a>Z| </a> -->

                        <?php $alphas = range('A', 'Z'); ?>
                        <?php foreach ($alphas as $alpha) : ?>
                            <?php echo Html::anchor('users/my_friends/' . $alpha, $alpha."|"); ?>
                        <?php endforeach; ?>
    
                    </p> 
                    <!-- <p class="pull-left middle-title-squer">
                        SHOWING ALL FRIENDS

                    </p> -->
                     <p class="pull-right middle-title ">MANAGE FRIEND
                    </p>
                    <br>

                    <p>
                    <hr style="height:2px;border:none;background-color:rgb(51,51,51); margin-top:5px;width:100%;float:left;"/>
                    </p>

                </div>
				<div class="all-friend" >
				<input type = "hidden" id = "reference">
	            <?php     
             if($friends){
            foreach ($friends as $friend):?>

                <div id="friend-<?php echo $friend->id . "-alt-" . $current_user->id; ?>" class="all-friend1 item">

                  <div id="pic1"> <?php echo Html::anchor("users/show/" . $friend->id, Html::img(Model_User::get_picture($friend, "profile"))); ?></div>
				    <div id="name-of-member">

                    <p class="model-name" style="margin-bottom:0;"><?php echo $friend->username;?></p>
                    <?php 
                    if($friend->is_logged_in == 1){
                            echo Asset::img('online_dot.png'); 
                    }else{

                            echo Asset::img('offline_dot.png');
                        } ?>


                    </div>                    
                    	<p>
                     </p>
                    <?php echo View::forge("users/partials/action_alt_buttons", array("sender" => $friend, "receiver" => $current_user)); ?>   
				</div>
			
			
            <?php  
              endforeach;
                }
             else{
               ?>
                <p class = "no-message-data">No friends added under this alphabet yet!</p>
               <?php } ?>
               <div class="clr"></div>
	
	
		 <div class="clearfix"></div>
			 <div class="back" style="border-top:1px solid #E3E3E3">
                <p class="back" style="float:left;"><?php echo Html::anchor("#", "&gt;   VIEW MORE FRIENDS"); ?></p>		 
        </div>

</div>
</div>
</div>
