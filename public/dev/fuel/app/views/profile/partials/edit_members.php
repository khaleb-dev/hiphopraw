<div class="member">
    <?php echo Html::anchor(( ! Model_Profile::is_dating_agent($current_profile->id)) ? Uri::create('profile/public_profile/' . $member['id']) : Uri::create('agent/client_view/' . $member['id'])
	, Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?>
    <p><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
    <p class="location"><?php echo $member['city'] . ' ' . $member['state'] ?></p>
    
</div>