<nav id="profile-nav">
   <div id="online-status-container">
       <?php echo Asset::img("online_dot.png"); ?>
       <?php echo $current_user->username . " is Online"; ?>
   </div>
   <div id="menu-header-text">
		<p>My Settings</p>
   </div>
    <?php echo Html::anchor(Uri::create(''), '<i class="my_account"> </i>Account'); ?>
    <?php echo Html::anchor(Uri::create(''), '<i class="my_notification"></i> Notifications'); ?>
	
	<div id="menu-header-text">
		<p>My Profile</p>
   </div>
	
	<?php echo Html::anchor(Uri::create(''), '<i class="my_profile"></i>Edit Profile'); ?>
	<?php echo Html::anchor(Uri::create(""), '<i class="my_bio"></i>Edit Bio'); ?>
    <?php echo Html::anchor(Uri::create(""), '<i class="my_photo"></i>Edit Photos'); ?>
</nav>
<div id="invite-friend-container">
    <p>INVITE A FRIEND</p>
    <p>To Join For Free</p>
    <a>INVITE NOW</a>
</div>