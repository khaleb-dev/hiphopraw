<?php if(! $current_user){ ?>
<div class="join-ad-box">
	<p><span>Are you talented?</span> Upload your video now and have a chance to win our hiphopraw.com prizes.</p>
	<?php echo Html::anchor(Router::get("sign_up"), "Join <span>Now</span>", array("class" => "button rounded-corners")); ?>
</div>
<?php } ?>