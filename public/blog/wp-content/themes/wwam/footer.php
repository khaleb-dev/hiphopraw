<div class="container-fluid blog-footer">
	<div class="container">
		<div class="col-md-4">
			
			<?php 
			if(is_active_sidebar('footer1')){
				dynamic_sidebar('footer1'); 
			}
			?>
		</div>
		<div class="col-md-4">
			<?php 
			if(is_active_sidebar('tweets')){
				dynamic_sidebar('tweets'); 
			}
			?>
		</div>
		<div class="col-md-4">
			
			<?php 
			if(is_active_sidebar('footer2')){
				dynamic_sidebar('footer2'); 
			}
			?>
			<?php
				global $wpdb;
				$address = $wpdb->get_results($wpdb->prepare("SELECT * from address where id=%s",1));
				foreach ($address as $s ){
					$facebook = $s->facebook;
					$tweet = $s->tweet;
					$email = $s->email;
					$vemo = $s->vemo;
				}
			?>
			<p class="social-icons"> 
				<a target="blank" href="<?php echo $facebook; ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/facebook.jpg"></a>
				<a target="blank" href="<?php echo $tweet; ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/tweet.jpg"></a>
				<a href="mailto:<?php echo $email; ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/message.jpg"></a>
				<a target="blank" href="<?php echo home_url(); ?>/index.php/feed/"><img src="<?php echo get_template_directory_uri(); ?>/img/rss.jpg"></a>
				<a target="blank" href="<?php echo $vemo; ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/v.jpg"></a>
			</p>
			</div>
		</div>			
		<div class="clearfix"></div>
	</div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<?php wp_footer(); ?>
</body>
</html>