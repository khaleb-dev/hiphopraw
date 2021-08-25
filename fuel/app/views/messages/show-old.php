<div id="center" class="clearfix">
    <div id="sidebar-left">
        <?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user, "friends" => $friends, "followers" => $followers)); ?>

        <?php echo View::forge("pages/partials/enter_your_videoke"); ?>
    </div>
    <div id="content" class="videos with-sidebar-left profile">
        <div id="messages">
            <h2 class="clearfix"><span>Messages</span> <p><?php echo Html::anchor(Router::get("home"), "Delete Conversation", array("class" => "button rounded-corners")); ?> <?php echo Html::anchor(Router::get("my_messages"), "Back", array("class" => "button rounded-corners")); ?> </p></h2>
            <div class="content-box">
                <?php echo View::forge("messages/partials/message_menu"); ?>

                <div class="message clearfix">
                    <div class="sender-info">
                        <?php echo Html::anchor("users/show/".$sender->id, Html::img(Model_User::get_picture($sender, "message")), array("class" => "sender-thumb")); ?>
                        <span><?php echo $sender->username; ?></span>
                    </div>
                    <div class="message-detail">
                        <div class="conversation">
                            <div class="detail clearfix">
                                <span class="user-control-icon message-icon">&nbsp;</span> <span class="sender"><?php echo $sender->username; ?></span>
                                <p><?php echo $message->detail; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="back"><?php echo Html::anchor("users/" . $current_user->id . "/messages/list/" . Model_Message::INBOX, "&laquo;  Back"); ?></p>
            </div>
        </div>
    </div>
</div>