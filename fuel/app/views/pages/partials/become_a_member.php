<?php if(! $current_user){ ?>
<div id="become-a-member" class="section">
	<div class="content-box">
		<?php echo Asset::img("become_a_member.jpg"); ?>
		<h4>Sign Up Now <span>and get instant access!</span></h4>
        <p>
            Sign up to Hip Hop Raw today and connect with friends, show your talent or judge others' talent, & win valuable gifts & prizes!
		</p>
		<?php echo Html::anchor(Router::get("sign_up"), "Click here to <em>Sign Up</em> now!", array("class" => "button rounded-corners")); ?>
	</div>
</div>
<?php } ?>
