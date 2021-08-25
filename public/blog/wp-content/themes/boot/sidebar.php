<div class="col-md-3">

		<!--<div class="col-md-6"><img src="<?php echo get_template_directory_uri(); ?>/img/ads.jpg"></div>
		<div class="col-md-6"><img src="<?php echo get_template_directory_uri(); ?>/img/ads.jpg"></div>
		<div class="clearfix"></div>
		<div class="col-md-6"><img src="<?php echo get_template_directory_uri(); ?>/img/ads.jpg"></div>
		<div class="col-md-6"><img src="<?php echo get_template_directory_uri(); ?>/img/ads.jpg"></div>
		<div class="clearfix"></div> -->
		<?php
		$args = array( 'post_type' => 'ads', 'posts_per_page' => 4 );
		$the_query = new WP_Query( $args );
		?>
		<?php if ( $the_query->have_posts() ) : ?>
		<div class="ads sidebar-item">
		<h4>Advertisements</h4>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="col-md-6">
			<?php $url = get_post_meta($post->ID,'exURL',true);
			if ($url) { ?>
				<a target="blank" href="<?php echo $url; ?>"><?php the_post_thumbnail('ads-thumbnail'); ?></a>
			<?php }
			else {
				the_post_thumbnail('ads-thumbnail');}
			?>
			</div>
			<?php endwhile; ?>
			<div class="clearfix"></div>
		</div>			
			<?php else: ?>
			<p><?php // _e( 'No Ads Found.' ); ?></p>
		  
		<?php endif; ?>			

		<?php 
			if(is_active_sidebar('sidebar1')){
				dynamic_sidebar('sidebar1'); 
			}
			?>
	
<div class="clearfix"></div>
</div>