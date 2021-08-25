<div class="member">
    <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $member['id']) : Uri::create('agent/client_view/' . $member['id'])
	, Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
    <p><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
    <p class="location"><?php echo substr($member['city'],0,27) . ' ' . $member['state'] ?></p>
  
    <p class="icons">
        <?php if ((!Model_Friendship::are_friends($current_profile->id, $member['id']) AND $current_profile->id != $member['id']) && $current_profile->member_type_id == 1 && $current_user->group_id != 5):  ?>
            <?php echo Html::anchor("#", '<i class="messages"></i>', array("id" => "send-message", "data-dialog" => "upgrade-message-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="chat"></i>', array("id" => "send-chat", "data-dialog" => "upgrade-chat-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="hello"></i>', array("id" => "send-a-hello", "data-dialog" => "upgrade-hello-dialog" )); ?>
            <?php echo Html::anchor("#", '<i class="favorite"></i>', array("id" => "send-favorite", "data-dialog" => "upgrade-favorite-dialog")); ?>
        <?php else: ?>
            <?php echo Html::anchor("#", '<i class="messages"></i>', array("class" => "send-message-icon", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $member['id'], "data-username" => Model_Profile::get_username($member['user_id']), "data-profile-picture" => Model_Profile::get_picture($member['picture'], $member['user_id'], "members_list"))); ?>
            <?php echo Html::anchor("#", '<i class="chat"></i>', array("class" => "send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($member['user_id']), "data-full-name" => Model_Profile::get_username($member['user_id']), "data-profile-picture" => Model_Profile::get_picture($member['picture'], $member['user_id'], "members_list"))); ?>
            <?php echo Html::anchor("#", '<i class="hello"></i>', array("class" => "send-hello-icon", "data-confirmation-dialog" => "hello-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $member['id'], "data-username" => Model_Profile::get_username($member['user_id']), "data-profile-picture" => Model_Profile::get_picture($member['picture'], $member['user_id'], "members_list"))); ?>
            <?php echo Html::anchor("#", '<i class="favorite"></i>', array("class" => "save-profile-icon", "data-confirmation-dialog" => "favorite-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $member['id'], "data-username" => Model_Profile::get_username($member['user_id']), "data-profile-picture" => Model_Profile::get_picture($member['picture'], $member['user_id'], "members_list"))); ?>
        <?php endif; ?>
    </p>
    <?php echo Form::open(array("id" => "manage-friendship-form", "action" => "friendship/manage_friends", "class" => "clearfix")) ?>
    
        <?php echo Html::anchor("#", "BLOCK", array("class" => "block", "data-friend-id" => $member['id'], "data-friendship-status" => Model_Friendship::STATUS_BLOCKED)); ?>
        <?php echo Html::anchor("#", "DELETE", array("class" => "delete", "data-friend-id" => $member['id'], "data-friendship-status" => Model_Friendship::STATUS_DELETED)); ?>
    <?php echo Form::close(); ?>
</div>
