<?php

include_once("inc/acf.php");
include_once("inc/acf-block.php");
include_once("inc/settings-gutenberg.php");
include_once("inc/widget.php");
include_once("inc/clean.php");
include_once("inc/no-comment.php");
include_once("inc/images.php");
include_once("inc/custom-post-type.php");
include_once("inc/breadcrumb.php");
include_once("inc/menu.php");
include_once("inc/enqueue_scripts.php");
//include_once("inc/contact.php");



// Adding excerpt for page
//add_post_type_support( 'page', 'excerpt' );

/**
 * Filter the excerpt length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
//add_filter( 'excerpt_length', function( $length ) { return 20; } );

function ihag_unregister_taxonomy(){
    register_taxonomy('post_tag', array());
    register_taxonomy('category', array());
	add_post_type_support( 'page', 'excerpt' );
	remove_post_type_support( 'page', 'thumbnail' );
}
//add_action('init', 'ihag_unregister_taxonomy');

// Copier le contenu d'une page ou d'un post à la création d'une traduction
function cw2b_content_copy( $content ) {    
    if ( isset( $_GET['from_post'] ) ) {
        $my_post = get_post( $_GET['from_post'] );
        if ( $my_post )
            return $my_post->post_content;
    }
    return $content;
}
//add_filter( 'default_content', 'cw2b_content_copy' );

function my_pre_get_posts($query) {

  if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
      $query->set('post_type', array("post", "rendez-vous", "solution"));
      $query->set('posts_per_page', -1);
  } 

}
//add_action( 'pre_get_posts', 'my_pre_get_posts' );

function nbTinyURL($url)  {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}