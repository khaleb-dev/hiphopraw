<?php
get_header();
?>

<div class="container blog-body">
	<div class="col-md-9 no-pad-left">
	
	<?php
	if(have_posts()){
	while(have_posts()):the_post();
	?>
		<div class="single-art">
			<div class="col-md-5">
				<?php the_post_thumbnail('small-thumbnail'); ?>
			</div>
			<div class="col-md-7">
				<h3><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="art-info">
				Posted: <?php the_time('m/d/Y'); ?> in 
				<?php 

				$categories = get_the_category();

				if($categories){
					foreach ($categories as $cat) {
						echo '<a href="'.get_category_link($cat->term_id).'">'.$cat->cat_name.'</a>';
					}
				}?>
				
				<p class="pull-right"> <?php comments_number('No comment','1 comment','% comments') ?></p>
				</div>
				<?php echo get_the_excerpt(); ?>
				<a href="<?php echo the_permalink(); ?>">Read More</a>
			</div>
			<div class="clearfix"></div>
			<div class="art-divder">&nbsp;</div>
		</div>	
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