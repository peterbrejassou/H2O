<?php
/* joints Custom Post Type Example
This page walks you through creating
a custom post type and taxonomies. You
can edit this one or copy the following code
to create another one.

I put this in a separate file so as to
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

*/



/*
 * Initialise les Custom Post-Types créés
 * ----------------------------------------------------------------------------*/
//add_action( 'init', 'initCustomPostTypes' );
function initCustomPostTypes() {

  // REUSSITES
  $slug = "solution";
  $slug_rewrite = basename(get_permalink(get_field("archive_solution", "options")));
  $args = array(
    'labels'             => defineCPTLabels($slug, "Solution", "Solutions"),
    'description'        => '',
  	'public'             => true,
  	'publicly_queryable' => true,
  	'show_ui'            => true,
  	'show_in_menu'       => true,
  	'query_var'          => true,
  	'has_archive'        => false,
  	'hierarchical'       => false,
  	'show_in_rest'       => true,
    'rest_base'          => false,
  	'menu_position'      => null,
  	'capability_type'    => 'post',
    'taxonomies'         => array('post_tag'),
  	'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revision'),
    'menu_icon'          => 'dashicons-awards',
    'rewrite'            => array('slug' => $slug_rewrite, 'hierarchical' => false, 'with_front' => false),
  );
  //register_post_type($slug, $args);
  // ---------------------------------------------------------------------------




}





/*
 * Ajuste le comportement par défaut des Post-Types par défaut : pages et posts
 * ----------------------------------------------------------------------------*/
//add_action( 'init', 'my_add_template_to_posts' );
function my_add_template_to_posts() {
  $post_type_object = get_post_type_object('post');
  $slug_rewrite = basename(get_permalink(get_field("archive_post", "options")));
  $post_type_object->rewrite = array('slug' => $slug_rewrite, 'hierarchical' => false, 'with_front' => false);
}




/*
 * Défini les labels pour le Custom Post-Type en paramètre
 * ----------------------------------------------------------------------------*/
function defineCPTLabels($slug, $name, $names, $feminin = false) {

  if ( $feminin ) :
    $un = "une";
    $nouv = "nouvelle";
    $auc = "aucune";
    $trouv = "trouvée";
    $all = "Toutes";
    $parent = "parente";
  else :
    $un = "un";
    $nouv = "nouveau";
    $auc = "aucun";
    $trouv = "trouvé";
    $all = "Tous";
    $parent = "parent";
  endif;

  $labels = array(
  	'name'               => __($names, 'nbtheme'),
  	'singular_name'      => __($name, 'nbtheme'),
  	'menu_name'          => __($names, 'nbtheme'),
  	'name_admin_bar'     => __($names, 'nbtheme'),
  	'add_new'            => __('Ajouter '.$un.' '.$nouv, 'nbtheme'),
  	'add_new_item'       => __('Ajouter '.$un.' '.strtolower($name), 'nbtheme'),
  	'new_item'           => __(ucfirst($nouv).' '.strtolower($name), 'nbtheme'),
  	'edit_item'          => __('Éditer', 'nbtheme'),
    'update_item'        => __('Mettre à jour', 'nbtheme'),
  	'view_item'          => __('Voir', 'nbtheme'),
  	'all_items'          => __('Tous les '.strtolower($names), 'nbtheme'),
  	'search_items'       => __('Recherche '.$un.' '.strtolower($name), 'nbtheme'),
  	'parent_item'        => __(ucfirst($name).' parent :', 'nbtheme'),
  	'parent_item_colon'  => __(ucfirst($name).' parent :', 'nbtheme'),
  	'not_found'          => __(ucfirst($auc).' '.strtolower($name).' '.$trouv.'.', 'nbtheme'),
  	'not_found_in_trash' => __(ucfirst($auc).' '.strtolower($name).' '.$trouv.' dans la corbeille.', 'nbtheme')
  );

  return $labels;
}
