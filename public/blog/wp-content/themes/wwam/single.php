<?php
get_header();
?>

<div class="container blog-body">
	<div class="col-md-9 no-pad-left">
	
	<?php
	if(have_posts()){
	while(have_posts()):the_post();
	?>
		<h3><?php the_title(); ?></h3>
		<div class="art-info">
			Posted: <?php the_time('m/d/Y'); ?> in 
			<?php 

			$categories = get_the_category();

			if($categories){
				foreach ($categories as $cat) {
					echo '<a href="'.get_category_link($cat->term_id).'">'.$cat->cat_name.'</a>';
				}
			}?>
		</div>
		
		<p><?php the_post_thumbnail('small-thumbnail'); ?></p>
		<?php the_content(); ?>
		<?php comments_template(); ?>
	<?php
	endwhile;
	}
	else
		echo '<p>No Posts Found</p>';
	?>	
	</div>
	<?php
	get_sidebar();	
	?>
</div>

<?php
get_footer();	
?>