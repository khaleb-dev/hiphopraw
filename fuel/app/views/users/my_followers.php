<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends"=>$friends, "followers"=>$followers,"friends_count"=> $friends_count,"followers_count"=> $followers_count)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>

    </div>

    <div id="content" class="with-sidebar-left profile">

        <div class="my-friends" class="content-box">
		 <div class="title">
                    <p class="pull-left middle-title-setting">MY FOLLOWERS
                    </p>
                   
                    <p class="pull-left middle-title"><?php echo Html::anchor("users/show_following", "| SHOW WHO I'M FOLLOWING"); ?>
                    </p>
					<p class="pull-left middle-title-squer" style="padding-left:150px;">
                                <input id="search" type="text" placeholder="Search..." required />
								</p>
								<p class="button1" >
                                <input  type="button" value="Search" />
                               </p>
             

                    <p>
                    <hr style="height:2px;border:none;background-color:#E3E3E3; margin-top:5px;width:100%;"/>
                    </p>

                </div>
          
	
				<div class="all-friend">
				
                 <?php     
                if($followers){
                  $i = 0;
                   foreach ($followers as $follower):?>
                  <?php $i++;; ?>
				  <?php echo View::forge("users/partials/single_item_followers", array("follower"=>$follower)); ?>				    
				  <?php if($i%5==0): ?>
				<div class="my_friend1">                    
                    <p>
                    <hr style="height:2px;border:none;background-color:#E3E3E3; margin-top:5px;;width:98%;"/>
                    </p>

                </div>
				<?php endif; 
				  endforeach;
                }
             else{
               ?>
                <p class = "no-message-data">No followers found!</p>
               <?php } ?>
				
				
				</div>
		
			 <div class="back">
           
                <p class="back" style="float:left; margin-top:10px; margin-left:-8px"><?php echo Html::anchor("#", "&gt; VIEW MORE FOLLOWERS"); ?></p>		
    
        </div>

</div>
</div>
