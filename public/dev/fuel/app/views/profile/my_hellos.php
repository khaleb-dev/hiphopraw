<div id="content" class="clearfix">
<aside id="left-sidebar">
    <div id="profile-summary">
        <div class="content">
		 <div id="profile_name"><?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
         <div id="profile-pic"> <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
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
    <section id="my-hellos">
        <div id="hello"><h2>My Hellos </h2></div>
        <div class="content clearfix">
            <?php if ($hello_profiles): ?>
                <?php foreach ($hello_profiles as $member): ?>
                    <?php echo View::forge("profile/partials/member_thumb", array("member" => $member)); ?>

                    <?php $user = \Auth\Model\Auth_User::find($member->user_id)?>
                    <?php $member["username"] = $user["username"]; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No Hellos</p>
            <?php endif; ?>
        </div>
    </section>
     
    <section id="refer-friend">
           <div id="refer"> <h2>Refer a Friend</h2></div>
            <div class="event-list">
               <form id="refer-friend-form" action="<?php echo \Fuel\Core\Uri::create('agent/refer_a_friend') ?>" >
                    <p>
                        <label for="email">Email:</label><br />
                        <input id="email" type="text" name="email">
                    </p>
                    <p>
                        <label for="message">Message:</label><br />
                        <textarea id="message" name="message" cols="130"></textarea>
                    </p>
                    <p>
                        <button type="submit" id="refer-a-friend" class="button">Refer a Friend Now!</button>
                    </p>
                </form>
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

