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
<script type="text/javascript"> 
function confirmDelete() { 
 return confirm("Are you sure you want to delete?");   
} 
</script> 
<div id="content" class="clearfix">
    <aside id="left-sidebar">
        <div id="profile-summary">
            <div class="content">
			<div id="profile_name"><?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?></div>
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
        <div class="content clearfix">
            <section id="my-hellos">

                <div id="settingall">
				    <div id="setting"><h2>My Settings</h2></div>
                    <div id="subsettingall">
                        <div id="account">Account</div>
                        <div style="border-bottom:1px solid rgb(224, 224, 224); margin-left:2%; margin-buttom:20px; margin-right:20px;"></div>
                         <form  action="delete_account" method="post" style="margin-top:5%; margin-left:3%; " onsubmit="return confirmDelete();">
                           
                             <?php foreach ($getemailaddress as $email): ?>
                                 <?php endforeach; ?>
                         
                          
                            <p style= "margin-left:8%;">Email:&nbsp;&nbsp;&nbsp; <input type="text" name="email" value=<?php echo $email->email; ?> style="width:88%; height:28px;"></p>
                            <p style= "margin-left:4%;">Password:&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="paswword" style="width:85%; height:28px;"></p>
                            <p style=" margin-top:10px;">&nbsp;&nbsp;Membership:&nbsp;&nbsp;<input type="submit" id="deletelink" value="Delete Your Account"> </p>
                        </form>
                        <div id="privacy">Privacy</div>
						 <form action="compose" method="post" ">     
                        <div style="border-bottom:1px solid rgb(224, 224, 224); margin-left:2%; margin-buttom:20px; margin-right:20px;"></div>
                           <div id="blockprofile">Blocked Profiles:&nbsp;&nbsp;&nbsp; 0- <a id="deletelink">&nbsp;&nbsp;<?php echo Html::anchor("#", "View Blocked Profile", array("id" => "upload-photo", "data-dialog" => "message_dialog")) ?> </a></div>
						   
						     <div id=<?php echo "message_dialog" ?> class="dialog" style="width:660px; " >
                                    <i class="close-dialog fa fa-times-circle-o" ></i>
                                    <div class="message-entry" style="margin-top: 20px;" >
                                        <span class="message-info"  >
									   <div id="submain">
									   <?php if($profiles): ?>
                                       <?php foreach($profiles as $profile): ?>
									    <span><?php echo Html::img(Model_Profile::get_picture($profile->picture, $profile->user_id, "members_medium")); ?></span>
                                          										    
											<div id="name">  
				                        <?php echo $profile->first_name; ?>&nbsp;
					                     <?php echo $profile->last_name; ?>
				                             <br>
						                       <br>
							                      <br>
		                                    </div>
											    <br>
												<br>
									     <?php endforeach; ?>
                                    <?php else: ?>
                              <p>&nbsp; No Blocked profile</p>
                                <?php endif; ?>
									
                                            <br><br>
                                                 </div>											
                                            </span>

                                        </span>
                                    </div>
                                </div>
						   
						   
						  
						   
                            <div id="privateprofile">private Profile:&nbsp;&nbsp;
							 <?php foreach($savedsetting as $saved): ?>
							 
							<input type="checkbox" value=1 <?php if($saved->private_profile): ?> checked="checked" <?php endif; ?> name="list">&nbsp;&nbsp;<a id="prevent"> Prevent my profile from showing up in search results</a><br></div>
                              
							  <?php endforeach; ?>
							
						   <br>
							
                            <div id="datasharing">Data sharing:&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value=1 <?php if($saved->data_sharing): ?> checked="checked" <?php endif; ?> name="list1">&nbsp;&nbsp;<a id="prevent"> Do not share data with third parties</a><br><br></div>
                            <div style= "margin-left:5%;">Where we all&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value=1 <?php if($saved->where_we_all_meet): ?> checked="checked" <?php endif; ?> name="list2">&nbsp;&nbsp;<a id="prevent"> Do not share data with third parties</a><br>meet C's:</div>
                     
                        <div id="preferences">Preferences</div>
                        <div style="border-bottom:1px solid rgb(224, 224, 224); margin-left:2%; margin-buttom:20px; margin-right:20px;"></div>
                      
                            <div id="hellonotfication">Hello Notification:&nbsp;&nbsp;&nbsp;<select id="hellosetting" name="hellosetting">
							 <?php foreach($savedsetting as $saved): ?>
							 <?php if($saved->hello_notification=='Once a Day'):  ?>
							<option>
							  <?php echo $saved->hello_notification;  ?>
							</option>
							  <option>
							    Every Hello
							  </option>
							   <?php else: ?>
							   <option>
							 
							 Every Hello
							</option>
							
							  <option>
							    Once a Day
							  </option>
							  <?php endif; ?>
							  <?php endforeach; ?>
							</select> </a></div>
                            <div id="messagenotfication">Messages Notification:&nbsp;&nbsp;&nbsp;<select id="messagesetting" name="messagesetting">
							 <?php foreach($savedsetting as $saved): ?>
							 <?php if($saved->message_notification=='Every Message'):  ?>
							<option>
							 <?php echo $saved->message_notification;  ?>
							</option>
							<option>Limited Messages</option>
							<option>Once a Day</option>
							<?php elseif($saved->message_notification=='Limited Messages'): ?>
							  <option>
							   Limited Messages
							  </option>
							  <option>
							  Every Message
							  </option>
							  <option>
							  Once a Day
							   </option>
							   <?php else: ?>
							    <option>
								 Once a Day 
								</option>
								<option>
								 Every Message
								</option>
								<option>
								  Limited Messages
								</option>
								<?php endif; ?>
							<?php endforeach; ?>
							</select> </a></div>
                            <div id="topmatch">Top matches:&nbsp;&nbsp;&nbsp;<select id="perweek" name="perweek">
							<?php foreach($savedsetting as $saved): ?>
							 <?php if($saved->top_matches=='Three per week'):  ?>
							<option>Three per week</option>
							<option>Every Day</option>
							<option>Three notifications per week</option>
							<option>Notifications of top matches once per</option>
							<?php elseif($saved->top_matches=='Every Day'):?>
							<option>Every Day</option>
							<option>Three per week</option>
							<option>Three notifications per week</option>
							<option>Notifications of top matches once per</option>
							<?php elseif($saved->top_matches=='Three notifications '):?>
							<option>Three notifications per week</option>
							<option>Every Day</option>
							<option>Three per week</option>
							<option>Notifications of top matches once per</option>
							<?php else:?>
							<option>Notifications of top matches once per</option>
							<option>Every Day</option>
							<option>Three per week</option>
							<option>Three notifications per week</option>
							<?php endif; ?>
							<?php endforeach; ?>
week</option></select> </a></div>
                            <div id="special">Special Offers:&nbsp;&nbsp;<select id="subscribe" name="subscribe">
							<?php foreach($savedsetting as $saved): ?>
							 <?php if($saved->special_offers=='Subscribe'):  ?>
							<option>Subscribe</option>
							<option>Unsubscribe</option>
							<?php else: ?>
							<option>Unsubscribe</option>
							<option>Subscribe</option>
							<?php endif; ?>
							<?php endforeach; ?>
							</select> </a></div>
                            <div style= "margin-left:12%;margin-top:2%;">Send me email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value=1 <?php if($saved->send_me_email_notifcation): ?> checked="checked" <?php endif; ?> name="list3">&nbsp;&nbsp;<a id="prevent"> Do not share data with third parties</a><br>Notifications:</div>
                     
                        <div style="border-bottom:1px solid rgb(224, 224, 224); margin-left:2%; margin-buttom:20px; margin-right:20px;"></div>
                       
                            <input type="submit" id="submit" name="submit" value="Update" onclick="form.action='updating_setting';">
                          
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <aside id="right-sidebar">
        <?php echo View::forge("profile/partials/friends_online", array("online_members" => $online_members,'referd' => $referd,'subscribed' => $subscribed)); ?>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>

