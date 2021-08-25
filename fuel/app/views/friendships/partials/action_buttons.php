<?php echo Form::open(array("id" => "friend-request-response-form-" . $sender->id . "-" . $receiver->id , "class" => 'accept-reject', "action" => "friendships/update")); ?>
<div class="actions">
    <?php if(Model_Friendship::has_sent_request($sender->id, $receiver->id)){ ?>
        <a class="response-button-<?php echo $sender->id . "-" . $receiver->id; ?>" href="#" data-text="Accept friend request" data-item-id="<?php echo $sender->id . "-" . $receiver->id; ?>" data-sender-id="<?php echo $sender->id; ?>" data-receiver-id="<?php echo $receiver->id; ?>" data-status="<?php echo Model_Friendship::STATUS_ACCEPTED; ?>">
            <i class='icon-ok-circle'></i>Accept
        </a>
        <a class="response-button-<?php echo $sender->id . "-" . $receiver->id; ?>" href="#" data-text="Reject friend request"  data-item-id="<?php echo $sender->id . "-" . $receiver->id; ?>" data-sender-id="<?php echo $sender->id; ?>" data-receiver-id="<?php echo $receiver->id; ?>" data-status="<?php echo Model_Friendship::STATUS_REJECTED; ?>">
            <i class='icon-remove-circle'></i>Decline
        </a>
    <?php } ?>
</div>
<?php echo Form::close(); ?>
