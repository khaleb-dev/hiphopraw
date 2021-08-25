<div id="profile-control" class="sidebar-content profile-control content-box">
	<div class="content">
		<div class="profile-control-inner">
		<?php echo  Html::anchor("users/home_login/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile")), array("id" => "admin-profile-picture")); ?>
		<h3><?php echo $current_user->username; ?>'s <span class="white">- Role</span></h3>
		</div>
		<div class="profile-control-divider"></div>
		<div class="profile-control-bottom">
		<ul id="admin-profile-links" <?php echo isset($active_link) ? 'class="' . $active_link . '"' : ''; ?> >
			<hr>
			<li id="friends-link"><?php echo Html::anchor("admin", "<i class='icon-group'></i> <span class='". ($menu == 'Users' ? 'side-menu-item' : '') ."'>Users</span>"); ?></li>
			<li id="friends-link"><?php echo Html::anchor("admin/videokes", "<i class='icon-play-circle'></i> <span class='". ($menu == 'Videokes' ? 'side-menu-item' : '') ."'>Videos"); ?></li>
                        <li id="friends-link"><?php echo Html::anchor("admin/contests", "<i class='icon-star'></i> <span class='". ($menu == 'Contests' ? 'side-menu-item' : '') ."'>Contests</span>"); ?></li>
			<li id="friends-link"><?php echo Html::anchor("admin/sponsors", "<i class='icon-leaf'></i> <span class='". ($menu == 'Sponsors' ? 'side-menu-item' : '') ."'>Sponsors</span>"); ?></li>
                        <li id="friends-link"><?php echo Html::anchor("admin/bannerAds", "<i class='icon-desktop'></i> <span class='". ($menu == 'Banner Ads' ? 'side-menu-item' : '') ."'>Banner Ads</span>"); ?></li>
		</ul>
		</div>
	</div>
</div>
