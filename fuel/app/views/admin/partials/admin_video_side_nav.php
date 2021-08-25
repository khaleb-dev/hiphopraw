<div id="profile-control" class="sidebar-content profile-control content-box">
	<div class="content">
		<div class="admin-profile-div">
			<?php echo  Html::anchor("users/home_login/" . $current_user->id, Html::img(Model_User::get_picture($current_user, "profile")), array("id" => "admin-profile-picture")); ?>
			<h3 style="border:none;text-align:center">Admin - <span class="white-txt">HHR Administrator</span></h3>
		</div>
		<ul id="admin-profile-links" <?php echo isset($active_link) ? 'class="' . $active_link . '"' : ''; ?> >
			<hr>
			<li id="friends-link"><?php echo Html::anchor("admin", "<i class='icon-group'></i> <span class='". ($menu == 'Users' ? 'side-menu-item' : '') ."'>Users</span>"); ?></li>
			<li id="friends-link"><?php echo Html::anchor("admin/videokes", "<i class='icon-play-circle'></i> <span class='". ($menu == 'Videokes' ? 'side-menu-item' : '') ."'>Videos"); ?></li>
                        <li id="friends-link"><?php echo Html::anchor("admin/contests", "<i class='icon-star'></i> <span class='". ($menu == 'Contests' ? 'side-menu-item' : '') ."'>Contests</span>"); ?></li>
			<li id="friends-link"><?php echo Html::anchor("admin/sponsors", "<i class='icon-leaf'></i> <span class='". ($menu == 'Sponsors' ? 'side-menu-item' : '') ."'>Sponsors</span>"); ?></li>
                        <li id="friends-link"><?php echo Html::anchor("admin/bannerAds", "<i class='icon-desktop'></i> <span class='". ($menu == 'Banner Ads' ? 'side-menu-item' : '') ."'>Banner Ads</span>"); ?></li>
		</ul>
		<!--
		<h3 >FEATURED VIDEOS</h3>
		<div id="featured">
			<ul id="admin-profile-links" <?php echo isset($active_link) ? 'class="' . $active_link . '"' : ''; ?> >
				<li id="friends-link"><b data-value="home"><span style=' font-size: 11px;'>HOME PAGE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=' font-size: 10px; text-decoration:underline;'>Click to Manage</span></b></li>
				<!--<li id="friends-link"><a href="#"  data-value="artist"><span style=' font-size: 11px;'>ARTISTS PAGE &nbsp;&nbsp;</span><span style=' font-size: 10px; text-decoration:underline;'>Click to Manage</span></a></li>-->
	            <!--<li id="friends-link"><b data-value="models"><span style=' font-size: 11px;'>MODELS PAGE &nbsp;&nbsp;</span><span style=' font-size: 10px; text-decoration:underline;'>Click to Manage</span></b></li>
				<li id="friends-link"><b data-value="news"><span style=' font-size: 11px;'>NEWS PAGE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=' font-size: 10px; text-decoration:underline;'>Click to Manage</span></b></li>
	   		</ul>
		</div>
		-->
        <?php echo Asset::img("profileLogo.png"); ?>
	</div>
</div>
