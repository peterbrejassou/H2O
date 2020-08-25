<?php
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/jsonACF';
    if ( !file_exists($path) ){mkdir($path, 0777);}
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_stylesheet_directory() . '/jsonACF';
    // return
    return $paths;
}
/************* API KEY GOOGLE MAPS (admin) *******************/
add_action('acf/init', 'google_acf_init');
function google_acf_init() {
	acf_update_setting('google_api_key', 'AIzaSyCQHuxQVPWp600x0Tmdxrae7F9_Gz7j1kw');//clé temporaire
}


/************* Page option *******************/
if( function_exists('acf_add_options_page') ) {
	// Page principale
	acf_add_options_page(array(
		'page_title'    => 'Options',
		'menu_title'    => 'Options',
		'menu_slug'     => 'options-generales',
		'capability'    => 'edit_posts',
		'redirect'      => true
	));

  // Page d'options
  acf_add_options_sub_page(array(
  	'page_title' 	=> 'Options Générales',
  	'menu_slug' 	=> 'acf_options',
  	'parent_slug'   => 'options-generales'
  ));
}



