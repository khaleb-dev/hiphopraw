<nav id="profile-nav">
   <div id="online-status-container">
       <?php echo Asset::img("online_dot.png"); ?>
       <?php echo $current_user->username . " is Online"; ?>
   </div>
    <?php echo Html::anchor(Uri::create('profile/my_friends'), '<i class="my_friends"> </i>My Friends (' . count($countFriend) . ')'); ?>
    <?php echo Html::anchor(Uri::create('profile/my_photos'), '<i class="my_photos"></i> My Photos (' . $countImage . ')'); ?>
	<?php echo Html::anchor(Uri::create('event/my_events'), '<i class="my_events"></i>My Events (' . $countEvent . ')'); ?>
	<?php echo Html::anchor(Uri::create(""), '<i class="my_invitation"></i> My Invitations'); ?>
    <?php echo Html::anchor(Uri::create(""), '<i class="my_date"></i> My Dates'); ?>
</nav>
<div id="invite-friend-container">
    <p>INVITE A FRIEND</p>
    <p>To Join For Free</p>
    <a>INVITE NOW</a>
</div>