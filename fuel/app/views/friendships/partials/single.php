<div class="item">
    <?php echo Html::anchor('users/show/' . $friend->id, Html::img(Model_User::get_picture($friend, "home_page"), array("width" => "111", "height" => "99"))); ?>
    <h3><?php echo $friend->username; ?></h3>
    <?php if(Model_Friendship::has_sent_request($friend->id, $current_user->id)){ ?>
       <?php echo View::forge("friendships/partials/form", array("sender" => $friend, "receiver" => $current_user, "action" => $action)); ?> 
    <?php } ?>
</div>