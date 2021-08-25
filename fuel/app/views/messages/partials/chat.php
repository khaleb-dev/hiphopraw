<?php //echo Form::open(array("id" => "chat-request-form", "action" => $action)); ?>
    <?php //echo Form::hidden('sender_id', $sender->id); ?>
    <?php //echo Form::hidden('receiver_id', $receiver->id); ?>
    <?php //echo Form::hidden('status', Model_Friendship::STATUS_SENT); ?>
    <button class="green-btn">
      <a href="#" class ="send-chat-request" data-confirmation-dialog ="chat-confirmation-dialog" data-username ="<?= $receiver->username ?>" data-full-name ="<?= $receiver->username ?>" >
       <?php echo Asset::img('icons/startChat.png'); ?> Start Chat</a> 
    </button>
<?php //echo Form::close(); ?>