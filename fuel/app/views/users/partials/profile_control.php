<div id="profile-control" class="sidebar-content profile-control content-box">
	<h3>Building <?php echo $user->username; ?>'s Profile</h3>
	<div class="content">
		<?php echo Html::img(Model_User::get_picture($user, "profile")); ?>
	</div>	
</div>

<?php echo View::forge("users/partials/build_profile_nav"); ?>
