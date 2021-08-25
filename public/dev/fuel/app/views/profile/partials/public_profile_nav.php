<nav id="public-profile-nav">
 <div id="collection">
   Quick Links
 </div>
 <?php if($profile->member_type_id === '3'):?>
           <?php if (($current_profile->id != $profile->id) && $current_profile->member_type_id == 2 || $current_profile->member_type_id == 3 || $current_user->group_id == 5):  ?>
                <div id="black" class="datingAgent">
                    <?php echo Html::anchor(Uri::create("membership/dating_agent", array(), array(), true), '<i class="fa fa-check-square-o"></i> Book Me'); ?>
                </div>
                <div id="blue" class="datingAgent">
                    <?php echo Html::anchor("#", '<i class="fa fa-comment"></i> Talk To Me', array("class" => "send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($profile->user_id), "data-full-name" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list")) ); ?>
                </div>
                <div id="red" class="datingAgent">
                    <?php echo Html::anchor('#', '<i class="fa fa-users"></i> Refer Me', array('data-dialog' => 'refer-to-friend-dialog', 'class' => 'refer-friend','id' => 'send-hello')); ?>
                </div>
                <div id="green" class="datingAgent">
                    <?php echo Html::anchor('#',
                        '<i class="fa fa-envelope"></i> Send Message', array("data-confirmation-dialog" => "message-confirmation-dialog",
                            'class' => 'send-message-icon',
                            'data-username' => Model_Profile::get_username($profile->user_id),
                            'data-to-member-id' => $profile->id,
                            'data-from-member-id' => $current_profile->id,
                            "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list")
                        )); ?>
                </div>
                <div id="yellow" class="datingAgent">
                    <?php echo Html::anchor('#',
                        '<i class="fa fa-warning"></i> Report Me', array(
                            "data-confirmation-dialog" => "message-confirmation-dialog",
                            'data-username' => Model_Profile::get_username($profile->user_id),
                            'data-dialog' => 'report-me-dialog',
                            'id' => 'report-me',
                        )); ?>
                </div>
           <?php else: ?>
                <div id="black" class="datingAgent">
                    <?php echo Html::anchor("#", '<i class="fa fa-check-square-o"></i> Book Me', array("id" => "book-me", "data-dialog" => "upgrade-book-dialog", )); ?>
                </div>
                <div id="blue" class="datingAgent">
                    <?php echo Html::anchor("#", '<i class="fa fa-comment"></i> Talk To Me', array("id" => "send-chat", "data-dialog" => "upgrade-chat-dialog",)); ?>
                </div>
                <div id="red" class="datingAgent">
                    <?php echo Html::anchor("#", '<i class="fa fa-users"></i> Refer Me', array("id" => "refer-me", "data-dialog" => "upgrade-refer-dialog")); ?>
                </div>
                <div id="green" class="datingAgent">
                    <?php echo Html::anchor("#", '<i class="fa fa-envelope"></i> Send Message', array("id" => "send-message","data-dialog" => "upgrade-message-dialog",)); ?>
                </div>
                <div id="yellow" class="datingAgent">
                    <?php echo Html::anchor("#", '<i class="fa fa-warning"></i> Report Me', array("id" => "report-me", 'data-dialog' => 'upgrade-report-dialog',)); ?>
                </div>
           <?php endif; ?>
 <?php else: ?>
        <?php if ((Model_Friendship::are_friends($current_profile->id, $profile->id) AND $current_profile->id != $profile->id) || $current_profile->member_type_id == 2 || $current_profile->member_type_id == 3 || $current_user->group_id == 5):  ?>
            <?php if (!Model_Friendship::request_exchanged($current_profile->id, $profile->id) AND $current_profile->id != $profile->id):  ?>
                <?php echo Html::anchor("#", 'Request as Friend' , array("id" => "request-as-friend", "data-dialog" => "send-invite-dialog")); ?>
            <?php endif; ?>
            <?php echo Html::anchor("#", '<i class="messages"></i> Send Message', array("class" => "send-message-icon", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $profile->id, "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list") )); ?>
            <?php echo Html::anchor("#", '<i class="favorite"></i> Save as Favorite', array("class" => "save-profile-icon", "data-confirmation-dialog" => "favorite-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $profile->id, "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"))); ?>
            <?php echo Html::anchor("#", '<i class="my_hellos"></i> Send Hello', array("class" => "send-hello-icon", "data-confirmation-dialog" => "hello-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $profile->id, "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"))); ?>
            <?php echo Html::anchor("#", '<i class="refer_to_friends"></i> Refer to a Friend', array("class" => "refer-friend", "data-dialog" => "refer-to-friend-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="chat_talk"></i> Start a Chat Talk', array("class" => "send-chat-request", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($profile->user_id), "data-full-name" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"))); ?>
        <?php else: ?>
            <?php if (!Model_Friendship::request_exchanged($current_profile->id, $profile->id) AND $current_profile->id != $profile->id):  ?>
                <?php echo Html::anchor("#", 'Request as Friend' , array("id" => "request-as-friend", "data-dialog" => "upgrade-send-invite-dialog")); ?>
            <?php endif; ?>
            <?php echo Html::anchor("#", '<i class="messages"></i> Send Message', array("id" => "send-message", "data-dialog" => "upgrade-message-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="favorite"></i> Save as Favorite', array("id" => "send-favorite", "data-dialog" => "upgrade-favorite-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="my_hellos"></i> Send Hello', array("id" => "send-a-hello", "data-dialog" => "upgrade-hello-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="refer_to_friends"></i> Refer to a Friend', array("id" => "refer-a-friend", "data-dialog" => "upgrade-refer-friend-dialog")); ?>
            <?php echo Html::anchor("#", '<i class="chat_talk"></i> Start a Chat Talk', array("id" => "send-chat", "data-dialog" => "upgrade-chat-dialog")); ?>
        <?php endif; ?>
 <?php endif;?>
</nav>