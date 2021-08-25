<div id="center" class="clearfix">
	<div id="sidebar-left">
		<?php echo View::forge("users/partials/profile_alt_control", array("user" => $current_user)); ?>

		<?php echo View::forge("pages/partials/enter_your_videoke"); ?>
				
	</div>
	<div id="content" class="videos with-sidebar-left profile">
		<div class="content-box">
			<h3 class="clearfix">Showing All Videos(12) <?php echo Html::anchor(Router::get("home"), "Manage", array("class" => "button rounded-corners")); ?></h3>
			<div class="items videos">
				<?php for($i=1; $i < 13; $i++){ ?>
					<div class="item <?php echo $i%4 == 0 ? "last" : ""; ?>">
						<?php echo Asset::img("videos/video_". $i .".jpg"); ?>
						<h3>Video Title</h3>
						<p class="views">Views(1000) By: Username</p>
					</div>
				<?php } ?>
				<p class="more"><?php echo Html::anchor(Router::get("profile"), "Back"); ?></p>
			</div>
		</div>
	</div>
</div>