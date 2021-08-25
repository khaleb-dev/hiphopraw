<?php
/*
Plugin Name: Address
Description:
Version: 1
Author: Nati G.
Author URI: http://yytdevelopment.com
*/

//menu items
add_action('admin_menu','address_menu');
function address_menu() {
	
	//this is the main item for the menu
	add_menu_page('Address', //page title
	'Address', //menu title
	'manage_options', //capabilities
	'address_update', //menu slug
	'address_update' //function
	);
	/*
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Address', //page title
	'Update', //menu title
	'manage_options', //capability
	'address_update', //menu slug
	'address_update'); //function */
}
define('ROOTDIR', plugin_dir_path(__FILE__));

require_once(ROOTDIR . 'address-update.php');

//To show on front page
/*function custom_shortcode() {
	return “here goes the code”;
}*/
//add_shortcode( 'showlist', 'sinetiks_schools_list' );