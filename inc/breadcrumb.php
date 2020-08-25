<?php
/*
 *  BREADCRUMB // cf. fonctions.php
 *  Basé sur l'extension Breadcrumb NavXT
 *  Author: Nicolas Blandel | @NicoBlandel
 *  URL: www.nicoblandel.fr
 */

/*
Affiche le fil d'ariane
@see https://developer.wordpress.org/reference/functions/get_body_class/
*/

// VARIABLES
$pos = 2;

// Modèle d'element du fil d'ariane
function tplItem($lien, $nom, $pos, $last_item = false, $class=false) {
  if ( $class ) :
    $class = "class='".$class."' ";
  endif;
  $item = "<li ".$class."itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>";
  if ( !$last_item ) :
    $item .= "<a itemprop='item' href='".$lien."'><span itemprop='name'>".$nom."</span></a>";
  else :
    $item .= "<span itemprop='item'><span itemprop='name'>".$nom."</span></span>";
  endif;
  $item .= "<meta itemprop='position' content='".$pos."' />";
  $item .= "</li>";
  return $item;
}

// Fonction d'affichage du fil d'ariane
function wpBreadcrumb( $echo = true ) {

  global $pos;

  if ( is_front_page() && is_home() ) :
    // Default homepage
    return;

  else :
    $breadcrumb = "<nav id='nav-breadcrumbs' role='navigation'>";
    $breadcrumb .= "<ol id='breadcrumbs' itemscope itemtype='http://schema.org/BreadcrumbList'>";

    // Page d'accueil
    $breadcrumb .= tplItem(home_url(), __("Accueil", "arpdl"), "1", false, "home");

    if ( !is_front_page() && is_home() ) :
      // blog page
      if ( $blog_page = get_option('page_for_posts') ) :
        $breadcrumb .= tplItem(get_permalink($blog_page), get_the_title($blog_page), $pos, true);
        $pos++;
      endif;

    elseif ( is_page() ) :
      // Traite la page et ses parents
      $ancestors = array_reverse( get_post_ancestors(get_the_ID()) );
      array_push($ancestors, get_the_ID());
      $count = count($ancestors);
      foreach ( $ancestors as $ancestor ) :
        $name = strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) );

        if ( $ancestor != end($ancestors) ) : // Si ancetre
          $breadcrumb .= tplItem(get_permalink($ancestor), $name, $pos);

        else : // Si page courante
          $breadcrumb .= tplItem(get_permalink($ancestor), $name, $pos, true);

        endif;
        $pos++;
      endforeach;
      // endif is_page()

    elseif ( is_author() ) :

      $author = get_user_by('slug', get_query_var('author_name'));
      $breadcrumb .= tplItem(get_author_posts_url($author->ID), $author->display_name, $pos, true);
      // endif is_author()

    elseif ( is_category() ) :
      $breadcrumb .= nbParentCategories($GLOBALS['cat'], true);
      // endif is_category()

    elseif ( is_tax("type_immo") ) :
      // taxo type_immo
      $breadcrumb .= tplItem(get_post_type_archive_link("immobilier"), __("Immobilier", "arpdl"), $pos);
      $pos++;
      $breadcrumb .= tplItem(get_permalink(), get_queried_object()->name, $pos, true);

    elseif ( is_tag() ) :

      // Archive
      $type = get_query_var("post_type") ? get_query_var("post_type") : "post";
      $archive = get_field("archive_".$type, "options");
      $breadcrumb .= tplItem(get_permalink($archive), get_the_title($archive), $pos);
      $pos++;

      $breadcrumb .= tplItem(get_category_link(get_the_ID()), single_term_title('', false), $pos, true);

    elseif ( taxonomy_exists( get_query_var('taxonomy') ) ) :
      $cpt = get_post_type_object($post_type);
      // $cpt->hierarchical
      if ( $cpt->has_archive ) : // si page d'archive
        $breadcrumb .= tplItem(get_post_type_archive_link($post_type), $cpt->label, $pos);
        $pos++;
      endif;

      $breadcrumb .= nbParentTerms(get_query_var('taxonomy'), get_post_type(), get_query_var('term'));
      // endif is_term()

    elseif ( is_archive() ) :
      $breadcrumb .= nbParentArchive(get_post_type());
      // endif is_archive()

    // Page Post / Custom Post Type
    elseif ( is_single() ) :

      // On récupère le type du contenu
      $post_type = get_post_type_object( get_post_type() );

      if ( $post_type->has_archive ) : // On affiche l'archive
        $breadcrumb .= tplItem(get_post_type_archive_link($post_type->name), $post_type->label, $pos);
        $pos++;

      elseif ( $archive = get_field("archive_".get_post_type(), "options") ) : // On affiche l'archive

        if ( get_post_type() == "lieux-tournages" ) :
          $post_archive = get_post($archive);
          $breadcrumb .= tplItem(get_permalink($post_archive->post_parent), get_the_title($post_archive->post_parent), $pos);
          $pos++;
        endif;

        $breadcrumb .= tplItem(get_permalink($archive), get_the_title($archive), $pos);
        $pos++;

      else : // On affiche les categories
        $cat = get_the_category();
        $breadcrumb .= nbParentCategories($cat[0]->term_id);

      endif;

      if($post_type->name == "immobilier"):
        $taxo = wp_get_post_terms(get_the_ID(), 'type_immo');
        if ( !is_wp_error( $taxo ) && sizeof($taxo) > 0 ) {
          $breadcrumb .= tplItem(get_term_link($taxo[0], "type_immo"), $taxo[0]->name, $pos);
        }
      endif;

      $breadcrumb .= tplItem(get_permalink(), get_the_title(), $pos, true);
      // endif is_single()

    // Page Recherche
    elseif ( is_search() ) :
      $breadcrumb .= tplItem(get_permalink(), __("Résultats de votre recherche sur")." &laquo;".get_search_query()."&raquo;", $pos, true);
      // endif is_search()


    // Page 404
    elseif ( is_404() ) :
      $breadcrumb .= tplItem(get_permalink(), __("404 - Page non trouvée"), $pos, true);
      // endif is_404()

    elseif ( is_tag() ) :
    // Non implémenté pour le moment
    // endif is_tag()

    elseif ( is_attachment() ) :
    // Non implémenté pour le moment
    // endif is_attachment()

    elseif ( is_date() ) :
      // Non implémenté pour le moment
      /*
      if ( is_day() ) :
        $year = get_year_link('');
        $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
        $month = get_month_link( get_query_var('year'), get_query_var('monthnum') );
        $final .= $sep.$data.'<a title="'.single_month_title(' ',false).'" href="'.$month.'" rel="v:url" property="v:title">'.single_month_title(' ',false).'</a>'.$dataend;
        $final .= $sep."Archives pour ".get_the_date();
      elseif ( is_month() ) :
        $year = get_year_link('');
        $final .= $data.'<a title="'.get_query_var("year").'" href="'.$year.'" rel="v:url" property="v:title">'.get_query_var("year").'</a>'.$dataend;
        $final .= $sep."Archives pour ".single_month_title(' ',false);
      elseif ( is_year() ) :
        $final .= "Archives pour ".get_query_var('year');
      endif;
      */
      // endif is_date()

    endif;

    $breadcrumb .= "</ol>";
    $breadcrumb .= "</nav>";

    if ( $echo ) :
      echo $breadcrumb;
    else :
      return $breadcrumb;
    endif;

  endif;
}

