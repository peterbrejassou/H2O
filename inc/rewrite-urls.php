<?php

/*
 * Flush automatiquement les permaliens
 * A N'ACTIVER QU'EN DEVELOPPEMENT
 * ----------------------------------------------------------------------------*/
// add_action('wp_loaded','my_flush_rules');
function my_flush_rules() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}


/*
 * Initialise les Custom Post-Types créés
 * ----------------------------------------------------------------------------*/
add_action( 'init', 'initRewriteURLs' );
function initRewriteURLs() {

  // Redonne la priorité aux pages dans la réécriture d'URL
  // N'ayant pas de slug root
  add_action('generate_rewrite_rules', function ( $wp_rewrite ) {

    $specific_rules = array();

    // POST TYPES
    $archives = array(
      "post" => basename( get_permalink(get_field("archive_post", "options")) )
    );

    // TAXONOMIES
    $taxos = array("category", "tax-prestation");
    $terms = get_terms( array(
        'taxonomy' => $taxos,
        'hide_empty' => 0
      )
    );
    foreach ( $archives as $post_type => $archive ) {
      foreach ( $terms as $term ) {
        if ( $term->taxonomy == "tax-prestation" && $post_type == "prestataires" ) {
          // Tags sur les actualités
          $specific_rules[$archive.'/'.$term->slug.'/page/?([0-9]{1,})/?$'] = 'index.php?post_type='.$post_type.'&tax-prestation='.$term->slug.'&paged=$matches[1]';
          $specific_rules[$archive.'/'.$term->slug.'/?$'] = 'index.php?post_type='.$post_type.'&tax-prestation='.$term->slug;
        }
        elseif ( $term->taxonomy == "category" && $post_type == "post" ) {
          // Catégories sur les actualités
          $specific_rules[$archive.'/'.$term->slug.'/page/?([0-9]{1,})/?$'] = 'index.php?post_type='.$post_type.'&category_name='.$term->slug.'&paged=$matches[1]';
          $specific_rules[$archive.'/'.$term->slug.'/?$'] = 'index.php?post_type='.$post_type.'&category_name='.$term->slug;
        }
      }
    }

    // Pages
    // $specific_rules['(.+?)/?$'] = 'index.php?pagename=$matches[1]';
    // $specific_rules['(.+?)/page/?([0-9]{1,})/?$'] = 'index.php?pagename=$matches[1]&paged=$matches[2]';

    // Posts
    $specific_rules[$archives["post"].'/([^/]+)/?$'] = 'index.php?post_type=post&name=$matches[1]';

    $wp_rewrite->rules = $specific_rules + $wp_rewrite->rules;

  });
}

add_filter('post_link', 'nb_post_link', 10, 3);
function nb_post_link( $url, $post, $leavename=false ) {
  if ( $post->post_name && $post->post_type == 'post' ) {
    $url = get_permalink(get_field("archive_post", "options")).$post->post_name."/";
	}
	return $url;
}

add_filter('term_link', 'nb_post_tags_link', 10, 3);
function nb_post_tags_link($url, $term, $taxonomy) {
  if ( $taxonomy == 'category' ) :
    $root = get_permalink(get_field("archive_post", "options"));
    return $root.$term->slug;

  elseif ( $taxonomy == 'tax-prestation' ) :
    $root = get_permalink(get_field("archive_prestataires", "options"));
    return $root.$term->slug;
  endif;

  return $url;
}
