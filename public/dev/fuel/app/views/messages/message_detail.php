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
                <?php echo Html::anchor(Uri::create('profile/public_profile'), Html::img(Model_Profile::get_picture($current_profile->picture, $current_profile->user_id, "profile_medium"))); ?>
                <?php echo Html::anchor(Uri::create('profile/public_profile'), $current_user->username, array("id" => "profile-link")); ?>
            </div>
        </div>

        <?php echo View::forge("profile/partials/profile_nav"); ?>
        <?php echo View::forge("membership/partials/upgrade_your_account"); ?>
    </aside>
    <div id="middle">
<form name=myform  method=post>
        <section id="event-detail-more">
            <h2>Messages</h2>
            <div class="sub-nav">
                <ul>
                    <li><?php echo \Fuel\Core\Html::anchor('message/index', 'Inbox')?></li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/compose', 'Compose')?></li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/sent', 'Sent')?></li>
                    <li><?php echo \Fuel\Core\Html::anchor('message/archive_total', 'Archive')?></li>
                     <li><?php echo \Fuel\Core\Html::anchor('message/trash_total', 'Trash')?></li>
                </ul>
				<div id="message_dialog" class="dialog" >
    
    <i class="close-dialog fa fa-times-circle-o"></i>
	 <form name=myform  method=post>
	 <div class="event-list">
                <div class="message-entry">
                   
					 
                     
                    <?php if ($messages): ?>  
                      	   
                      <?php foreach ($messages as $message): ?>
					    <?php if($selectedinbox): ?>
					    
					 <?php if($message->from_member_id==$selectedinbox[0]['from_member_id']): ?>
					  <?php if($message->is_deleted_sender==0): ?>
                   		<?php if($message->archive_sent==0): ?>
						
					         <?php echo \Fuel\Core\Asset::img(array('temp/member_thumb.jpg'));?>
							 <p style="padding-top:40px;">
				     <span class="message-info" >
					
					you sent Message To: <?php echo $message->to_member_id; ?>   <?php echo $message->date_sent; ?>
					</span>
                    <br>
                    <span class="member-name">From <?php echo $message->from_member_id; ?>: </span>
                    <span class="message"><?php echo $message->body; ?> <input type=checkbox name='list[]' value=<?php echo $message->id; ?>  >
				          
                   </span>
				   </p>
					<?php endif; ?>
					<?php endif; ?>
					<?php endif; ?>
					<?php endif; ?>
					  
					<?php endforeach; ?>
				
                  
                   <?php else: ?>
				 
                       <p>No Messages.</p>
                       <?php endif; ?>
					 
					 	
						 
						  
					  
					<div class="dialog-footer clearfix">   
        
        <p style="margin-left:370px; margin-top:40px; padding-bottom:10px; "> <input type="submit" name="submit" value="Archive Selected" onclick="form.action='archive_inbox';">
					    <input type="submit" name="submit" value="Delete Selected" onclick="form.action='index';"></p>
					 	 </form>
					  
		
                </div>

					 
                </div>
				</div>
	
</form>
    
</div>

				

            
        </section>
 </form>
    </div>


    <aside id="right-sidebar">
        <?php //echo View::forge("profile/partials/friends_online"); ?>

        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('event') ?>"><?php echo Asset::img("temp/dating_agent_ad_2.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('package') ?>"><?php echo Asset::img("temp/dating_agent_ad_3.jpg"); ?></a>
        </div>
        <div class="ad">
            <a href="<?php echo \Fuel\Core\Uri::create('agent') ?>"><?php echo Asset::img("temp/dating_agent_ad.jpg"); ?></a>
        </div>
    </aside>
</div>

