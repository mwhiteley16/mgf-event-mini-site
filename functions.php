<?php
/**
 * Functions
 *
 * @package      mgf-event-site
 * @since        1.0.0
 * @author       Matt Whiteley <matt@whiteleydesigns.com>
 * @copyright    Copyright (c) 2014, Matt Whiteley
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Mobile Growth Fellowship Events' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '1.5' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//Ensure jQuery loads
add_action('init', 'mw_load_scripts', 0);
function mw_load_scripts() {
	wp_enqueue_script('jquery');
}

// Enqueue custom styles (google fonts, font-awesome, etc...)
add_action( 'wp_enqueue_scripts', 'mw_enqueue_fonts' );
function mw_enqueue_fonts() {
     wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,700,800,600|Roboto:300,300i,400,400i,500,500i,700,700i', array(), CHILD_THEME_VERSION );
     wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );
}

//Remove default Genesis page templates (they are no good and I will never use them and they confuse clients...)
function wd_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'wd_remove_genesis_page_templates' );

//Remove default genesis sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'footer-1' );
unregister_sidebar( 'footer-2' );
unregister_sidebar( 'footer-3' );

//Edit the header layout
remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'genesis_do_new_header' );
function genesis_do_new_header() {
     get_template_part( 'inc/header' );
}

//Edit the footer layout
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'genesis_do_new_footer' );
function genesis_do_new_footer() {
     get_template_part( 'inc/footer' );
}

//Remove default navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );

// Adding custom Favicon
remove_action('wp_head', 'genesis_load_favicon');
add_filter( 'genesis_pre_load_favicon', 'custom_favicon' );
function custom_favicon( $favicon_url ) {
	return get_stylesheet_directory_uri().'/images/favicon.png';
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'bg_remove_comment_form_allowed_tags' );
function bg_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Optionally hide the custom setting from the dashboard (for production)
//add_filter('acf/settings/show_admin', '__return_false');


// Add universal ACF Options page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'MGF Universal Settings',
		'menu_title'	=> 'MGF Options',
		'menu_slug' 	=> 'mgf-options-page',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}
