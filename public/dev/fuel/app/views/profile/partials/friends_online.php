<div id="friends-online">
    <div class="content">
	<div id="members">
        <h4>Members Online</h4>
		</div>
        <?php if ($online_members): ?>
            <?php foreach ($online_members as $online_member): ?>
                <?php if ($online_member['group_id'] != 5): ?>
                    <?php if (!Model_Profile::is_deleted_account($online_member['id'])): ?>
                          <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                             <?php if ((!Model_Setting::is_set_privacy($online_member['id']) && (Model_Profile::is_premium_member($online_member['id']) || Model_Profile::is_dating_agent($online_member['id']))) || (Model_Friendship::are_friends($current_profile->id, $online_member['id'])) || (Model_Profile::is_free_member($online_member['id']))): ?>
                                <div id="<?php echo $online_member['username'] ?>" class="friend clearfix">
                                   <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $online_member['id']) : Uri::create('agent/client_view/' . $online_member['id']),Html::img(Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_medium"))); ?>
                                        <div class="details">
                                            <div class="name"> <p><?php echo Model_Profile::get_username($online_member['user_id'],14)  ?></p></div>
                                            <p class="location"><?php echo substr($online_member['city'],0,15) . ' ' . $online_member['state'] ?></p>
                                            <p class="icons">
                                                <?php if ((Model_Friendship::are_friends($current_profile->id, $online_member['id']) AND $current_profile->id != $online_member['id']) || $current_profile->member_type_id == 2 || $current_profile->member_type_id == 3 || $current_user->group_id == 5){  ?>
                                                    <?php echo Html::anchor("#", '<i class="messages"></i>', array("class" => "send-message-icon", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $online_member['id'], "data-username" => Model_Profile::get_username($online_member['user_id']), "data-profile-picture" => Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_list"))); ?>
                                                    <?php echo Html::anchor("#", '<i class="chat"></i>', array("class" => "send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $online_member['id'], "data-username" => Model_Profile::get_username($online_member['user_id']), "data-profile-picture" => Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_list"))); ?>
                                                    <?php echo Html::anchor("#", '<i class="hello"></i>', array("class" => "send-hello-icon", "data-confirmation-dialog" => "hello-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $online_member['id'], "data-username" => Model_Profile::get_username($online_member['user_id']), "data-profile-picture" => Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_list") )); ?>

                                                <?php } else { ?>
                                                    <?php echo Html::anchor("#", '<i class="messages"></i>', array("id" => "send-message", "data-dialog" => "upgrade-message-dialog")); ?>
                                                    <?php echo Html::anchor("#", '<i class="chat"></i>', array("id" => "send-chat", "data-dialog" => "upgrade-chat-dialog")); ?>
                                                    <?php echo Html::anchor("#", '<i class="hello"></i>', array("id" => "send-a-hello", "data-dialog" => "upgrade-hello-dialog")); ?>
                                                <?php } ?>
                                                <?php echo Asset::img("online_dot.png"); ?>
                                            </p>
                                        </div>
                               </div>
                             <?php endif; ?>
                          <?php else: ?>
                              <?php if ((Model_Setting::is_set_privacy($online_member['id']) && !Model_Profile::is_premium_member($online_member['id']) && !Model_Profile::is_dating_agent($online_member['id'])) || !Model_Setting::is_set_privacy($online_member['id']) || (Model_Setting::is_set_privacy($online_member['id']) && (Model_Profile::is_premium_member($online_member['id']) || Model_Profile::is_dating_agent($online_member['id'])) && Model_Friendship::are_friends($current_profile->id, $online_member['id']))): ?>
                                <div id="<?php echo $online_member['username'] ?>" class="friend clearfix">
                                   <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $online_member['id']) : Uri::create('agent/client_view/' . $online_member['id']),Html::img(Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_medium"))); ?>
                                        <div class="details">
                                            <p><?php echo Model_Profile::get_username($online_member['user_id'],14)  ?></p>
                                            <p class="location"><?php echo substr($online_member['city'],0,15) . ' ' . $online_member['state'] ?></p>
                                            <p class="icons">
                                                <?php if ((Model_Friendship::are_friends($current_profile->id, $online_member['id']) AND $current_profile->id != $online_member['id']) || $current_user->group_id == 5){  ?>
                                                    <?php echo Html::anchor("#", '<i class="messages"></i>', array("class" => "send-message-icon", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $online_member['id'], "data-username" => Model_Profile::get_username($online_member['user_id']), "data-profile-picture" => Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_list"))); ?>
                                                    <?php echo Html::anchor("#", '<i class="chat"></i>', array("class" => "send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $online_member['id'], "data-username" => Model_Profile::get_username($online_member['user_id']), "data-profile-picture" => Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_list"))); ?>
                                                    <?php echo Html::anchor("#", '<i class="hello"></i>', array("class" => "send-hello-icon", "data-confirmation-dialog" => "hello-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $online_member['id'], "data-username" => Model_Profile::get_username($online_member['user_id']), "data-profile-picture" => Model_Profile::get_picture($online_member['picture'], $online_member['user_id'], "members_list") )); ?>
                                                <?php } else { ?>
                                                    <?php echo Html::anchor("#", '<i class="messages"></i>', array("id" => "send-message", "data-dialog" => "upgrade-message-dialog")); ?>
                                                    <?php echo Html::anchor("#", '<i class="chat"></i>', array("id" => "send-chat", "data-dialog" => "upgrade-chat-dialog")); ?>
                                                    <?php echo Html::anchor("#", '<i class="hello"></i>', array("id" => "send-a-hello", "data-dialog" => "upgrade-hello-dialog")); ?>
                                                <?php } ?>
                                                <?php echo Asset::img("online_dot.png"); ?>
                                            </p>
                                        </div>
                                </div>
                             <?php endif; ?>
                          <?php endif; ?>
			        <?php endif; ?>
			    <?php endif; ?>
            <?php endforeach; ?>
            <div class="view-all">
                <?php echo Html::anchor("profile/online_members", "View All", array("class" => "view-all_online")); ?>
            </div>
          <?php else: ?>
          <p>No online members!</p>
        <?php endif; ?>
    </div>
</div>







