<div class="member">
    <div class="user-image"><?php echo Html::anchor(Uri::create('profile/public_profile/' . $member['id'].'/'."browse"), Html::img(Model_Profile::get_picture($member['picture'], $member['user_id'], "members_medium"))); ?></div>
    <?php if($photo_selected == 0): ?>
        <div class="caption">
            <p class="name"><?php echo Model_Profile::get_username($member['user_id'],18) ?></p>
            <p class="location"><?php echo substr($member['city'],0,19) . ' ' . $member['state'] ?></p>
        </div>
    <?php endif; ?>
</div>


