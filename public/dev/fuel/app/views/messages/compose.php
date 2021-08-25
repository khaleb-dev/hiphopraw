<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
				<div id="profile_name"> <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
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
  <form action="compose" method="post">
        <section id="event-detail-more">
           <div id="messages_header"> <h2 style="padding-bottom:10px;">Messages</h2></div>
            <div class="sub-nav">
                <ul>
                    <li><?php echo \Fuel\Core\Html::anchor('message', 'Inbox') ?> </li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/compose', 'Compose', array('class' => 'active-link')) ?></li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/sent', 'Sent') ?></li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/archive_total', 'Archive') ?></li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/trash_total', 'Trah') ?></li>
                </ul>
                <div class="controls">
                    <a class="square" href="#"><input type="checkbox" name="list" onclick="checkmail('list');"></a> |
                    <a class="arrow" href="#"><span>To Email </span> 	</a>
                </div>
            </div>
            <div class="event-list">
              
                    <input type="hidden" name="from_member_id" value="">
                    <select name="to_member_id"  onchange="document.getElementById('to_member_id').value=this.options[this.selectedIndex].text; document.getElementById('idValue').value=this.options[this.selectedIndex].value;" >
                                              
					   <option > </option>
                        
						<?php if($current_profile->id==$profileid[0]['id'] AND $membertypeid[0]['member_type_id']!=3 ):   ?>
						<option > All </option>
				      <?php foreach ($friendship as $friend): ?>
                            <?php if ($friend->sender_id == $resultsprofile[0]['id']): ?>
                                <?php if ($friend->status == 'accepted'): ?>
                                    <option>
                                        <?php foreach ($users as $user): ?>
                                            <?php foreach ($profiles as $profile): ?>
											   <?php if ($friend->receiver_id == $profile->id): ?>   
                                                    <?php if ($user->id == $profile->user_id): ?>                
                                                        <?php echo $user->username; ?>  
                                                   <?php endif; ?>
											  <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </option>
                                <?php endif; ?>
                            <?php elseif ($friend->receiver_id == $resultsprofile[0]['id']): ?>
                                <?php if ($friend->status == 'accepted'): ?>
                                    <option>
                                        <?php foreach ($users as $user): ?>
                                            <?php foreach ($profiles as $profile): ?>
											    <?php if ($friend->sender_id == $profile->id): ?>   
                                                    <?php if ($user->id == $profile->user_id): ?>                      
                                                        <?php echo $user->username; ?>  
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </option>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
						  <?php else: ?>
						   <option style="font-weight:bold">All Clients</option>
						 
						    <?php foreach($profiles as $profile): ?> 
							<?php if($current_profile->id!=$profile->id): ?>
						   <option>
						
		                   <?php echo Model_Profile::get_username($profile->user_id)."<br>"; ?>
						 
			     	   </option>
					     <?php endif; ?>
					     <?php endforeach; ?>
						<?php endif; ?>
						   
					        </select>
                    <div id='username_availability_result'></div>
                    <input type="text" name="subject" placeholder=" Subject:">
                    <textarea name="body" placeholder=" Your messaage will be typed here..."></textarea>
                    <button type="submit" id="check_username_availability" >Send</button>
              
            </div>
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
<?php echo Asset::js('jquery.js'); ?>
