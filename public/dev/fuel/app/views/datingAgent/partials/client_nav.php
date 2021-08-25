<nav id="client_nav">
<!--    --><?php //if ((Model_Friendship::are_friends($current_profile->id, $dating_agent->id) AND $current_profile->id != $dating_agent->id) || $current_profile->member_type_id == 2 || $current_profile->member_type_id == 3 || $current_user->group_id == 5){  ?>
    <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3 || $current_user->group_id == 5){  ?>

        <div id="red"><?php echo Html::anchor(Uri::create("profile/public_profile/".$dating_agent->id), '<i class="fa fa-user"></i> My Profile'); ?></div>
        <div id="black"><?php echo Html::anchor(Uri::create("membership/dating_agent", array(), array(), true), '<i class="fa fa-check-square-o"></i> Book Me'); ?></div>

       <div id="blue"> <?php echo Html::anchor("#",
            '<i class="fa fa-comment chat_talk"></i> Talk To Me',
            array(
                "class" => "send-chat-request",
                "data-confirmation-dialog" => "chat-confirmation-dialog",
                "data-username" => Model_Profile::get_username($dating_agent->user_id),
                "data-full-name" => Model_Profile::get_username($dating_agent->user_id),
                "data-profile-picture" => Model_Profile::get_picture($member['picture'], $member['user_id'], "members_list")
            )); ?>
        </div>
        <div id="red">
        <?php echo Html::anchor('#',
                '<i class="fa fa-users"></i> Refer Me', array('data-dialog' => 'refer-me-dialog',
                        'class' => 'friends','id' => 'refer-me')); ?>
                        </div>
                        <div id="green">
        <?php echo Html::anchor('#',
                '<i class="fa fa-envelope"></i> Send Message', array('data-dialog' => 'send-message-dialog',
                        'class' => 'friends', 'id' => 'send-message',
                        'data-message-to' => Model_Profile::get_username($dating_agent->user_id),
                        'data-to-member-id' => $dating_agent->id,
                        'data-from-member-id' => $current_profile->id,
                        )); ?>
           </div>
           <div id="yellow">
        <?php echo Html::anchor('#',
                '<i class="fa fa-warning"></i> Report Me', array(
                        'data-dialog' => 'report-me-dialog',
                        'id' => 'report-me')); ?>
                        </div>
    <?php } else {?>
        <div id="red"><?php echo Html::anchor(Uri::create("profile/public_profile/".$dating_agent->id), '<i class="fa fa-user"></i> My Profile'); ?></div>

        <div id="black" class="datingAgent">
            <?php echo Html::anchor("#",
                '<i class="fa fa-check-square-o"></i> Book Me',
                array("id" => "send-hello",
                    "data-dialog" => "upgrade-book-dialog",
                )
            );
            ?>
        </div>
        <div id="blue" class="datingAgent">
            <?php echo Html::anchor("#",
                '<i class="fa fa-comment"></i> Talk To Me',
                array(
                    "id" => "send-hello",
                    "data-dialog" => "upgrade-chat-dialog",
                )
            );
            ?>
        </div>
        <div id="red">
            <?php echo Html::anchor('#',
                '<i class="fa fa-users"></i> Refer Me', array('data-dialog' => 'refer-me-dialog',
                    'class' => 'friends','id' => 'refer-me')); ?>
        </div>

        <div id="green" class="datingAgent">
            <?php echo Html::anchor("#",
                '<i class="fa fa-envelope"></i> Send Message',
                array(
                    "id" => "send-hello",
                    "data-dialog" => "upgrade-message-dialog",
                )
            );
            ?>
        </div>

        <div id="yellow" class="datingAgent">
            <?php echo Html::anchor('#',
                '<i class="fa fa-warning"></i> Report Me', array(
                    'data-dialog' => 'report-me-dialog',
                    'id' => 'report-me')); ?>
        </div>

    <?php } ?>
</nav>
