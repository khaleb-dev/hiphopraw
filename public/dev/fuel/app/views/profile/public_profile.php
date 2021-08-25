<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>

<div class="header-row">
<div class="inner-wrapper">
        <div class="header-ad">
            <a href="#" data-direction="left"><?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?></a>
            <p class="ad-remove gray pull-right"><?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Upgrade",array('class' => 'white')); ?> to never see ads again. <?php echo Html::anchor(Uri::create("membership/upgrade", array(), array(), true), "Remove",array('class' => 'white')); ?></p>
            <div class="clearfix"></div>
        </div>
        </div>
</div>

<div class="main-container profile-row">
    <div class="inner-wrapper">
        <div class="profile-menu">
            <div class="profile-menu-inner">
                <div class="profile-avatar-wrapper">
                <div class="camera-image"></div>
                    <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                </div>
                <div class="member-date">
                    <p><span>Member Since:</span><?php echo date('M,Y', $profile->created_at) ?></p>
                </div>
                <div class="profile-sub-menu">
                    <?php if($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                        <?php echo Html::anchor("#", '<i class="send-msg"></i>Send Message', array("class" => "send-message-icon menu-btn", "data-confirmation-dialog" => "message-confirmation-dialog", "data-from-member-id" => $current_profile->id, "data-to-member-id" => $profile->id, "data-username" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list") )); ?>
                        <?php echo Html::anchor("#", '<i class="chat"></i>Chat With Me', array("class" => "send-chat-request menu-btn menu-btn-chat", "data-confirmation-dialog" => "chat-confirmation-dialog", "data-username" => Model_Profile::get_username($profile->user_id), "data-full-name" => Model_Profile::get_username($profile->user_id), "data-profile-picture" => Model_Profile::get_picture($profile->picture, $profile->user_id, "members_list"))); ?>
                    <?php else: ?>
                        <?php echo Html::anchor("#", '<i class="send-msg"></i>Send Message', array("id" => "send-message","class"=>"menu-btn","data-dialog" => "upgrade-message-dialog",)); ?>
                        <?php echo Html::anchor("#", '<i class="chat"></i>Chat With Me', array("id" => "send-chat","class"=>"menu-btn menu-btn-chat", "data-dialog" => "upgrade-chat-dialog")); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="border-icon1"></div>
            <div class="border-icon2"></div>
            <div class="border-circle border-circle-1"><?php echo Asset::img('line_end.png'); ?></div>
        </div>

        <div class="profile-top">
            <div class="profile-top-inner">
                <div class="pull-left">
                    <p class="profile-name" ><?php echo Html::anchor(Uri::create('profile/public_profile/'.$profile->id), ucfirst(Model_Profile::get_username($profile->user_id)), array("id" => "profile-link")); ?>
                        <span class="gray online-indicator"><i class="green-circle"></i><?php echo Model_Profile::get_username($profile->user_id); ?> is online</span>
                    </p>
                    <p class="profile-info-age" >
                        <?php echo ($profile->birth_date == null ? '' : Model_Profile::get_age($profile->birth_date).' Years Old, '). ($gender == null ? '' : $gender->name) ?>
                    </p>
                    <p class="profile-info-location" >
                        <?php  echo $profile->city == "" ? $profile->state : $profile->city . ", ". $profile->state; ?>
                    </p>
                </div>
                <div class="pull-right">
                    <p class="friend-status-display"><i class="friends"></i>You are Friends with this user<i class="down-arrow"></i></p>
                    <p class="friends-counter gray">You have <span class="yellow">(24) Mutual Friends</span></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="profile-more">
            <h3 class="title">A little more about myself</h3>
            <div class="text-wrapper">
                <p class="text"><?php echo $profile->about_me ?></p>
            <a class="read-more" href="#">Read More</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="profile-events">
            <h3 class="section-title">Events I Would Like To Attend</h3>
            <?php if(isset($featured_events)): ?>
                <div class="event-list">
                    <?php foreach($featured_events as $featured_event): ?>
                        <div class="event">
                            <div class="image-holder">
                                <div class="image-plus-sign"><?php echo Asset::img("event-plus.jpg"); ?></div>
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
                </div>
            <?php else: ?>
                <p class="nodata-message"> No Featured Event! </p>
            <?php endif; ?>

            <div class="border-circle border-circle-2"><?php echo Asset::img("line_end.png"); ?></div>
        </div>

        <div class="clearfix"></div>

        <div class="profile-activities">
            <div class="border-icon3"></div>
            <h3 class="section-title">Activities</h3>
            <div class="activities-inner">
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
                            <div class="activity-content pull-left">
                                <p>Nam mi enim, auctor non ultricies a, fringilla eu risus. Praesent vitae lorem et elit tincidunt accumsan suscipit eu libero. Nam mi enim, auctor non ultricies a, fringilla eu risus. Praesent vitae lorem et elit tincidunt accumsan suscipit eu libero.</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <hr class="activity-horizontal-separator clearfix"/>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You have no notification.</p>
                <?php endif; ?>
            </div>
        </div> <!-- end of activities -->

        <div class="clearfix"></div>

        <div class="profile-photos">
            <h3 class="section-title">Photos <?php echo Asset::img("profile/border-icon4.jpg"); ?></h3>
            <div class="photos-inner">
                <?php if ($latest_photos || $profile->picture != ""): ?>
                    <?php foreach ($latest_photos as $photo): ?>
                        <div class="photo">
                            <?php echo Html::anchor(Model_Profile::get_picture($photo['file_name'], $profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($photo['file_name'], $profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => $photo['description'] )); ?>
                            <div class="photo-caption">
                                <p title="<?php echo $photo['description']; ?>"><?php echo Str::truncate($photo['description'], 17 ) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="photo">
                        <?php echo Html::anchor(Model_Profile::get_picture($profile->picture, $profile->user_id, "slimbox"), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium")), array("rel" => "lightbox-photos", "title" => "Prfile Picture" )); ?>
                        <div class="photo-caption">
                            <p title="<?php echo "Profile Picture"; ?>"><?php echo "Profile Picture" ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="btn-holder"><a class="more-photo" href="#">More Photos</a></div>
                <?php else: ?>
                    <p class="nodata-message">No photos added yet!</p>
                <?php endif; ?>

            </div>
            <div class="border-circle border-circle-3"><?php echo Asset::img("line_end.png"); ?></div>
            <div class="border-circle border-circle-4"><?php echo Asset::img("line_end.png"); ?></div>
        </div> <!-- end of photos -->

    </div>
</div>


<?php if (!Model_Friendship::request_exchanged($current_profile->id, $profile->id) AND $current_profile->id != $profile->id):  ?>
    <div id="send-invite-dialog" class="public-profile-dialog dialog">
        <i class="close-dialog fa fa-times-circle-o"></i>
        <div class="dialog-header">
            <h2>Send Invite</h2>
        </div>
        <div class="dialog-content">
            <?php echo Form::open(array("id" => "send-invite-form", "action" => "friendship/request", "class" => "clearfix")) ?>
            <?php echo Form::hidden('sender_id', $current_profile->id); ?>
            <?php echo Form::hidden('receiver_id', $profile->id); ?>
            <?php echo Form::hidden('status', Model_Friendship::STATUS_SENT); ?>
            <div id="send-invite-content" class="clearfix">
                <p><span>Invite</span> <?php echo Model_Profile::get_username($profile->user_id) ?> to join your profile network</p>
                <p class="submit">
                    <input type="submit" name="#" value="Send Invite"/>
                </p>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
<?php endif; ?>

<div id="refer-to-friend-dialog" class="public-profile-dialog dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Refer to Friends</h2>
    </div>
    <div class="dialog-content">
  
            <?php echo Form::open(array("id" => "", "action" => "profile/refer_friends", "class" => "clearfix")) ?>
            <?php echo Form::hidden('refer_from', $current_profile->id); ?>
			  <?php echo Form::hidden('refered_id',$profile->id); ?>                                                         
            <div id="refer-to-friend-content" class="clearfix">
			
                <p>Refer to a Friends <select name= "referOption" ><span> <option></option><?php foreach($friends as $friend): ?>
				      <?php if($friend->id!=$profile->id): ?>        
				<option  value=<?php echo $friend->id; ?> ><?php echo Model_Profile::get_username($friend->user_id); ?></option>  <?php endif; ?><?php endforeach; ?></span></select></p>
			          
                <p class="submit">
                    <input type="submit" name="#" value="Refer to Friends"/>
                </p>
            </div>
            <?php echo Form::close(); ?>
       
    </div>
</div>

<div id="report-me-dialog" class="dialog">
    <i class="close-dialog fa fa-times-circle-o"></i>
    <div class="dialog-header">
        <h2>Report Me To Administrator</h2>
    </div>
    <div class="dialog-content">
        <?php echo Form::open(array("id" => "report-me-form", "action" => "agent/report_me", "class" => "clearfix")) ?>
        <?php echo Form::hidden('dating_agent_id', $profile->id); ?>
        <p class="clearfix">
            <label>Message:</label>
            <textarea name="message"></textarea><br/>
        </p>
        <p class="submit">
            <input type="submit" name="#" value="Send"/>
        </p>
        <?php echo Form::close(); ?>

    </div>
</div>















