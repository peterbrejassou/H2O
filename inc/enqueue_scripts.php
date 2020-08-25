<?php
 
add_action('wp_enqueue_scripts', 'site_scripts', 999);
function site_scripts(){
    global $wp_styles;
    wp_deregister_script('jquery');
    wp_register_script('script', get_stylesheet_directory_uri() . '/script.js', false, false, 'all');
    wp_enqueue_script('script');

    // Enlever style css blocs gutenberg
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
}