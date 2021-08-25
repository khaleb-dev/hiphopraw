<?php $sender = Model_User::find($message->from_user_id); ?>
<?php $receiver =  Model_User::find($message->to_user_id); ?>
<div id="<?php echo $message->id; ?>" class="message clearfix">
    <div class="sender-info">
        <?php if($status == Model_Message::SENT) { ?>
            <?php echo Html::anchor("users/show/" . $receiver->id, Html::img(Model_User::get_picture($receiver, "message")), array("class" => "sender-thumb")); ?>
            <span><?php echo $receiver->username; ?></span>
        <?php } else { ?>
            <?php echo Html::anchor("users/show/" . $sender->id, Html::img(Model_User::get_picture($sender, "message")), array("class" => "sender-thumb")); ?>
            <span><?php echo $sender->username; ?></span>
        <?php } ?>
    </div>
    <div class="message-detail">
        <p class="sender">
            <?php if($status == Model_Message::INBOX) { ?>
                <?php echo $sender->username . " sent you a message, " . Date::forge($message->created_at)->format("%M.%d,%Y %H:%M"); ?>
            <?php } else { ?>
                <?php echo "Message composed on " . Date::forge($message->created_at)->format("%h %d, %Y %H:%M"); ?>
            <?php }; ?>
        </p>
        <p class="detail"><?php echo Html::anchor("messages/show/$message->id" , substr($message->detail, 0, 100)); ?> ...</p>
        <p class="view-more">
            <?php if($status == Model_Message::DRAFT){ ?>
                <?php echo Html::anchor("users/" . $current_user->id . "/messages/edit/" . $message->id , "Edit Draft"); ?>    
            <?php } ?>
            <input class="move-to-trash" data-message-id="<?php echo $message->id; ?>" data-user-id="<?php echo $current_user->id; ?>"  type="checkbox" /> Remove
        </p>
    </div>
</div>