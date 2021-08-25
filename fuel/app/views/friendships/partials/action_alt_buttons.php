<?php $pending_class = isset($pending) ? 'pending' : '' ; ?>
<?php $item_id = isset($pending) ? $sender->id . "-" . $receiver->id : $sender->id . "-alt-" . $receiver->id ; ?>

<?php echo Form::open(array("id" => "friend-request-response-form-" . $sender->id . "-alt-" . $receiver->id , "class" => $pending_class, "action" => "friendships/update")); ?>
<div class="actions">
    <?php if(Model_Friendship::are_friends($sender->id, $receiver->id) || isset($pending)){ ?>
        <a href="#" data-text="Block user" data-item-id="<?php echo $item_id; ?>" data-sender-id="<?php echo $sender->id; ?>" data-receiver-id="<?php echo $receiver->id; ?>" data-status="<?php echo Model_Friendship::STATUS_BLOCKED; ?>">
            <i class='icon-ban-circle'></i>Block
        </a>
        <a href="#" data-text="Delete user" data-item-id="<?php echo $item_id; ?>" data-sender-id="<?php echo $sender->id; ?>" data-receiver-id="<?php echo $receiver->id; ?>" data-status="<?php echo Model_Friendship::STATUS_DELETED; ?>">
            <i class='icon-remove-circle'></i>Delete
        </a>
    <?php } ?>   
</div>
<?php echo Form::close(); ?>
