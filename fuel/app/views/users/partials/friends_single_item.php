<div>
        
         <?php if($current_user): ?>
         <?php echo Html::anchor("users/show/" . $friend->id, Html::img(Model_User::get_picture($friend, "profile"))); ?> 
         <?php else:?>
         <?php echo Html::anchor("pages/show_profile/" . $friend->id, Html::img(Model_User::get_picture($friend, "profile"))); ?>
         <?php endif; ?>
       
       
       <p class="fiend-name red"><?php echo $friend->username;?></p>


        <p>
                            <span class="grey-txt"><?php echo $friend->city . ", " . $friend->state; ?></span>
                            <br>
                            <?php 
                    if($friend->is_logged_in == 1){
                            echo Asset::img('online_dot.png'); 
                            echo "<span class='grey-txt'>Online</span>";
                    }else{

                            echo Asset::img('offline_dot.png');
                            echo "<span class='grey-txt'>Offline</span>";
                        } ?>
                      
        </p>
       
</div>

                  