// Affiche toutes les catégories parentes
function nbParentCategories($cat, $is_category=false) {
  global $pos;

  $return = "";

  $archive = get_field("archive_post", "options");
  $return .= tplItem(get_permalink($archive), get_the_title($archive), $pos);
  $pos++;

  $all_cats = get_category_parents($cat, false, "/", true);
  $catslugs = array_filter(explode("/", $all_cats));

  if ( $catslugs ) : // si slug non vide
    $i = 1;
    $last_index = sizeof($catslugs);
    foreach ( $catslugs as $catslug ) :

      $last = false;
      if ( $is_category && $i == $last_index ) :
        $last = true;
      endif;

      $categ = get_category_by_slug($catslug);
      $return .= tplItem(get_category_link($categ->term_id), $categ->name, $pos, $last);
      $pos++;
      $i++;
    endforeach;
  endif;
  return $return;
}


// Affiche toutes les taxonomies parentes
/*
Dans les options admin on doit définir si l'affichage du PostType se fait avec la taxo
et si la base est une archive ou une page (à définir)

Selon PostType : hierachical, has_archive, slug rewrite
Récupérer la page parente (slug)
*/
function nbParentTerms($term_slug, $taxo) {
  $term = get_term_by( "slug", $term_slug, $taxo);
  $return = tplItem(get_term_link($term->term_id), $term->name, $pos);
  $pos++;

  $all_terms = get_ancestors($term->term_id, $taxo);
  if ( $all_terms ) :
    foreach ( $all_terms as $one_term ) :
      $term = get_term_by( "id", $one_term, $taxo);
      $return = tplItem(get_term_link($term->term_id), $term->name, $pos).$return;
      $pos++;
    endforeach;
  endif;

  return $return;
}

// Affiche le lien vers page d'archive (pour un post-type)
function nbParentArchive($cpt) {
  global $pos;

  $return = "";
  $obj = get_post_type_object( $cpt );
  $return .= tplItem(get_post_type_archive_link($cpt), $obj->labels->name, $pos);
  $pos++;
  return $return;
}
