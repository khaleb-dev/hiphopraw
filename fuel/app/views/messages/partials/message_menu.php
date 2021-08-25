<ul id="messages-nav"  class=" clearfix <?php echo isset($active_message_link) ? $active_message_link : ''; ?>" >
    <li id="inbox" class="first"><?php echo Html::anchor("users/" . $current_user->id . "/messages/list/" . Model_Message::INBOX, "Inbox"); ?></li>
    <li id="compose"><?php echo Html::anchor("users/" . $current_user->id . "/messages/new" , "Compose"); ?></li>
    <li id="sent"><?php echo Html::anchor("users/" . $current_user->id . "/messages/list/" . Model_Message::SENT, "Sent"); ?></li>
    <li id="draft"><?php echo Html::anchor("users/" . $current_user->id . "/messages/list/" . Model_Message::DRAFT, "Drafts"); ?></li>
    <li id="trash"><?php echo Html::anchor("users/" . $current_user->id . "/messages/list/" . Model_Message::TRASH, "Trash"); ?></li>   
</ul>