<header id="main-header" class="clearfix">
    <?php echo Asset::img('pages/home2/color.jpg', array('class' => 'header-top')); ?>
    <div class="clearfix">
        <div id="logo-container">
            <?php echo Html::anchor(Uri::base(), Asset::img("logo_main_2.png")); ?>
            <span id="beta">BETA</span>
        </div>
        <?php if(isset($current_profile)): ?>
            <div id="top-nav-container" class="clearfix">
                <div>
                    <?php echo Html::anchor(Uri::create("profile/dashboard"), '<span>Home</span>'. Asset::img("my_home_icon.png")); ?>
                </div>
                <div>
                    <?php echo Html::anchor(Uri::create("message/index"), '<span>Messages</span>'. Asset::img("my_message_icon.png")); ?>
                </div>
                <div>
                    <?php echo Html::anchor(Uri::create("profile/my_friends"), '<span>Request</span>'. Asset::img("my_friend_request_icon.png")); ?>
                </div>
                <div id="round-profile-pic-container">
                    <?php echo Html::anchor("", Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "members_list")) . '<span>'. $current_user->username . '</span>'); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>

   