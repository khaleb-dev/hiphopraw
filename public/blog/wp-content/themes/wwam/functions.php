<?php
function load_header_res(){
	wp_enqueue_style('style',get_stylesheet_uri());
}

add_action('wp_enqueue_scripts','load_header_res');

function theme_setup(){
	register_nav_menus(array(
		'primary' => __('Primary Menu'),
		'footer' => __('Footer Menu')
	));
	add_theme_support('post-thumbnails');
	add_image_size('small-thumbnail',275,258,true);
	add_image_size('ads-thumbnail',125,125,true);
	add_image_size('banner-image',920,210,true);
}

add_action('after_setup_theme','theme_setup');

add_action('admin_init','add_custom_meta');
function add_custom_meta(){
	add_post_meta($id,'_exURL','');
}

//add widget location
function themeWidget(){
	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div class="sidebar-item">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="">',
		'after_title' => '</h4>'
	));

	register_sidebar( array(
		'name' => 'From the Blog',
		'id' => 'footer1',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h3>',		
		'after_title' => '</h3>'
	));
	register_sidebar( array(
		'name' => 'Get in Touch',
		'id' => 'footer2',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h3>',		
		'after_title' => '</h3>'		
	));	
	register_sidebar( array(
		'name' => 'Latest Tweets',
		'id' => 'tweets',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h3>',		
		'after_title' => '</h3>'		
	));		
}

add_action('widgets_init','themeWidget');

// custom post type function
function create_custom_posttype() {
 
	register_post_type( 'ads',
	// CPT Options
		array(
			'labels' => array(
				'name' => __( 'Ads' ),
				'singular_name' => __( 'Ad' )
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => array('slug' => 'ads'),
		)
	);
	
}
// Hooking up our function to theme setup
add_action( 'init', 'create_custom_posttype' );

/*
* Creating a function to create our CPT
*/
	 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Ads', 'Post Type General Name', 'twentythirteen' ),
		'singular_name'       => _x( 'Ad', 'Post Type Singular Name', 'twentythirteen' ),
		'menu_name'           => __( 'Ads', 'twentythirteen' ),
		'parent_item_colon'   => __( 'Parent Ad', 'twentythirteen' ),
		'all_items'           => __( 'All Ad', 'twentythirteen' ),
		'view_item'           => __( 'View Ad', 'twentythirteen' ),
		'add_new_item'        => __( 'Add New Ad', 'twentythirteen' ),
		'add_new'             => __( 'Add New', 'twentythirteen' ),
		'edit_item'           => __( 'Edit Ad', 'twentythirteen' ),
		'update_item'         => __( 'Update Ad', 'twentythirteen' ),
		'search_items'        => __( 'Search Ad', 'twentythirteen' ),
		'not_found'           => __( 'Not Found', 'twentythirteen' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
	);
	 
	// Set other options for ads Post Type
	 
	$args = array(
		'label'               => __( 'ads', 'twentythirteen' ),
		'description'         => __( 'Advertisement category', 'twentythirteen' ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		// You can associate this CPT with a taxonomy or custom taxonomy.
		'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have Parent and child items. A non-hierarchical CPT  is like Posts.	*/ 
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
	);
	
	// Registering ads Custom Post Type
	register_post_type( 'ads', $args );
	
}
 
/* Hook into the 'init' action so that the function Containing our post type registration is not unnecessarily executed. */
add_action( 'init', 'custom_post_type', 0 );

?>