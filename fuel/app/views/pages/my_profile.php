<div id="center" class="clearfix">
	<div id="sidebar-left">
		<?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

		<?php echo View::forge("pages/partials/enter_your_videoke"); ?>

	</div>
	<div id="content" class="with-sidebar-left profile">
		<div class="content-box">
			<h3>All Videos(4)</h3>
			<div class="items videos">
				<?php for($i=1; $i < 5; $i++){ ?>
					<div class="item <?php echo $i%4 == 0 ? "last" : ""; ?>">
						<?php echo Asset::img("videos/video_". $i .".jpg"); ?>
						<h3>Video Title</h3>
						<p class="views">Views(1000) By: Username</p>
					</div>
				<?php } ?>
				<p class="more"><?php echo Html::anchor(Router::get("home"), "More Videos"); ?></p>
			</div>
		</div>
		<div id="comments">
			<h2><span>Comments</span></h2>
			<div class="content-box">
				<h3>All Comments(1)</h3>
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
			</div>
		</div>
		<div id="friends">
			<h2><span>Top Friends</span></h2>
			<div class="items members clearfix">
				<?php for($i=1; $i < 6; $i++){ ?>
					<div class="item content-box <?php echo $i%5 == 0 ? "last" : ""; ?>">
						<?php echo Asset::img("members/member_". $i .".jpg", array("width" => "107", "height" => "91")); ?>
						<h3>Member Name</h3>
					</div>
				<?php } ?>
			</div>
			<p class="more">
				<?php echo Html::anchor(Router::get("home"), "All Friends &raquo;"); ?>
			</p>
		</div>
	</div>
</div>