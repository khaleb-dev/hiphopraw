<?php echo Form::open(array("id" => "follower-request-form", "action" => $action)); ?>
    <?php echo Form::hidden('sender_id', $sender->id); ?>
    <?php echo Form::hidden('receiver_id', $receiver->id); ?>
    <span>
      <button class = "button-follower-container"><?php echo Asset::img('user/follow.png', array('class' => 'follower-img')); ?><?php echo Form::submit("#", "Follow This Model",array("class"=>"follow-request-actual-button")); ?></button>
    </span>
<?php echo Form::close(); ?>