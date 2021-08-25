<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">

                <div id="profile_name"><?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link",)); ?></div>
                <div id="profile-pic"> <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>

                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
                <div id="date">Member Since: <?php echo date('m/d/Y', $current_profile->created_at) ?></div>
            </div>
        </div>

        <?php echo View::forge("profile/partials/profile_nav"); ?>

        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">

        <section id="whats-going-on">
            <div id="whats-going"> <h2>What's Going On?</h2>

            </div>
            <section id="notifications">
                <?php
                if (isset($notifications)):
                    $notification_type = null;

                    foreach ($notifications as $notification):
                        if ($notification_type !== $notification['category']):

                            $notification_type = $notification['category'];
                            switch ($notification_type) {
                                case (Model_Notification::EVENT_NOTIFICATIONS):
                                    $notification_type_name = "Events";
                                    break;

                                default:
                                    $notification_type_name = "Notifications";
                                    break;
                            }
                            ?>

                            <h3><?php echo $notification_type_name ?></h3>

                            <?php
                        endif;

                        switch ($notification['object_type_id']) {
                            case (Model_Notification::EVENT_RSVP_SENT):
                                $notification_link = 'event/view/' . Model_Event::get_slug($notification['object_id']);
                                $notification_object = Model_Event::get_title($notification['object_id']);
                                $event = Model_Event::get_start_date($notification['object_id']);
                                $notification_verb = $event['start_date'];
                                break;

                            case (Model_Notification::MESSAGE_SENT):
                                $notification_link = 'message/index/';
                                $message_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($message_sender->user_id);
                                $notification_verb = ' sent you a <a id="message_sent" style="">message!<i ></i> </a>';
                                break;

                            case (Model_Notification::HELLO_SENT):
                                $hello = Model_Hello::find($notification['object_id']);
                                $hello_receiver = Model_Profile::find($hello->to_member_id);
                                $notification_link = \Fuel\Core\Uri::create('profile/public_profile/' . $hello_receiver->id);
                                $notification_object = 'You';
                                $notification_verb = ' sent a hello to ' . Model_Profile::get_username($hello_receiver->user_id) . '!';
                                break;

                            case (Model_Notification::HELLO_RECEIVED):
                                $notification_link = \Fuel\Core\Uri::create('profile/my_hellos');
                                $hello_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($hello_sender->user_id);
                                $notification_verb = ' sent you a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> hello!</a>';
                                break;
                            case (Model_Notification::SAVED_AS_FAVORITE):
                                $favorite = Model_Favorite::find($notification['object_id']);
                                $favorite_sender = Model_Profile::find($favorite->member_id);
                                $notification_link = \Fuel\Core\Uri::create('profile/public_profile/' . $favorite_sender->id);
                                $notification_object = Model_Profile::get_username($favorite_sender->user_id);
                                $notification_verb = ' saved you as <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> favorite!</a>';
                                break;
                            case (Model_Notification::CHAT_REQUEST_SENT):
                                $notification_link = \Fuel\Core\Uri::create('profile/public_profile/' . $notification['actor_id']);
                                $chat_request_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($chat_request_sender->user_id);
                                $notification_verb = ' sent you a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;">Chat Request!</a>';
                                break;
                            case (Model_Notification::DATING_PACKAGE_INVITATION_SENT):
                                $notification_link = 'datingpackage/refer/' . $notification['object_id'];
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($invite_sender->user_id);
                                $notification_verb = ' has invited you to a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> dating package!</a>';
                                break;

                            case (Model_Notification::DATING_AGENT_INVITATION_SENT):
                                $notification_link = 'agent/view/' . $notification['object_id'];
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($invite_sender->user_id);
                                $notification_verb = ' has invited you to a <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;">dating agent!</a>';
                                break;

                            case (Model_Notification::REFERRED_A_FRIEND):
                                $notification_link = 'profile/public_profile/' . $notification['object_id'];
                                $invite_sender = Model_Profile::find($notification['actor_id']);
                                $notification_object = Model_Profile::get_username($invite_sender->user_id);
                                $notification_verb = '<a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> has referred you a friend!</a>';
                                break;

                            case (Model_Notification::NEW_MATCH_FOUND):
                                $notification_link = 'profile/dashboard';
                                $notification_object = 'You';
                                $notification_verb = ' <a style="text-decoration: underline;-moz-text-decoration-color: #34b0cf;"> have new matches!</a>';
                                break;

                            default:
                                break;
                        }
                        ?>

                        <div class="notification-entry" id="notification-entry-<?php echo $notification['id'] ?>">
                            <a href="<?php echo $notification_link ?>">
                                <em><span  class="subject"><?php echo $notification_object ?></span></em>
                                <em><span  class="content"><?php echo $notification_verb ?></span></em>
                            </a>
                            <a title="Remove" id="delete" class="delete" href="notification/mark_as_seen/<?php echo $notification['id'] ?>"></a>
                            <span class="time"><?php echo date('Y-m-d h:ia', $notification['created_at']); ?></span>
                        </div>

                        <?php
                    endforeach;
                else:
                    ?>

                    <p>You have no notification.</p>

                <?php
                endif;
                ?>

            </section>
        </section>
        <section id="latest-friend-requests">
            <div id="latest_friends_text">
                <h2>Latest Friends</h2>
            </div>           
            <?php if ($latest_friends): ?>
                <div id="members-container" class="clearfix">
                    <div class="left-scroller">
                        <a href="#" data-direction="left"><?php echo Asset::img("profile/left_scroller_2.png"); ?></a>
                    </div>
                    <div id="visible-members">
                        <div id="member-items" class="clearfix" data-left="0">
                            <?php foreach ($latest_friends as $member): ?>
                                <?php echo View::forge("profile/partials/member_thumb", array("member" => $member)); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="right-scroller">
                        <a href="#" data-direction="right"><?php echo Asset::img("profile/right_scroller_2.png"); ?></a>
                    </div>
                </div>
            <?php else: ?>
                <p>No friends added yet!</p>
            <?php endif; ?>
        </section>

        <section id="events">
            <div id="dating_packages">
                <h2>Dating Packages</h2>
            </div>

            <?php
            if (isset($active_datingPackages) && $active_datingPackages !== false):
                foreach ($active_datingPackages as $active_datingPackage):
                    ?>
                    <div id="event-list">

                        <?php
                        if (empty($active_datingPackage['picture'])):
                            echo \Fuel\Core\Asset::img(array('temp/dating_package_1.jpg'));
                            ?>
                            <?php
                        else:
                            ?>
                            <img src="<?php echo \Fuel\Core\Uri::base() . 'uploads/packages/' . $active_datingPackage['picture'] ?>" />
                        <?php
                        endif;
                        ?>
                        <p >
                            <span class="dating-package-title">  <strong><?php echo ucfirst($active_datingPackage['title']); ?> </strong><br/> </span>
                            <span class="text"><?php echo ucfirst(substr($active_datingPackage['long_description'], 0, 350). "...") ?></span>


                        </p>
                        <div id="learn-more">
                            <?php echo \Fuel\Core\Html::anchor('datingPackage/refer/' . $active_datingPackage['id'], 'Send a Date Invitation', array('class' => 'learn-more')) ?>
                        </div>
                    </div>

                    <?php
                endforeach;
            else:
                ?>
                <div class="no-package-list" >
                    
                    No Dating Package found from your location.
                </div>
            <?php
            endif;
            ?>
        </section>


        <section id="refer-friend">
            <div id="refer">    <h2>Invite Your Friend to Join for Free</h2></div>
            <div class="sender-form">
                <form id="refer-friend-form" action="<?php echo \Fuel\Core\Uri::create('agent/refer_a_friend') ?>" >
                    <p>
                        <label for="email">Email:</label><br />
                        <input  id="email" type="text" name="email">
                    </p>
                    <p>
                        <label for="message">Message:</label><br />
                        <textarea id="message" name="message" cols="130"></textarea>
                    </p>
                    <p class="refer-button clearfix">
                        <button type="submit" id="refer-a-friend" class="button">Refer a Friend Now!</button>
                    </p>
                </form>
            </div>
        </section>

    </div>
    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online");  ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_new_2.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>




