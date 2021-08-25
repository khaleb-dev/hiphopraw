<div id="center" class="clearfix">
	<div id="sidebar-left">
		<?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

		<?php echo View::forge("pages/partials/enter_your_videoke"); ?>

	</div>
	<div id="content" class="with-sidebar-left profile">
		<div id="comments">
			<div class="content-box">
				<h3>Showing All Comments(3)</h3>
				<p id="sign-in">
					<?php echo Html::anchor(Router::get("home"), "Sign in"); ?> now to post a comment!
				</p>
				<div class="comment clearfix">
					<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "commenter-thumb")); ?>
					<div class="comment-detail">
						<p class="commenter"><strong>Ibram Adly</strong> <em>3 mintues ago</em></p>
						<h4>4 Min Best FAILS/WINS December 2012!</h4>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="reply"> 
							<?php echo Html::anchor(Router::get("home"), "Reply"); ?> &middot;
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_like_icon.png")); ?>
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_dislike_icon.png")); ?>
						</p>
					</div>
				</div>
				<div class="comment clearfix">
					<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "commenter-thumb")); ?>
					<div class="comment-detail">
						<p class="commenter"><strong>Ibram Adly</strong> <em>3 mintues ago</em></p>
						<h4>4 Min Best FAILS/WINS December 2012!</h4>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="reply"> 
							<?php echo Html::anchor(Router::get("home"), "Reply"); ?> &middot;
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_like_icon.png")); ?>
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_dislike_icon.png")); ?>
						</p>
					</div>
				</div>
				<div class="comment clearfix">
					<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "commenter-thumb")); ?>
					<div class="comment-detail">
						<p class="commenter"><strong>Ibram Adly</strong> <em>3 mintues ago</em></p>
						<h4>4 Min Best FAILS/WINS December 2012!</h4>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="reply"> 
							<?php echo Html::anchor(Router::get("home"), "Reply"); ?> &middot;
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_like_icon.png")); ?>
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_dislike_icon.png")); ?>
						</p>
					</div>
				</div>
				<div class="comment clearfix">
					<?php echo Html::anchor(Router::get("home"), Asset::img("commenter_thumbs/thumb_1.jpg"), array("class" => "commenter-thumb")); ?>
					<div class="comment-detail">
						<p class="commenter"><strong>Ibram Adly</strong> <em>3 mintues ago</em></p>
						<h4>4 Min Best FAILS/WINS December 2012!</h4>
						<p class="detail">Please Watch and Like and make other smile too:) /watch?v=DSs1jtwlrSM</p>
						<p class="reply"> 
							<?php echo Html::anchor(Router::get("home"), "Reply"); ?> &middot;
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_like_icon.png")); ?>
							<?php echo Html::anchor(Router::get("home"), Asset::img("icons/grey_dislike_icon.png")); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>