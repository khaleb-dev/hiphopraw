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
            <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
            <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
            <div class="border-circle border-circle-3"><?php echo Asset::img('line_end.png'); ?></div>
        </div>

        <section class="browse-members">
            <div class="inner-wrapper">
                <div class="border-icon2"></div>
                <div id="quick"> <h2>Browsing WWAM Members</h2> </div>
                <div class="member-listing">
                    <?php if($result[0]): ?>
                        <?php foreach ($result as  $value): ?>
                            <?php if($value['group_id'] != 5): ?>
                                <?php if (!Model_Profile::is_deleted_account($value['id'])): ?>
                                    <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                                        <?php if ((!Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id']))) || (Model_Friendship::are_friends($current_profile->id, $value['id'])) || (Model_Profile::is_free_member($value['id']))): ?>
                                            <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo_selected" => isset($photo_selected)? $photo_selected: 0)); ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if ((Model_Setting::is_set_privacy($value['id']) && !Model_Profile::is_premium_member($value['id']) && !Model_Profile::is_dating_agent($value['id'])) || !Model_Setting::is_set_privacy($value['id']) || (Model_Setting::is_set_privacy($value['id']) && (Model_Profile::is_premium_member($value['id']) || Model_Profile::is_dating_agent($value['id'])) && Model_Friendship::are_friends($current_profile->id, $value['id']))): ?>
                                            <?php echo View::forge("browse_friend/member_thumb", array("member" => $value, "photo_selected" => isset($photo_selected)? $photo_selected: 0)); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(empty($result[0]) || (count($result) == 1 && $result[0]['group_id'] == 5 )): ?>
                        <p class="nodata-message">No Members Found<br>Please enter more detailed search criteria</p>
                    <?php endif; ?>

                    <div class="clearfix"></div>                                                                              
                </div>

<!--                <div class="btn-holder more-member"><a class="" href="#">More Members</a></div>-->

            </div>

        </section>
 
    </div>

</div>
