<div class = "followers">
        <div class = "real-follower">
       <?php echo Html::anchor("users/show/" . $follower->id, Html::img(Model_User::get_picture($follower, "profile"))); ?>
       </div>
       <div class = "follower-name">
       <p class="model-name"><?php echo $follower->username ; ?></p>
       </div>
       <div class = "followeing-status">      
        <?php if (Model_Follower::following_status($follower->id, $current_user->id) AND $follower->id != $current_user->id):?>
        <?php echo Asset::img("user/follower-checked.png"); ?> 
        <?php else: ?> 
        <?php echo Asset::img("user/follower-unchecked.png"); ?>
        <?php endif;?>         
       </div>      
      </div>