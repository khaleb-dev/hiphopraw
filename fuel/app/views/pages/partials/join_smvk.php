<?php if(! $current_user){ ?>
	<div class="join-ad-box content-box">
		<p>
			<span>Become a member today!</span> 
			Sign up now and get instant access to enter 
			our community. Enter in the online contest
			and have a chance to win our hiphopraw.com
			prizes.
		</p>
		<?php echo Html::anchor(Router::get('sign_up'), "Join <span>Now</span>", array("class" => "button rounded-corners")); ?>
	</div>
<?php } ?>
