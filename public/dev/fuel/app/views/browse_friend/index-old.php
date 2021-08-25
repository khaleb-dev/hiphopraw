<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><b>Upgrade</b> to never see ads again. <b>Remove</b></p>
</div>

<div id="content" class="clearfix">
  <div id="middle">

    <div class="quick-search-wrapper">
        <div class="section-title">
             <h3>Browse Members</h3>
              <p> Explore WWAM & Meet new member daily!</p>
              <div class="border-icon1"></div>
              <div class="clearfix"></div>
        </div>
    <?php echo Form::open('browse/browse_members'); ?>
        <section id="quick-search">
            <div id="quick"> <h2>Quick Search</h2></div>

            <div class="quick-search">
                <div class="small-section">
                    <label for="Iam">I am a:</label><br>
                    <select  name="Iam">
                        <option <?php if (isset($Iam) && $Iam == 'Male')  echo "selected"; ?>>Male</option>
                        <option <?php if (isset($Iam) && $Iam == 'Female') echo "selected"; ?>>Female</option>
                    </select>
                </div>
                <div class="small-section">
                    <label for="seeking">Seaking a:</label><br>
                    <select  name="seeking">
                        <option <?php if (isset($seeking) && $seeking == 'Female')  echo "selected"; ?>>Female</option>
                        <option <?php if (isset($seeking) && $seeking == 'Male') echo "selected"; ?>>Male</option>
                    </select>
                </div>
                <div class="vertical-separator"></div>
                <div class="small-section">
                    <label for="age-range-1">Between Ages:</label><br>
                    <select  name="age-range-1">
                        <?php for ($i = 18; $i <= 99; $i++): ?>
                            <option <?php if (isset($age_from)) echo ($i == $age_from ? 'selected' : ''); ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <span class="to-text">To</span>
                    <select  name="age-range-2">
                        <?php for ($i = 18; $i <= 99; $i++): ?>
                            <option <?php if (isset($age_to)) echo ($i == $age_to ? 'selected' : ''); ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="vertical-separator"></div>
                <div  class="small-section state-list">
                    <label for="state">State:</label><br>
                    <select name="state">
                        <option value="">Please Select</option>
                        <?php foreach ($state_list as $item) : ?>
                            <option <?php if (isset($state)) echo ($item->name == $state ? 'selected' : ''); ?>><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="full-section">
                    <label for="keywords">Keywords:</label><br>
                    <input type="text" name="keywords" size="90" value="<?php if (isset($keyword)) echo $keyword; ?>"/>

                    <input name="quick_search_button" type="submit" value="SEARCH">
                </div>
                <div  class="small-section">
                    <input type="checkbox" name="photo" <?php if (isset($photo_selected)) echo ($photo_selected == 1 ? 'checked' : ''); ?>>
                    <label for="photo">Photos Only</label>
                </div>
                <div  class="small-section">
                    <input type="checkbox" name="online" <?php if (isset($online_selected)) echo ($online_selected == 1 ? 'checked' : ''); ?>>
                    <label for="online">Online Only</label>
                </div>
                <div style="clear: both"></div>
            </div>
        </section>
        </div>

        <section class="browse-members">
            <div class="inner-wrapper">
                <div class="border-icon2"></div>
                <div id="quick"> <h2>Browsing WWAM Members</h2> </div>
            </div>

        </section>

        <section id="friends">
         <div id="quick">    <h2>Search Result</h2> </div>
            <div class="photos  clearfix">
            <?php if($result[0]): ?>
               <?php foreach ($result as  $value): ?>
                    <?php if($value['group_id'] != 5): ?>
                        <?php if (!Model_Profile::is_deleted_account($value['id'])): ?>
                             <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                                  <?php if ((!Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id']))) || (Model_Friendship::are_friends($current_profile->id, $value['id'])) || (Model_Profile::is_free_member($value['id']))): ?>
                                        <div class="photo">
                                            <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo_selected" => isset($photo_selected)? $photo_selected: 0)); ?>
                                        </div>
                                  <?php endif; ?>
                             <?php else: ?>
                                  <?php if ((Model_Setting::is_set_privacy($value['id']) && !Model_Profile::is_premium_member($value['id']) && !Model_Profile::is_dating_agent($value['id'])) || !Model_Setting::is_set_privacy($value['id']) || (Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id'])) && Model_Friendship::are_friends($current_profile->id, $value['id']))): ?>
                                        <div class="photo">
                                            <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo_selected" => isset($photo_selected)? $photo_selected: 0)); ?>
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
            </div>
        </section>

        <?php if($current_profile->member_type_id == 1): ?>
            <section id="upgrade">
                <?php echo \Fuel\Core\Html::anchor('/membership/upgrade',\Fuel\Core\Asset::img(array('upgrade_new.png')))?>
            </section>
        <?php endif; ?>

        <section id="refine-search">
            <div id="refine"> <h2>Refine Search</h2></div>
            <div class="quick-search">
                <div  class="small-section">
                    <label for="body">Body Type:</label><br>
                    <select  id = "refine_select1" name="body">
                        <option value="">Please Select</option>
                        <?php foreach ($body_type as $item) : ?>
                            <option value="<?php echo $item->id; ?>" <?php if (isset($body)) echo ($item->id == $body ? 'selected' : ''); ?>><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div  class="small-section">
                    <label for="ethnicity">Ethnicity:</label><br>
                    <select id = "refine_select2" name="ethnicity">
                        <option value="">Please Select</option>
                        <?php foreach ($ethnicity_list as $item) : ?>
                            <option value="<?php echo $item->id; ?>" <?php if (isset($ethnicity)) echo ($item->id == $ethnicity ? 'selected' : ''); ?>><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div  class="small-section">
                    <label for="occupation">Occupation:</label><br>
                    <select  id = "refine_select3" name="occupation">
                        <option value="">Please Select</option>
                        <?php foreach ($occupation_list as $item) : ?>
                            <option value="<?php echo $item->id; ?>" <?php if (isset($occupation)) echo ($item->id == $occupation ? 'selected' : ''); ?>><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div  class="small-section">
                    <label for="faith">Faith:</label><br>
                    <select id = "refine_select4" name="faith">
                        <option value="">Please Select</option>
                        <?php foreach ($religion_list as $item) : ?>
                            <option value="<?php echo $item->id; ?>" <?php if (isset($faith)) echo ($item->id == $faith ? 'selected' : ''); ?>><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div  class="small-section">
                    <label for="kids">Kids:</label><br>
                    <select id = "refine_select5" name="kids">
                        <option value="">Please Select</option>
                        <option value="Yes" <?php if (isset($kids) && $kids == 'Yes') echo "selected"; ?>>Yes</option>
                        <option value="No" <?php if (isset($kids) && $kids == 'No') echo "selected"; ?>>No</option>
                    </select>
                </div>
                <div class="submit"><input name="refine_search_button" type="submit" value="SEARCH"> </div>
            </div>
        </section>
    <?php echo Form::close();?>
 
   <section id="find-friend">
          <div id="quick">  <h2>Find a Friend</h2></div>
            <div class="sender-form">
               <?php echo Form::open('browse/browse_members'); ?>
                    <p>
                        <label for="email">Email:</label><br /> 
                        <input  id="email-addr" type="text" name="email" value="<?php if (isset($email)) echo $email; ?>"> <br /><br /> OR <br /><br />
                        <label for="email">First Name:</label><br /> 
                        <input  id="email-addr" type="text" name="first_name" value="<?php if (isset($first_name)) echo $first_name; ?>"><br />
                        <label for="email">Last Name:</label><br /> 
                        <input  id="email-addr" type="text" name="last_name" value="<?php if (isset($last_name)) echo $last_name; ?>">
                    </p>
                    <p>
                        <button type="submit" id="find-a-friend" name="find_friend_button" class="button">Find a Friend Now!</button>
                    </p>
                <?php echo Form::close();?>
            </div>
        </section>
 
 
    </div>
    <aside id="right-sidebar">
       <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members)); ?>
        <div class="ad">
            <?php echo Html::anchor(Uri::create('agent'), Asset::img("temp/dating_agent_ad.jpg")); ?>
        </div>
    </aside>
</div>
