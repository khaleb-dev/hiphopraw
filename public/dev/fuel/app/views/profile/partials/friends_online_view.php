<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
                <?php echo Html::anchor('#', Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                <?php echo Html::anchor("#", $current_user->username, array("id" => "profile-link")); ?>
            </div>
        </div>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    
    <aside id="right-sidebar">
        <?php echo View::forge("profile/partials/allfriends_online", array("online_members" => $online_members)); ?>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>





