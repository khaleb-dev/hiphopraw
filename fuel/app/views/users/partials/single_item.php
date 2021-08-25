


              <div>
                    <?php if($current_user): ?>
                          <?php echo Html::anchor("users/show/" . $follower->id, Html::img(Model_User::get_picture($follower, "profile"))); ?> 
                    <?php else:?>
                          <?php echo Html::anchor("pages/show_profile/" . $follower->id, Html::img(Model_User::get_picture($follower, "profile"))); ?>
                     <?php endif; ?>
                        <p class="fiend-name red"><?php echo $follower->username;?></p>
                        <p>
                            <span class="grey-txt"><?php echo $follower->city . ", " . $follower->state; ?></span>
                             <?php 
                               if($follower->is_logged_in == 1){
                                    echo Asset::img('online_dot.png'); 
                                    echo "<span class='grey-txt'>Online</span>";
                                }else{

                                     echo Asset::img('offline_dot.png');
                                     echo "<span class='grey-txt'>Offline</span>";
                               } ?>
                         </p>

                         <?php if($current_user->id != $follower->id){?>
                                     <?php if (Model_Follower::following_status($follower->id, $current_user->id)) : ?>
                                       <button class="red-btn"> FOLLOWING </button>
                                    <?php else: ?>
                                    <form id="follower-request-form" action="<?php echo Uri::create('followers/create'); ?>" method="post">
                                        <input type="hidden" value="<?php echo $follower->id;?>" name="receiver_id">
                                        <input type="hidden" value="<?php echo $current_user->id?>" name="sender_id">
                                        <button class="profile-follow-btn" type="submit"></button>
                                    </form>
                                    <?php endif; ?>
                        <?php }?>
                       
       </div>