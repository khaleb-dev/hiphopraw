<div class="sidebar-content profile-control content-box">
    <h3><?php echo $user->username; ?>'s  Profile</h3>
    <div class="content">
        <?php echo Html::anchor("users/show/" . $user->id, Html::img(Model_User::get_picture($user, "profile"))); ?>
        <p class="location"><strong><?php echo $user->city . ", " . $user->state; ?></strong></p>
        <p class="member-since">Member Since: <?php echo Date::forge($user->created_at)->format("%m/%d/%Y"); ?></p>
        <p><strong>Category: <?php echo $user->category(); ?></strong></p>
        <p><strong><?php echo $videokes_count; ?> Videos</strong>  <!-- &middot;<span>(Contest Winner)</span>--></p>

        <?php if ($current_user) { ?>
            <div class="buttons">
                <?php if (!Model_Friendship::request_exchanged($current_user->id, $user->id) AND $current_user->id != $user->id) { ?>
                    <?php echo View::forge("friendships/partials/form", array("sender" => $current_user, "receiver" => $user, "action" => "friendships/create")); ?>
                <?php }
                 ?>
            
                <?php echo View::forge("messages/partials/form_modal", array("user" => $user)); ?>
            </div>
        <?php } ?>

        <h4>About Me</h4>
        <p id="about-me">
            <?php echo $user->about_me(); ?>
        </p>
        <p class="more grey"><?php echo Html::anchor("#", "Read More", array("id" => "read-more")); ?></p>
    </div>
</div>
