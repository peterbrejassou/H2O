<?php

add_filter('upload_mimes', 'nbMymeTypes', 1, 1);
function nbMymeTypes($mime_types) {
	$mime_types['svg'] = 'image/svg+xml';
	return $mime_types;
}

/* Definitions des tailles d'images
@src https://developer.wordpress.org/reference/functions/add_image_size/
-----------------------------------------------------------------*/
if (function_exists('add_theme_support')) {

	// Qualité des images
	add_filter('jpeg_quality', function() {
		return (int)100;
	});

	// Add Thumbnail Theme Support
	add_theme_support('post-thumbnails');		

	// Images size
	add_image_size('logo', 100, 100);
	add_image_size('292x363', 292, 363);

}

/* Nettoie les medias uploadés
-----------------------------------------------------------------*/
add_filter( 'sanitize_file_name', 'remove_accents', 10, 1 );
add_filter( 'sanitize_file_name_chars', 'sanitize_file_name_chars', 10, 1 );
function sanitize_file_name_chars( $special_chars = array() ) {
	$special_chars = array_merge( array( '’', '‘', '“', '”', '«', '»', '‹', '›', '—', 'æ', 'œ', '€' ), $special_chars );
	return $special_chars;
}

//Le code suivant n'est pas utilisé car incompatible avec le format webP

/*
 *  IMAGES // cf. fonctions.php
 *  Author: Nicolas Blandel | @NicoBlandel
 *  URL: www.nicoblandel.fr
 */

/* Désactive la création des différents formats d'images en admin
* Ne conserve que la thumbnail par défaut
-----------------------------------------------------------------*/
//add_filter( 'intermediate_image_sizes', "onlyThumb", 99 );
function onlyThumb( $array ) {
	if ( is_admin() ) :
  	return array("thumbnail");
	else :
		return $array;
	endif;
}

/**
  * Traitement lié au bouton d'administration pour regénérer les images d'une page
	* On stocke temporairement en session la variable de regénération pour pouvoir
	* nettoyer automatiquement l'URL.
	*/
/*if ( is_user_logged_in() && current_user_can('manage_options') && !is_admin() ) :
	add_action("init", function () {

		//session_start();

		// Si le bouton de regénération des images est cliqué,
		// on stocke l'info dans une variable de session
		if ( isset($_GET["regimg"]) ) :
			$_SESSION["forceRegenerate"] = true;
			wp_safe_redirect( esc_url(remove_query_arg("regimg")) );
			exit;
		endif;

		// Si la session est activée,
		// on la stocke dans une variable globale et on la supprime
		if ( isset($_SESSION["forceRegenerate"]) ) :
			$GLOBALS["forceRegenerate"] = $_SESSION["forceRegenerate"];
			unset( $_SESSION["forceRegenerate"] );

		endif;
	});
endif;*/


