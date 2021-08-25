<div id="notification-container" class="alert alert-success rounded-corners">
    <i class="close-dialog fa fa-times-circle-o close"></i>
    <h4></h4>
    <p></p>
</div>
<div id="advertizment-container">
    <?php echo Asset::img('temp/yoga_works.jpg', array('class' => '')); ?>
    <p><b>Upgrade</b> to never see ads again. <b>Remove</b></p>
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
    </aside>
    <div id="middle">
        <section id="latest-members"> 
		<div id="latest">
            <h2>Latest Members  <?php echo Html::anchor("/profile/quicksearch", "View all <i class='fa fa-angle-double-right'></i>", array("class" => "view-all")); ?></h2>
        </div>
		   <?php if ($latest_members): ?>
		   <?php if($current_profile->member_type_id == 3): ?>		     
		    <?php $alldisplaycounter = 0;?> 
                <div class="content clearfix">                                                 
                    <?php foreach ($latest_members as $memberdata): ?> 
                      <?php if ($memberdata['group_id'] != 5): ?>
                        <?php if (!Model_Profile::is_deleted_account($memberdata['id'])): ?>
                            <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                                <?php if ((!Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id']))) || (Model_Friendship::are_friends($current_profile->id, $memberdata['id'])) || (Model_Profile::is_free_member($memberdata['id']))): ?>
                                    <?php echo View::forge("profile/partials/dating_member_thumb", array("member" => $memberdata,'referd' => $referd,'subscribed' => $subscribed)); ?>
                                    <?php $alldisplaycounter++;?>
                                    <?php if($alldisplaycounter == 8): ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ((Model_Setting::is_set_privacy($memberdata['id']) && !Model_Profile::is_premium_member($memberdata['id']) && !Model_Profile::is_dating_agent($memberdata['id'])) || !Model_Setting::is_set_privacy($memberdata['id']) || (Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id'])) && Model_Friendship::are_friends($current_profile->id, $memberdata['id']))): ?>
                                    <?php echo View::forge("profile/partials/dating_member_thumb", array("member" => $memberdata,'referd' => $referd,'subscribed' => $subscribed)); ?>
                                    <?php $alldisplaycounter++;?>
                                    <?php if($alldisplaycounter == 8): ?>
                                      <?php break; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                      <?php endif; ?>           
                    <?php endforeach; ?>
                </div>                     
		    <?php else: ?>	   
             <?php $alldisplaycounter = 0;?> 
                <div class="content clearfix">
                <?php $counter1 = 0;?>                                                    
                    <?php foreach ($latest_members as $memberdata): ?> 
                      <?php if ($memberdata['group_id'] != 5): ?>
                        <?php if (!Model_Profile::is_deleted_account($memberdata['id'])): ?>
                            <?php if ($current_profile->member_type_id == 2 || $current_profile->member_type_id == 3): ?>
                                <?php if ((!Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id']))) || (Model_Friendship::are_friends($current_profile->id, $memberdata['id'])) || (Model_Profile::is_free_member($memberdata['id']))): ?>
                                    <?php echo View::forge("profile/partials/latest_member_thumb", array("member" => $memberdata,"counter" => $counter,"counter1"=>$counter1,"percentage"=>$percentage[$counter1],'referd' => $referd,'subscribed' => $subscribed)); ?>
                                    <?php $alldisplaycounter++;?>
                                    <?php if($alldisplaycounter == 8): ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ((Model_Setting::is_set_privacy($memberdata['id']) && !Model_Profile::is_premium_member($memberdata['id']) && !Model_Profile::is_dating_agent($memberdata['id'])) || !Model_Setting::is_set_privacy($memberdata['id']) || (Model_Setting::is_set_privacy($memberdata['id']) && (Model_Profile::is_premium_member($memberdata['id']) || Model_Profile::is_dating_agent($memberdata['id'])) && Model_Friendship::are_friends($current_profile->id, $memberdata['id']))): ?>
                                    <?php echo View::forge("profile/partials/latest_member_thumb", array("member" => $memberdata,"counter" => $counter,"counter1"=>$counter1,"percentage"=>$percentage[$counter1],'referd' => $referd,'subscribed' => $subscribed)); ?>
                                    <?php $alldisplaycounter++;?>
                                    <?php if($alldisplaycounter == 8): ?>
                                      <?php break; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                      <?php endif; ?> 
                      <?php $counter1++;?>            
                    <?php endforeach; ?>
                </div>                
             <?php endif; ?> 
            <?php endif; ?>
            <?php if(empty($latest_members[0]) || (count($latest_members) == 1 && $latest_members[0]['group_id'] == 5 )): ?>
                <p class="nodata-message">No Latest Members!</p>
            <?php endif; ?>
        </section>
        <section id="latest-friend-requests">
		    <div id="latest">
                <h2>Latest Friend Requests</h2>
             </div>
            <?php if ($pending_friends): ?>
            <div class="content clearfix">

                    <?php foreach ($pending_friends as $member): ?>
                        <?php echo View::forge("profile/partials/friend_request_thumb", array("member" => $member)); ?>
                    <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p class="nodata-message">No New Friend Requests!</p>
            <?php endif; ?>
        </section>
        <section id="events">
		    <div id="event-bg">
                <h2>Events</h2>
             </div>         
		    <?php if(isset($featured_events)): ?>

                <div id="event-list" class="clearfix">

                <?php foreach($featured_events as $featured_event){ ?>
                    <div class="event">
                        <?php
                        if(empty($featured_event['photo'])):
                            ?>
                            <img src="temp/event_thumb.jpg" />
                        <?php
                        else:
                            ?>
                            <img src="<?php echo \Fuel\Core\Uri::base().'uploads/events/event_featured_'.$featured_event['photo'] ?>" />
                        <?php
                        endif;
                        ?>
                        <div class="details">
                            <h3><?php echo $featured_event['title'] ?></h3>

                            <p class="date"><?php echo $featured_event['start_date'] ?></p>

                            <p class="text">
                                <?php
                                echo \Fuel\Core\Str::truncate($featured_event['long_description'], 30)
                                ?>
                            </p>

                            <p class="learn-more">
                                <?php echo Html::anchor('event/view/'.$featured_event['slug'], "Learn More"); ?>
                            </p>
                        </div>

                    </div>
                <?php } ?>
            </div>

            <?php else:?>
                <p class="nodata-message"> No Featured Event! </p>
            <?php endif; ?>

        </section>
    </div>
</div>




