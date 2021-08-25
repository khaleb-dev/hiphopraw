 <div id="center" class="about">
	<div id="heading-with-ad" class="clearfix">
		<h2 class="labeled-heading"><span>About Us</span></h2>
		<?php if(! $current_user) { ?>
		<div id="heading-ad">
			<?php echo Asset::img("compete_with_friends.png"); ?>
			<div class="content-box">Join hiphopraw.com and enter your video now! <?php echo Html::anchor(Router::get("sign_up"), "Join Now",array("class" => "button small rounded-corners")); ?></div>
		</div>
		<?php } ?>
	</div>
	<div id="content">
		
		<div id="highlight">
			<h1>We've created a premium video platform for all talents and their supporters.</h1>
			<p id="tag-line"><span>It's <em>free</em> and easy to join!</span></p>
			<?php  echo Asset::img("about_screenshots.png", array("id" => "screenshot")); ?>
			<div id="steps" class="clearfix">
				<div>
					<h3>Build Your Profile</h3>
					<p>
						Simply sign up in the name you would like to be called, add
						any pictures and videos of you and your talent that you like,
						and you’re on your way.
					</p>
				</div>
				<div class="center">
					<h3>Share</h3>
					<p>
						Once your profile is created, you can then share your videos
						with others on hiphopraw.com and also invite others to
						enjoy and vote on your video through Facebook, Twitter,
						Instagram, and any other social networking site you might
						belong to.
					</p>
				</div>
				<div>
					<h3>Compete</h3>
					<p>
						Want to win great gifts, cash and prizes while gaining more
						meaningful exposure for you and your talent? Enter your
						Video in one of our Hip Hop Raw Contests.
					</p>
				</div>
			</div>
			<div id="join-button">
				<span><?php  echo Html::anchor(Router::get("sign_up"), "Join Now", array("class" => "button red rounded-corners")); ?></span>
			</div>
		</div>

		<div class="content-box about-info">
			<h3 class="normal">A little more about who we are</h3>
			<p>
				We here at Hip Hop Raw believe not only that everyone
				deserves to feel like a star, but also that everyone deserves to
				be rewarded for the talent they possess. At Hip Hop Raw,
				that reward is money; prizes, recognition and exposure, and
				just the satisfaction of knowing you’ve entertained others. We
				also feel that those who enjoy talent and have an interest in
				commenting and judging talent should have a place where they
				can come and be entertained, while also putting a face to their
				color commentary; thus creating more quality videos of talent.
				So come sign up and be a part of the next big thing in social
				media and entertainment. The place where Everyone’s a Star
				and Everyone has a chance to be a winner.
			</p>
		</div>

		<div class="heading-image"><?php // echo Asset::img("build_profile.png"); ?></div>
		<div class="content-box about-info clearfix">
			<h3>Connect with friends and upload new Videos right from your profile</h3>
			<div class="text">
				<p>
					At Hip Hop Raw, once your profile is built, you can
					upload videos you have already created, or you can create a
					video right from your profile using your webcam or
					smartphone. You can also invite friends, message and chat
					with them, and comment on their videos. The best part
					about building a profile is once it’s made, you are eligible for
					the many Video Contests giving you a chance to win many
					prizes.
				</p>
			</div>
			<div class="thumb">
				<?php  echo Asset::img("about_connect_screenshot.png"); ?>
			</div>
		</div>

		<div class="heading-image"><?php echo Asset::img("share.png"); ?></div>
		<div class="content-box about-info clearfix">
			<h3>Share your Videos with the world through our platform</h3>
			<div class="text">
				<p>
					The videos you upload to Hip Hop Raw can be seen and
					enjoyed by everyone. Also, when someone views one of your
					videos, a recommendation to view a video from one of your
					top friends or “Your Team” as we like to refer to them here
					at Hip Hop Raw will follow. So you and your friends are
					helping each other gain views and exposure without having
					to do any extra work.
				</p>
			</div>
			<div class="thumb">
				<?php echo Asset::img("about_share_screenshot.png"); ?>
			</div>
		</div>

		<div class="heading-image"><?php echo Asset::img("compete.png", array("class" => "heading-image")); ?></div>
		<div class="content-box about-info clearfix">
			<h3>Compete with friends & other members until a winner is crowned!</h3>
			<div class="text">
				<p>
					Enter your video in one of our Hip Hop Raw Contests’
					and you will have a chance to win many valuable gifts and
					prizes. Videos will go head to head until a winner is crowned
					champion. The winner is determined totally by the people
					watching and judging the videos. No Politics Here!
				</p>
			</div>
			<div class="thumb">
				<?php echo Asset::img("about_compete_screenshot.png"); ?>
			</div>
		</div>

		<?php echo Asset::img("logo_slogan.png", array("class" => "logo-slogan")); ?>

	</div>
</div>