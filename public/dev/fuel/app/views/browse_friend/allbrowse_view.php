<div id="content" class="clearfix">
    <div id="middle">
        <section id="friends">
            <h2>Browse Members</h2>
            <div class="photos">
            <?php if($identifier == 1 && $refine == 0): ?> 
            <?php if(!empty($result[0])): ?>
               <?php foreach ($result as  $value): ?> 
                 <?php if($value['group_id'] != 5): ?>
                  <?php if (!Model_Profile::is_deleted_account($value['id'])): ?> 
                  <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>          
                  <?php if ((!Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id']))) || (Model_Friendship::are_friends($current_profile->id, $value['id'])) || (Model_Profile::is_free_member($value['id']))): ?>
                 
                 <div class="photo">
                    <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo" => $photo,'referd' => $referd,'subscribed' => $subscribed)); ?> 
                     </div>
                 <?php endif; ?>           
                      <?php else: ?>  
                 <?php if ((Model_Setting::is_set_privacy($value['id']) && !Model_Profile::is_premium_member($value['id']) && !Model_Profile::is_dating_agent($value['id'])) || !Model_Setting::is_set_privacy($value['id']) || (Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id'])) && Model_Friendship::are_friends($current_profile->id, $value['id']))): ?>          
                 <div class="photo">
                    <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo" => $photo,'referd' => $referd,'subscribed' => $subscribed)); ?> 
                     </div>
                     <?php endif; ?> 
                     <?php endif; ?>
                     <?php endif; ?>
                     <?php endif; ?>
                    <?php endforeach; ?> 
                    <?php endif; ?>                   
               <?php if(empty($result[0]) || (count($result) == 1 && $result[0]['group_id'] == 5 )): ?>
                <p class="nodata-message">No Members Found<br>Please enter more detailed search criteria</p>
            <?php endif; ?>  
            <?php endif; ?> 
            <?php if($identifier == 0 && $refine == 1): ?> 
             <?php if(!empty($refined[0])): ?>
               <?php foreach ($refined as  $value): ?>
                <?php if($value['group_id'] != 5): ?>
                 <?php if (!Model_Profile::is_deleted_account($value['id'])): ?>               
                 <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>          
                  <?php if ((!Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id']))) || (Model_Friendship::are_friends($current_profile->id, $value['id'])) || (Model_Profile::is_free_member($value['id']))): ?>                
                  <div class="photo">
                   <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo" => $photo,'referd' => $referd,'subscribed' => $subscribed)); ?>   
                     </div>
                 <?php endif; ?>           
                      <?php else: ?>                
                <?php if ((Model_Setting::is_set_privacy($value['id']) && !Model_Profile::is_premium_member($value['id']) && !Model_Profile::is_dating_agent($value['id'])) || !Model_Setting::is_set_privacy($value['id']) || (Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id'])) && Model_Friendship::are_friends($current_profile->id, $value['id']))): ?> 
                 <div class="photo">
                   <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo" => $photo,'referd' => $referd,'subscribed' => $subscribed)); ?>   
                     </div>
                     <?php endif; ?> 
                     <?php endif; ?>
                      <?php endif; ?>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>                    
                <?php if(empty($refined[0]) || (count($refined) == 1 && $refined[0]['group_id'] == 5 )): ?>
                <p class="nodata-message">No Members Found<br>Please enter more detailed refine criteria</p>
            <?php endif; ?>   
            <?php endif; ?>      
            </div>
        </section>
        <section id="refine-search">
            <h2>Refine Search</h2>
            <div class="quick-search">
                <form action = "refine" method = "post">
                    <div>
                        <label for="body">Body Type:</label><br>
                        <select id = "refine_select1" name="body">
                          <option value=''>Please Select</option> 
                            <option>Athletic</option>
                            <option>Average</option>
                            <option>Overweight</option>
                            <option>Curvy</option>
                            <option>Above Average</option>
                            <option>Slim</option>
                        </select>
                    </div>
                    <div>
                        <label for="ethnicity">Ethnicity:</label><br>
                        <select  id = "refine_select2" name="ethnicity">
                          <option value=''>Please Select</option> 
                            <option>European</option>
                            <option>Latino</option>
                            <option>Black/African</option>
                            <option>Asian</option>
                            <option>White/Caucasian</option>
                            <option>Latino/Hispanic</option>
                            <option>Middle Eastern</option>
                            <option>Other</option>
                             
                        </select>
                    </div>
                    <div>
                        <label for="occupation">Occupation:</label><br>
                        <select id = "refine_select3"  name="occupation">
                            <option value=''>Please Select</option>                           
                            <option>Administrative/Secretarial</option>
                            <option>Artistic/Creative/Performance</option>
                            <option>Executive/Management</option>
                            <option>Financial services</option>
                            <option>Labor/Construction</option>                          
                            <option>Medical/Dental/Veterinary</option>
                            <option>Sales/Marketing</option>
                            <option>Technical/Computers/Engineering</option>
                            <option>Travel/Hospitality/Transportation</option>
                            <option>Political/Govt/Civil Service/Military</option>
                            <option>Retail/Food services</option>
                            <option>Teacher/Professor</option>
                            <option>Student</option>
                            <option>Retired</option>
                            <option>Other profession</option>
                            <option>Legal</option>
                        </select>
                    </div>
                    <div>
                        <label for="faith">Faith:</label><br>
                        <select id = "refine_select4" name="faith">
                          <option value=''>Please Select</option>                         
                            <option>Christian/Protestant</option>                         
                            <option>Christian/Catholic</option>  
                            <option>Christian/Other</option>                                                
                            <option>Agnostic</option>
                            <option>Atheist</option>
                            <option>Buddhist/Taoist</option>                           
                            <option>Jewish</option>                            
                            <option>Hindu</option>
                            <option>Muslim/Islam</option>
                            <option>Spiritual but not religious</option>                           
                             <option>Other</option>
                                                      
                        </select>
                    </div>
                    <div>
                        <label for="kids">Kids:</label><br>
                        <select id = "refine_select5"  name="kids">
                          <option value=''>Please Select</option> 
                          <option>Yes</option>
                            <option>No</option>                           
                        </select>
                    </div>
                    <div class="submit"><input type="submit" value="SEARCH"> </div>
                </form>
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
