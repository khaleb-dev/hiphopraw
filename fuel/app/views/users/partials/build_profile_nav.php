<div id="build-profile-nav" <?php echo isset($active_link) ? 'class="' . $active_link . '"' : ''; ?>>

	<div id="build-profile-link" class="content-box clearfix">
		<?php echo Html::anchor(Router::get("build_profile"), "<span class='build-profile user-setting-icon'>&nbsp;</span> <span class='text'>Build Your Profile</span>"); ?>
	</div>

	<div id="upload-videoke-link" class="content-box clearfix">
		<?php echo Html::anchor(Router::get("upload_videoke"), "<span class='build-profile upload-videoke-icon'>&nbsp;</span> <span class='text'>Upload Your Video</span>"); ?>
	</div>

	<div id="invite-friend-link" class="content-box clearfix">
		<?php echo Html::anchor(Router::get("invite"), "<span class='build-profile invite-friend-icon'>&nbsp;</span> <span class='text'>Invite Your Friends</span>"); ?>
	</div>

</div>