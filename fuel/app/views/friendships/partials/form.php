<?php echo Form::open(array("id" => "friend-request-form", "action" => $action)); ?>
    <?php echo Form::hidden('sender_id', $sender->id); ?>
    <?php echo Form::hidden('receiver_id', $receiver->id); ?>
    <?php echo Form::hidden('status', Model_Friendship::STATUS_SENT); ?>
    <span>

      <button class = "button-request-container"><?php echo Asset::img('user/friend.png', array('class' => 'friend-img')); ?><?php echo Form::submit("#", "Send Friend Request",array("class"=>"friend-request-actual-button")); ?></button>
    </span>
<?php echo Form::close(); ?>