/**
*  Permet d'ajouter une image avec ses bons attributs
*  $img_id : ID de l'image
*  $sizes : tailles à utiliser pour l'affichage => exemple : array("full", "img800", "img400")
*  $vwsizes : tailles à utiliser pour l'affichage => exemple : "(max-width:400px 100vw), 400px"
*  Explications : https://developer.mozilla.org/fr/docs/Apprendre/HTML/Comment/Ajouter_des_images_adaptatives_%C3%A0_une_page_web
*  $class : classe à ajouter sur l'image
*  $isThumbnail : pour ajouter une structure schema.org d'image principale
*/
function responsiveImg($img_id, $sizes, $vwsizes="100vw", $class=false, $isThumbnail=false, $option="") {

	$alt = "";

  if ( $img_id ) :
		$checkImgs = array();
    	$img_exist = false;
		$srcset = "";
		$size_full = "";
		$width_full = 0;
		$height_full = 0;

		foreach ( $sizes as $size ) :

			$img = createMissingImgSize($img_id, $size);

			if ( $img ) :
				if ( $srcset ) :
					$srcset .= ",";
				endif;

				if ( !in_array($img[1], $checkImgs) ) :
					$checkImgs[] = $img[1];
					$srcset .= $img[0]." ".$img[1]."w";
					if ( $width_full < $img[1] ) :
						$width_full = $img[1];
						$size_full = $img[0];
					endif;
					if ( $height_full < $img[2] ) :
						$height_full = $img[2];
					endif;
				endif;

        $img_exist = true;

			endif;
		endforeach;

		if ( !$img_exist ) : // Si aucun format n'a pu être généré
      $img = wp_get_attachment_metadata( $img_id );
      if ( $img ) :
        $upload_dir = wp_upload_dir();
        $size_full = $upload_dir["baseurl"]."/".$img["file"];
        $width_full = $img["width"];
        $height_full = $img["height"];
        $srcset .= $size_full." ".$width_full."w";
	    endif;
		endif;

		if ( !$alt ) :
			$alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
		endif;

		if ( $isThumbnail ) :
			$renderedImg = "<div itemprop='image' class='".$class."' itemscope itemtype='http://schema.org/ImageObject' ".$option.">";
			$renderedImg .= "<img sizes='".$vwsizes."' itemprop='url' src='".$size_full."' srcset='".$srcset."' alt='".$alt."' width='".$width_full."' height='".$height_full."' />";
			$renderedImg .= "<meta itemprop='width' content='".$width_full."' />";
			$renderedImg .= "<meta itemprop='height' content='".$height_full."' />";
			$renderedImg .= "</div>";
		else :
			$renderedImg = "<img sizes='".$vwsizes."' itemprop='url' class='".$class."' src='".$size_full."' srcset='".$srcset."' alt='".$alt."' width='".$width_full."' height='".$height_full."' ".$option." />";
		endif;

		return $renderedImg;
	else :
		return $alt;

	endif;
}


/*
 * Crée la taille d'image à la volée
 */
function createMissingImgSize($img_id, $size) {

	// Cas particulier de la taille full uploadée
	if ( $size == "full" ) :
		return wp_get_attachment_image_src( $img_id, $size );

	else :
		$size_exist = image_get_intermediate_size( $img_id, $size );

		if ( $size_exist && !isset($GLOBALS["forceRegenerate"]) ) : // La taille existe déjà
			return wp_get_attachment_image_src( $img_id, $size );

		else : // si la taille n'existe

	    $upload_dir = wp_upload_dir();
			$image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], wp_get_attachment_url($img_id));

			$info_size = get_image_size($size);

	    require_once(ABSPATH . 'wp-admin/includes/screen.php'); // Hack pour Smush.it nécessitant get_current_screen()

			$new_img = image_make_intermediate_size($image_path, $info_size["width"], $info_size["height"], $info_size["crop"]);
			if ( $new_img ) :
				$metadata = wp_get_attachment_metadata($img_id);
				if ( !$metadata ) :
					$metadata = wp_generate_attachment_metadata($img_id, $image_path);
				endif;
			  $metadata['sizes'][$size] = $new_img;
			  wp_update_attachment_metadata($img_id, $metadata);
				return wp_get_attachment_image_src( $img_id, $size );

			else :
				return false;

	    endif;
		endif;
	endif;
}

function get_image_size( $size ) {
	$sizes = get_image_sizes();
	if ( isset($sizes[$size]) ) :
		return $sizes[ $size ];
	endif;
	return false;
}

function get_image_sizes() {
	global $_wp_additional_image_sizes;

	$sizes = array();
	foreach ( get_intermediate_image_sizes() as $_size ) :
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) :
			$sizes[ $_size ]['width']  = get_option("{$_size}_size_w");
			$sizes[ $_size ]['height'] = get_option("{$_size}_size_h");
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );

    elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) :
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		endif;
	endforeach;

	return $sizes;
}


// PEUTETRE A METTRE DANS LA PARTIE ADMIN ET VOIR COMMENT TOTALEMENT SUPPRIMER CETTE OPTION
//add_action('admin_init', 'wpb_imagelink_setup', 10);
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );

	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
