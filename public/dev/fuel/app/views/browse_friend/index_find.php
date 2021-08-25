
<div id="content" class="clearfix">
    <div id="middle">         
        <section id="friends">
            <h2>Browse Members <?php echo Html::anchor("/browse/index", "Back <i class='fa fa-angle-double-left'></i>", array("class" => "view-all")); ?></h2>
            <div class="photos">                                                    
             <?php if($identifier == 4 && $refine == 4): ?> 
          <?php if(($friend == 'Please enter both first name and last name') || ($friend == 'Please enter both first name and last name or email address')): ?> 
           <p class="nodata-message"> <?php echo $friend; ?></p>
            <?php else: ?> 
             <?php $counter = 0; ?>            
           <?php if(!empty($friend[0])): ?>                   
               <?php foreach ($friend as  $value): ?>
               <?php if($value['group_id'] != 5): ?>
               <?php if (!Model_Profile::is_deleted_account($value['id'])): ?>
                <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>          
                  <?php if ((!Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id']))) || (Model_Friendship::are_friends($current_profile->id, $value['id'])) || (Model_Profile::is_free_member($value['id']))): ?>  
               
               <div class="photo">
                     <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo" => $photo,'referd' => $referd,'subscribed' => $subscribed)); ?>                    
                     <?php $counter++; ?>
                      </div> 
               <?php endif; ?>           
                       <?php else: ?>
               <?php if ((Model_Setting::is_set_privacy($value['id']) && !Model_Profile::is_premium_member($value['id']) && !Model_Profile::is_dating_agent($value['id'])) || !Model_Setting::is_set_privacy($value['id']) || (Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id'])) && Model_Friendship::are_friends($current_profile->id, $value['id']))): ?> 
                    <div class="photo">
                     <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo" => $photo,'referd' => $referd,'subscribed' => $subscribed)); ?>                    
                     <?php $counter++; ?>
                      </div> 
                      <?php endif; ?>
                      <?php endif; ?>
                      <?php endif; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>  
                    <?php endif; ?>            
              <?php if($counter == 0): ?>
                <p class="nodata-message">The person you requested is not on the system</p>
            <?php endif; ?> 
            <?php endif; ?>  
            <?php endif; ?>                              
            </div>           
        </section>      
 
   <section id="find-friend">
            <h2>Find a Friend</h2>
            <div class="sender-form">
               <?php echo Form::open('browse/find_a_friend'); ?>
                    <p>
                        <label for="email">Email:</label><br /> 
                        <input  id="email-addr" type="text" name="email"> <br /><br /> OR <br /><br />
                        <label for="email">First Name:</label><br /> 
                        <input  id="email-addr" type="text" name="fname"><br />
                        <label for="email">Last Name:</label><br /> 
                        <input  id="email-addr" type="text" name="lname">
                    </p>
                    <p>
                        <button type="submit" id="find-a-friend" class="button">Find a Friend Now!</button>
                    </p>
                <?php echo Form::close();?>
            </div>
        </section>
 
 
    </div>
    <aside id="right-sidebar">
       <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members,'referd' => $referd,'subscribed' => $subscribed)); ?>
        <div class="ad">
            <?php echo Html::anchor(Uri::create('agent'), Asset::img("temp/dating_agent_ad.jpg")); ?>
        </div>
    </aside>
</div>





