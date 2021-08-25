<div id="center" class="clearfix">
	<div id="sidebar-left">
		<?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

		<?php echo View::forge("pages/partials/enter_your_videoke"); ?>		
	</div>
	<div id="content" class="videos with-sidebar-left profile">
		<div id="messages">
			<h2 class="clearfix"><span>Messages</span> <p><?php echo Html::anchor(Router::get("home"), "Delete Conversation", array("class" => "button rounded-corners")); ?> <?php echo Html::anchor(Router::get("my_messages"), "Back", array("class" => "button rounded-corners")); ?> </p></h2>
			<div class="content-box">
				<ul id="messages-nav"  class=" clearfix <?php echo isset($active_message_link) ? $active_message_link : ''; ?>" >
					<li id="inbox" class="first"><?php echo Html::anchor(Router::get("home"), "Inbox"); ?></li>
					<li id="sent"><?php echo Html::anchor(Router::get("home"), "Sent"); ?></li>
					<li id="drafts"><?php echo Html::anchor(Router::get("home"), "Drafts"); ?></li>
					<li id="trash"><?php echo Html::anchor(Router::get("home"), "Trash"); ?></li>	
				</ul>
				<div class="message clearfix">
					<div class="sender-info">
						<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "sender-thumb")); ?>
						<span>Ibram Adly</span>
					</div>
					<div class="message-detail">
						<p class="sender">Ibram Adly sent you a message, Dec. 1, 2012 at 3:27 p.m.</p>
						<div class="conversation">
							<p class="detail">
								<span class="user-control-icon message-icon">&nbsp;</span> <span class="sender">Ibram Adly</span>  Hey! How are you?
							</p>
							<p class="detail">
								<span class="user-control-icon message-icon">&nbsp;</span> <span class="reciever">You</span>  I'm great! How are you doing?
							</p>
						</div>						
					</div>
				</div>
				<p class="back"><?php echo Html::anchor(Router::get("my_messages"), "&laquo;  Back"); ?></p>
			</div>
		</div>
	</div>
</div>