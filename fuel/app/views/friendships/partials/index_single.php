<div id="friend-<?php echo $friend->id . "-" . $current_user->id; ?>" class="item">
    <?php echo Html::anchor('users/show/' . $friend->id, Html::img(Model_User::get_picture($friend, "home_page"), array("width" => "111", "height" => "99"))); ?>
    <h3><?php echo $friend->username; ?></h3>    
    <?php echo View::forge("friendships/partials/action_buttons", array("sender" => $friend, "receiver" => $current_user)); ?> 
    <?php echo View::forge("friendships/partials/action_alt_buttons", array("sender" => $friend, "receiver" => $current_user, "pending" => "pending")); ?>
</div>