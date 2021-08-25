<div id="content" class="clearfix">
<aside id="left-sidebar">
    <div id="profile-summary">
        <div class="content">
		   <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
            <div id="profile-pic">  <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
            <div id="states">
                <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
            </div>
            <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
        </div>
    </div>

    <?php echo View::forge("profile/partials/profile_nav"); ?>
    <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
</aside>
<div id="middle">
    <section id="my-favorites">
       <div id="favorites"> <h2>My <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'Referrals' : 'Favorites' ?></h2></div>
        <div class="content clearfix">
            <?php if ($favorites_profiles): ?>
                <?php foreach ($favorites_profiles as $member): ?>
                    <?php echo View::forge("profile/partials/member_thumb", array("member" => $member)); ?>
                    <?php $user = \Auth\Model\Auth_User::find($member->user_id)?>
                    <?php $member["username"] = $user["username"]; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'Referrals' : 'Favorites' ?>.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<aside id="right-sidebar">
    <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members,'referd' => $referd,'subscribed' => $subscribed)); ?>

    <div class="ad">
        <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
    </div>
</aside>
</div>