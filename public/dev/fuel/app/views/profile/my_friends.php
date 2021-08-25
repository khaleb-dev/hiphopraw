<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			    <div id="profile_name">  <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
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
        <section id="pending-friends">
            <div id="pending"><h2>Pending <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'Client' : 'Friend' ?> Request</h2></div>
            <div class="content clearfix">
                <?php if ($pending_friends): ?>
                    <?php foreach ($pending_friends as $member): ?>
                        <?php echo View::forge("profile/partials/friend_request_thumb", array("member" => $member)); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No new <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'client' : 'friend' ?> requests!</p>
                <?php endif; ?>
            </div>
        </section>
        <section id="my-friends">
            <div id="friends"><h2><?php echo Model_Profile::is_dating_agent($current_profile->id)? 'My Clients' : 'My Friends' ?></h2></div>
            <div class="content clearfix">
                <?php if ($friends): ?>
                    <?php foreach ($friends as $member): ?>
                        <?php echo View::forge("profile/partials/friends_thumb", array("member" => $member)); ?>

                        <?php $user = \Auth\Model\Auth_User::find($member->user_id)?>
                        <?php $member["username"] = $user["username"]; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'clients' : 'friends' ?> added yet!</p>
                <?php endif; ?>
            </div>

        </section>

        <section id="refer-friend">
           <div id="refer"> <h2>Refer a <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'Client' : 'Friend' ?></h2></div>
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
                        <button type="submit" id="refer-a-friend" class="button">Refer a <?php echo Model_Profile::is_dating_agent($current_profile->id)? 'Client' : 'Friend' ?> Now!</button>
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
