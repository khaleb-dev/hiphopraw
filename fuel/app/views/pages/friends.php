<div id="center" class="clearfix">
	<div id="sidebar-left">
		<div class="sidebar-content profile-control content-box">
			<h3>User_Name Profile</h3>
			<div class="content">
				<?php echo Asset::img("profile_pic.jpg"); ?>
				<p class="location"><strong>Las Vegas, NV</strong></p>
				<p class="member-since">Member Since: 12/7/2013</p>
				<p><strong>Cateogry: Singer</strong></p>
				<p><strong>3 Videos</strong> &middot; <span>(Contest Winner)</span></p>
				<div class="buttons">
					<?php echo Html::anchor(Router::get("home"), "Add as Friend", array("class" => "button grey add")); ?>
					<?php echo Html::anchor(Router::get("home"), "Send Message", array("class" => "button grey send-message")); ?>
				</div>
				<h4>About Me</h4>
				<p>
					Lorem ipsum dolor sit amet, consec tetuer adipiscing elit. 
					Aenean comm odo ligula eget dolor. Aenean massa. Cum sociis 
					natoque.
				</p>
				<p class="more"><?php echo Html::anchor(Router::get("home"), "Read More"); ?></p>
			</div>
		</div>		
	</div>
	<div id="content" class="with-sidebar-left profile">
		<div id="friends" class="content-box clearfix">
			<h3 class="clearfix">
				<p>Showing All Friends (15)</p>
				<p class="pager">
					<span>Search Name:</span> 
		            <?php for ($i = 65; $i <= 90; $i++){ ?>
		                <?php $letter = chr($i); ?>
		                <?php echo Html::anchor(Router::get("home"), $letter); ?> 
		                <?php echo $i < 90 ? "|" : "" ; ?>
		            <?php } ?>
				</p>
			</h3>
			<div class="items friends clearfix">
				<?php for($i=1; $i < 16; $i++){ ?>
					<div class="item <?php echo $i%5 == 0 ? "last" : ""; ?>">
						<?php echo Asset::img("members/member_". $i .".jpg", array("width" => "111", "height" => "99")); ?>
						<h3>Member Name</h3>
					</div>
				<?php } ?>
			</div>
			<p class="back"><?php echo Html::anchor(Router::get("profile"), "Back"); ?></p>
			<p class="more"><?php echo Html::anchor(Router::get("profile"), "Next"); ?></p>
			<div class="clear">&nbsp</div>
		</div>
	</div>
</div>