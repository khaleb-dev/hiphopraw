<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Upgrade",array('class' => 'white')); ?> to never see ads again. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Remove",array('class' => 'white')); ?></p>
</div>
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			    <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
                <div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
                <div id="states">
                    <?php echo Asset::img("state_icons.png"); ?> <?php  echo $current_profile->city == "" ? $current_profile->state : $current_profile->city . ", ". $current_profile->state; ?>
                </div>
            </div>
        </div>
        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <div class="border-icon1"></div>
        <div class="border-icon2"></div>
        <div class="border-icon3"></div>
        <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
    </aside>
    <div id="middle">

        <section class="perform-activity"> 
            <div class="header">
                <ul>
                <li><a class="option active" href=""><i class="new-post"></i>New Post</a></li>
                <li><a class="option" href=""><i class="new-photo"></i>Upload a photo</a></li>
                <li><a class="option" href=""><i class="new-message"></i>Send a Message</a></li>
                </ul>
            </div>
            <div class="activity-content">
                <div class="write-post">
                    <form method="POST">
                        <input type="text" class="post-input" placeholder="Want to say something..." />
                        <a class="add-person" href="#"><?php echo Asset::img('profile/addperson.jpg'); ?></a>
                        <div class="vertical-separator"></div>
                        <button class="submit-btn" type="submit"><?php echo Asset::img('profile/submit-post.jpg'); ?></button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </section>

        <section class="latest-matches"> 
            <div class="header-section">
                <p class="header-text pull-left">Latest matches</p>
                <p class="pull-right">
                    <?php echo Html::anchor("/profile/quicksearch", "View more matches"); ?>
                </p>
                <div class="clearfix"></div>
            </div>
            <div class="content match-slider">
                <?php echo View::forge("profile/partials/latest_member_thumb", array("latest_members" => $latest_members)); ?>
            </div>
        </section>

        <section class="user-status">
            <div class="header-section">
                <p class="header-text pull-left">What's Going On?</p>
                <div class="clearfix"></div>
            </div>
            <div class="content">
                <?php if (isset($notifications)):
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

                        <?php endif;

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

                        <div class="activity">
                            <div class="user-info pull-left">
                                <div class="pull-left avatar">
                                    <?php $activity_profile = Model_Profile::find($notification['actor_id']); ?>
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/'. $notification['actor_id']), Html::img(Model_Profile::get_picture($activity_profile->picture, $activity_profile->user_id, "activity-avatar"))); ?>
                                </div>
                                <div class="pull-left">
                                    <p class="activity-user"><?php echo $notification_object ?> <span class="light-gray"><?php echo $notification_verb ?></span></p>
                                    <p class="activity-date light-gray"><?php echo date('Y-m-d h:ia', $notification['created_at']); ?></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="activity-vertical-separator pull-left"></div>

                            <div class="chat-request pull-left">

                            </div>
                            <div class="pull-right">

                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <hr class="activity-horizontal-separator clearfix"/>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You have no notification.</p>
                <?php endif; ?>
            </div>

        </section>

    </div> <!-- end of middle -->

        <div class="latest-events date-ideas">
            <div class="section-title">
                <h3>Latest Date Ideas</h3>
                <p> Break the ice with an unforgotable first date!</p>
                <div class="clearfix"></div>
            </div>
            <div class="event-list">
                <div class="event">
                    <div class="image-holder">
                        <?php echo Asset::img("profile/date-idea.jpg"); ?>
                    </div>
                    <div class="event-caption-wrapper">
                        <a href="#"><i class="event-forward"></i></a>
                        <p class="event-caption-top">WHERE WE ALL MEET CANCUN</p>
                        <p class="event-caption-bottom">Thursday, Dec 11, 2014 - Thursday, Feb 05, 2015</p>
                    </div>
                </div>
                <div class="event">
                    <div class="image-holder">
                        <?php echo Asset::img("profile/date-idea.jpg"); ?>
                    </div>
                    <div class="event-caption-wrapper">
                        <a href="#"><i class="event-forward"></i></a>
                        <p class="event-caption-top">WHERE WE ALL MEET CANCUN</p>
                        <p class="event-caption-bottom">Thursday, Dec 11, 2014 - Thursday, Feb 05, 2015</p>
                    </div>
                </div>
                <div class="event">
                    <div class="image-holder">
                        <?php echo Asset::img("profile/date-idea.jpg"); ?>
                    </div>
                    <div class="event-caption-wrapper">
                        <a href="#"><i class="event-forward"></i></a>
                        <p class="event-caption-top">WHERE WE ALL MEET CANCUN</p>
                        <p class="event-caption-bottom">Thursday, Dec 11, 2014 - Thursday, Feb 05, 2015</p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="btn-holder"><a class="" href="#">More Date Idea's</a></div>
            </div>
            <div class="border-circle border-circle-2"><?php echo Asset::img('line_end.png'); ?></div>
            <div class="border-circle border-circle-3"><?php echo Asset::img('line_end.png'); ?></div>
        </div> <!-- end of latest ideas -->

        <div class="latest-events">
            <div class="section-title">
                <h3>Latest Events</h3>
                <p>Experience a night out with friends!</p>
                <div class="border-icon4"></div>
                <div class="clearfix"></div>
            </div>
            <?php if(isset($featured_events)): ?>
                <div class="event-list">
                    <?php foreach($featured_events as $featured_event): ?>
                        <div class="event">
                            <div class="image-holder">
                                <?php if(empty($featured_event['photo'])): ?>
                                    <img src="temp/event_thumb.jpg" />
                                <?php else: ?>
                                    <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_featured_'.$featured_event['photo'] ?>" />
                                <?php endif; ?>
                            </div>
                            <div class="event-caption-wrapper">
                                <a href="#"><i class="event-forward"></i></a>
                                <p class="event-caption-top"><?php echo $featured_event['title'] ?></p>
                                <p class="event-caption-bottom"><?php echo $featured_event['start_date'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                    <div class="btn-holder"><a class="" href="#">More Events</a></div>
                </div>
            <?php else: ?>
                <p class="nodata-message"> No Featured Event! </p>
            <?php endif; ?>
        </div> <!-- end of events -->

</div>




