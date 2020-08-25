<?php
//retirer le menu généré par le theme parent susty
function ihag_remove_parent_theme_locations(){
  unregister_nav_menu( 'menu-1' );
}
add_action( 'after_setup_theme', 'ihag_remove_parent_theme_locations', 20 );

// Register menus
register_nav_menus(
	array(
		'primary' => __( 'Principal', 'ihag' ), // Secondary nav in footer
		'footer' => __( 'Footer', 'ihag' ), // Secondary nav in footer
	)
);

// The footer Menu
function ihag_menu($nav = 'primary') {
   wp_nav_menu(array(
    'container' => false,                           // Remove nav container
    'menu_class' => $nav,       // Adding custom nav class
    'items_wrap' => '<ul id="%1$s" class="%2$s" >%3$s</ul>',
    'theme_location' => $nav,                 // Where it's located in the theme
    'depth' => 2,                                   // Limit the depth of the nav
    'fallback_cb' => false,                         // Fallback function (see below)
    'walker' => new Walker_Nav_Menu()
  ));
}


// Add active class to menu
function required_active_nav_class( $classes, $item ) {
  if ( $item->current == 1 || $item->current_item_ancestor == true ) {
    $classes[] = 'active';
  }
  return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );


// Ajoute les itemprop de schema.org aux menus
add_filter( 'nav_menu_link_attributes', 'add_menu_link_atts', 10, 3 );
function add_menu_link_atts( $atts, $item, $args ) {
  $atts['itemprop'] = 'url';
  return $atts;
}
add_filter( 'nav_menu_attributes', 'add_menu_atts', 10, 3 );
function add_menu_atts( $atts, $item, $args ) {
  $atts['itemprop'] = 'url';
  return $atts;
}
