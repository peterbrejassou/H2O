<?php
// @src: https://crunchify.com/how-to-clean-up-wordpress-header-section-without-any-plugin/
function crunchify_remove_version() {
	return '';
}
add_filter('the_generator', 'crunchify_remove_version');
 
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
 
remove_action ('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'wp_shortlink_wp_head');
 
function crunchify_cleanup_query_string( $src ){ 
	$parts = explode( '?', $src ); 
	return $parts[0]; 
} 
add_filter( 'script_loader_src', 'crunchify_cleanup_query_string', 15, 1 ); 
add_filter( 'style_loader_src', 'crunchify_cleanup_query_string', 15, 1 );


remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed

//nombre de révisions
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 3 );
}
add_filter('wp_revisions_to_keep', 'filter_function_name', 4, 2);
function filter_function_name($num, $post)
{
	return 3;
}

/** et un intervalle entre deux sauvegardes de 360 secondes**/
if (!defined('AUTOSAVE_INTERVAL')) {
	define('AUTOSAVE_INTERVAL', 360);
}


// Calling all custom dashboard widgets
function ihag_custom_dashboard_widgets()
{
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
	remove_meta_box('dashboard_primary', 'dashboard', 'side');            // WordPress blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
	remove_meta_box('dashboard_activity', 'dashboard', 'normal');
	remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal'); // Recent Comments
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
	remove_action('welcome_panel', 'wp_welcome_panel');
}
add_action('wp_dashboard_setup', 'ihag_custom_dashboard_widgets');



// all actions related to emojis
function ihag_disable_wp_emoji()
{
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');

  // filter to remove TinyMCE emojis
	add_filter('tiny_mce_plugins', 'ihag_disable_emoji_tinymce');
}
add_action('init', 'ihag_disable_wp_emoji');

function ihag_disable_emoji_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}


add_action('admin_menu', 'remove_unnecessary_wordpress_menus', 999);

function remove_unnecessary_wordpress_menus(){
    $customizer_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' );
    remove_submenu_page( 'themes.php', $customizer_url );

    global $submenu;
    unset($submenu['themes.php'][20]);//background_image
}

// disable editeur de code
define( 'DISALLOW_FILE_EDIT', true );

// disable the admin bar
add_filter('show_admin_bar', '__return_false');

function no_wordpress_errors(){
    return 'Something is wrong!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );


remove_action('welcome_panel', 'wp_welcome_panel');