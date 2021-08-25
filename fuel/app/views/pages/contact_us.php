<div id="center" class="about">	
	<div id="content" class="narrow">
		<div id="heading-with-ad" class="clearfix">
			<h2><span>Contact Us</span></h2>
			<div id="heading-ad">
				<h2>Leave us your feedback <span>with a comment</span></h2>
			</div>
		</div>
		<div class="content-box">

			<?php echo Form::open(array("action" => "pages/contact_us")); ?>
				<p>
	                <label for="Name">Your name</label>
	                <?php echo Form::input('name', Validation::instance()->validated('name')); ?>
	                <span class="error"><?php echo Validation::instance()->error('name');?></span>
	            </p>
	            <p>
	                <label for="email">Your email</label>
	                <?php echo Form::input('email', Validation::instance()->validated('email')); ?>
	                <span class="error"><?php echo Validation::instance()->error('email');?></span>
	            </p>
				<p>
					<label for="email">Comments</label>
					<?php echo Form::textarea('comments', Validation::instance()->validated('comments')); ?>
	                <span class="error"><?php echo Validation::instance()->error('comments');?></span>
				</p>
				<p class="submit">
					<input class="button rounded-corners" type="submit" value="Submit" />
				</p>
			<?php echo Form::close(); ?>

			<div class="other-way-to-get-intouch">
				<h4>Other ways to get in Touch!</h4>
				<p>Thank you for visiting hiphopraw.com</p>
				<p>
					Thank you for visiting Hip Hop Raw.
					We definitely want you to return so anything that you feel
					would make your experience on the site better let us know.
					We are a platform for the people, so we want to make sure
					that your concerns are heard and addressed. Feel free to
					leave a comment or email us anytime.
				</p>
				<p><span>Email: contact@hiphopraw.com</span> <span>&middot;</span> <span>Phone: 800-555-5555</span> <span>&middot;</span> <span>Social Media: F/T</span></p>
			</div>
		</div>	
	</div>
</div>