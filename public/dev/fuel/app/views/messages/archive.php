<script type="text/javascript">

    function checkAll(checkId){
        var inputs = document.getElementsByTagName("input");
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == "checkbox" && inputs[i].id == checkId) {
                if(inputs[i].checked == true) {
                    inputs[i].checked = false ;
                } else if (inputs[i].checked == false ) {
                    inputs[i].checked = true ;
                }
            } 
        } 
    }

</script>
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			<div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), Model_Profile::get_username($current_profile->user_id), array("id" => "profile-link")); ?></div>
          <div id="profile-pic"><?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?></div>
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
        <form name=myform  method=post>
            <section id="event-detail-more">
               <div id="messages_header"> <h2 style="padding-bottom:10px;">Messages <a class="select">Select All</a> <a class="square" href="#"><input type="checkbox" id="chk_new"  name="CheckAll" onclick="checkAll('list');"></a> <a class="like"><?php echo Asset::img("message_count.png").'<span style="float:right; margin-left:20px; padding-bottom:20px; color:black; font-weight:bold;">'.$MessagecountInbox.'</span>'; ?> </a></h2> </div>
            
                <div class="sub-nav">
                    <ul>
                        <li><?php echo \Fuel\Core\Html::anchor('message/index', 'Inbox') ?>   </li>
                        <li><?php echo \Fuel\Core\Html::anchor('message/compose', 'Compose') ?></li>
                        <li><?php echo \Fuel\Core\Html::anchor('message/sent', 'Sent') ?></li>
                        <li><?php echo \Fuel\Core\Html::anchor('message/archive_total', 'Archive', array('class' => 'active-link')) ?></li>
                        <li><?php echo \Fuel\Core\Html::anchor('message/trash_total', 'Trash') ?></li>
                    </ul>
                 
                </div>
                <div class="event-list">
                    <div class="message-entry">
                        <?php if ($archive_sent_id OR $archive_inbox_id): ?>  
                            <?php foreach ($archive_sent_id as $sent): ?>
                                <?php $profile = Model_Profile::find($sent->to_member_id); ?>   
                                <span class="message-info"  style="margin-top:2px; padding-top:10px;" >
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/' . $sent->to_member_id), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium"))); ?>
                                    You sent Message To: 
                                    <?php echo Model_Profile::get_username($profile->user_id); ?>
                                    <?php echo $sent->date_sent; ?>
                                    <br>
                                    <span class="member-name">From <?php echo Model_Profile::get_username($current_profile->user_id); ?>: </span>
                                    <span class="message"><?php echo Str::truncate($sent->body, 20); ?>   
                                        <input type=checkbox id="list" name="list[]" value=<?php echo $sent->id; ?>  >
                                    </span>
                                    <p style="padding-left: 5px;"><?php echo Html::anchor("#", "read more...", array("class" => "sent-message-read-more", "data-message-id" => $sent->id, "data-dialog" => "message-dialog-$sent->id")); ?> </p> 
                                </span>
                                <div id=<?php echo "message-dialog-" . $sent->id; ?> class="dialog" style="width:660px;">
                                    <i class="close-dialog fa fa-times-circle-o"></i>
                                    <div class="message-entry">
                                        <span class="message-info"  style="margin-top:2px; padding-top:10px;" >
                                            <?php echo Html::anchor(Uri::create('profile/public_profile/' . $sent->to_member_id), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium"))); ?>
                                            You sent Message To: 
                                            <?php echo Model_Profile::get_username($profile->user_id); ?>
                                            <br>
                                            <?php echo $sent->date_sent; ?>
                                            <br><br>
                                            <span class="member-name">From <?php echo Model_Profile::get_username($current_profile->user_id); ?>: </span>
                                            <span class="message"><?php echo$sent->body; ?>   
                                            </span>

                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <br>
                            <?php foreach ($archive_inbox_id as $inbox): ?>
                                <?php $profile = Model_Profile::find($inbox->from_member_id); ?>   
                                <span class="message-info"  style="margin-top:2px; padding-top:10px;" >
                                    <?php echo Html::anchor(Uri::create('profile/public_profile/' . $inbox->from_member_id), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium"))); ?>

                                    <?php echo Model_Profile::get_username($profile->user_id); ?>  : sent you a message on
                                    <?php echo $inbox->date_sent; ?>
                                    <br>
                                    <span class="member-name"><?php echo Model_Profile::get_username($current_profile->user_id); ?>: </span>
                                    <span class="message"><?php echo Str::truncate($inbox->body, 20); ?>   
                                        <input type=checkbox id="list" name="list[]" value=<?php echo $inbox->id; ?>  >
                                    </span>
                                    <p><?php echo Html::anchor("#", "read more...", array("class" => "sent-message-read-more", "data-message-id" => $inbox->id, "data-dialog" => "message-dialog-$inbox->id")); ?> </p> 
                                </span>
                                <div id=<?php echo "message-dialog-" . $inbox->id; ?> class="dialog" style="width:660px;" >
                                    <i class="close-dialog fa fa-times-circle-o"></i>
                                    <div class="message-entry">
                                        <span class="message-info"  style="margin-top:2px; padding-top:10px;" >
                                            <?php echo Html::anchor(Uri::create('profile/public_profile/' . $inbox->from_member_id), Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium"))); ?>
                                            You sent Message To: 
                                            <?php echo Model_Profile::get_username($profile->user_id); ?>
                                            <br>
                                            <?php echo $inbox->date_sent; ?>
                                            <br><br>
                                            <span class="member-name">From <?php echo Model_Profile::get_username($current_profile->user_id); ?>: </span>
                                            <span class="message"><?php echo$inbox->body; ?>   
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?> 
                        <?php else: ?>
                            <p>No Messages.</p>
                        <?php endif; ?>

						</form>
                    </div>
                </div>
                <?php if ($archive_sent_id OR $archive_inbox_id): ?>
                    <div id="bottom-buttons" class="clearfix">
                        <input type="submit" name="submit" value="Recover Archived" id="submit2" onclick="form.action='recover_inbox';">
                        <input type="submit" id="submit" name="submit" value="Delete Selected" onclick="form.action='archive_deleted';">
                    </div>
                <?php endif; ?>
            </section>
        </form>
    </div>
    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_2_new.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3_new.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>

