<!doctype html>
<html lang="en">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php bloginfo('name'); ?></title>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<!-- <link href='http://fonts.googleapis.com/css?family=PT+Sans:700' rel='stylesheet' type='text/css'> -->	
    <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/css/custom.css" rel="stylesheet">
	<?php wp_head(); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php body_class(); ?>>

<header>
<div class="container logo-wrap">
	<div class="pull-left">
		<img class="" src="<?php echo get_template_directory_uri(); ?>/img/logo.jpg">
	</div>
	<div class="pull-right">
		<h3><span class="">HipHopRaw.com .... The New Place For Hip Hop</span></h3>
	</div>
	<div class="clearfix"></div>		
</div>

<div class="container-fluid blog-title">
	<div class="container">
		<h2>Contest</h2>
	</div>
</div>

<div class="container blog-body">
	<?php
	if(have_posts()){
	while(have_posts()):the_post();
	?>
		<h3><?php //the_title(); ?></h3>
		<p><?php the_post_thumbnail('small-thumbnail'); ?></p>
		<?php the_content(); ?>

	<?php
	endwhile;
	}
	else
		echo '<p>Content Not Found</p>';
	?>	

</div>
<?php
get_footer();	
?>