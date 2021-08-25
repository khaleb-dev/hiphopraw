<div id="center" class="clearfix">
	<div id="sidebar-left">
		<?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

		<?php echo View::forge("pages/partials/enter_your_videoke"); ?>
			
	</div>
	<div id="content" class="videos with-sidebar-left profile">
		<div id="messages">
			<h2 class="clearfix"><span>Messages</span> <p>Total Messages (23) <?php echo Html::anchor(Router::get("home"), "Delete Selected", array("class" => "button rounded-corners")); ?> </p></h2>
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
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="view-more"> 
							<?php echo Html::anchor(Router::get("my_message"), "View Conversation"); ?>
							<input type="checkbox" />
						</p>
					</div>
				</div>
				<div class="message clearfix">
					<div class="sender-info">
						<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "sender-thumb")); ?>
						<span>Ibram Adly</span>
					</div>
					<div class="message-detail">
						<p class="sender">Ibram Adly sent you a message, Dec. 1, 2012 at 3:27 p.m.</p>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="view-more"> 
							<?php echo Html::anchor(Router::get("my_message"), "View Conversation"); ?>
							<input type="checkbox" />
						</p>
					</div>
				</div>
				<div class="message clearfix">
					<div class="sender-info">
						<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "sender-thumb")); ?>
						<span>Ibram Adly</span>
					</div>
					<div class="message-detail">
						<p class="sender">Ibram Adly sent you a message, Dec. 1, 2012 at 3:27 p.m.</p>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="view-more"> 
							<?php echo Html::anchor(Router::get("my_message"), "View Conversation"); ?>
							<input type="checkbox" />
						</p>
					</div>
				</div>
				<div class="message clearfix">
					<div class="sender-info">
						<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "sender-thumb")); ?>
						<span>Ibram Adly</span>
					</div>
					<div class="message-detail">
						<p class="sender">Ibram Adly sent you a message, Dec. 1, 2012 at 3:27 p.m.</p>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="view-more"> 
							<?php echo Html::anchor(Router::get("my_message"), "View Conversation"); ?>
							<input type="checkbox" />
						</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>