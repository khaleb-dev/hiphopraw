<?php if ($latest_members): ?>
    <?php echo Asset::img('profile/match-bw.png',array('class' => 'back pull-left', 'id' => 'left-scroller', 'data-direction' => 'left')); ?>
    <div class="slider-content pull-left">
        <?php if($current_profile->member_type_id == 3): ?>
            <div class="content clearfix" data-left="0">
                <?php foreach ($latest_members as $memberdata): ?>
                    <?php if ($memberdata['group_id'] != 5): ?>
                        <?php if (!Model_Profile::is_deleted_account($memberdata['id'])): ?>
                            <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                                <?php if ((!Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id']))) || (Model_Friendship::are_friends($current_profile->id, $memberdata['id'])) || (Model_Profile::is_free_member($memberdata['id']))): ?>
                                    <div class="slide">
                                        <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $memberdata['id']), Html::img(Model_Profile::get_picture($memberdata['picture'], $memberdata['user_id'], "members_medium"))); ?></div>
                                        <div class="caption"><?php echo Model_Profile::get_username($member['user_id'],18) ?></div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ((Model_Setting::is_set_privacy($memberdata['id']) && !Model_Profile::is_premium_member($memberdata['id']) && !Model_Profile::is_dating_agent($memberdata['id'])) || !Model_Setting::is_set_privacy($memberdata['id']) || (Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id'])) && Model_Friendship::are_friends($current_profile->id, $memberdata['id']))): ?>
                                    <div class="slide">
                                        <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $memberdata['id']), Html::img(Model_Profile::get_picture($memberdata['picture'], $memberdata['user_id'], "members_medium"))); ?></div>
                                        <div class="caption"><?php echo Model_Profile::get_username($member['user_id'],18) ?></div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="content clearfix" data-left="0">
                <?php foreach ($latest_members as $memberdata): ?>
                    <?php if ($memberdata['group_id'] != 5): ?>
                        <?php if (!Model_Profile::is_deleted_account($memberdata['id'])): ?>
                            <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                                <?php if ((!Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id']))) || (Model_Friendship::are_friends($current_profile->id, $memberdata['id'])) || (Model_Profile::is_free_member($memberdata['id']))): ?>
                                    <div class="slide">
                                        <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $memberdata['id']), Html::img(Model_Profile::get_picture($memberdata['picture'], $memberdata['user_id'], "members_medium"))); ?></div>
                                        <div class="caption"><?php echo Model_Profile::get_username($memberdata['user_id'],18) ?></div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ((Model_Setting::is_set_privacy($memberdata['id']) && !Model_Profile::is_premium_member($memberdata['id']) && !Model_Profile::is_dating_agent($memberdata['id'])) || !Model_Setting::is_set_privacy($memberdata['id']) || (Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id'])) && Model_Friendship::are_friends($current_profile->id, $memberdata['id']))): ?>
                                    <div class="slide">
                                        <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $memberdata['id']), Html::img(Model_Profile::get_picture($memberdata['picture'], $memberdata['user_id'], "members_medium"))); ?></div>
                                        <div class="caption"><?php echo Model_Profile::get_username($memberdata['user_id'],18) ?></div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php echo Asset::img('profile/match-fw.png',array('class' => 'forward pull-left', 'id' => 'left-scroller', 'data-direction' => 'right')); ?>
    <div class="clearfix"></div>
<?php endif; ?>
<?php if(empty($latest_members[0]) || (count($latest_members) == 1 && $latest_members[0]['group_id'] == 5 )): ?>
    <p class="nodata-message">No Latest Members!</p>
<?php endif; ?>

