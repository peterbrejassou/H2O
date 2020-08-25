<?php
// Ajoute une feuille de styles  dans l'admin
add_theme_support('editor-styles');
add_editor_style(get_stylesheet_directory_uri().'/assets/css/admin-editor.css');

// FILTRES LES BLOCS AUTORISES SUR LE SITE
// cf. https://rudrastyh.com/gutenberg/remove-default-blocks.html
// -----------------------------------------------------------------------------
add_filter( 'allowed_block_types', 'nb_allowed_block_types', 10, 2 );
function nb_allowed_block_types($allowed_blocks, $post) {
	$allowed_blocks = array(

	// Blocs spécifiques du theme 
    /*'acf/slide-video',
    'acf/title',*/

    // Blocs communs
    //'core/heading',
		'core/paragraph',
  	//'core/image',
  	//'core/gallery',
		//'core/list',
		//'core/quote',
		// 'core/audio',
		//'core/cover-image',
		//'core/file',
		//'core/video',
		//'core/media',

    // Mise en forme
    //'core/table',
    // 'core/verse',
    // 'core/code',
    // 'core/freeform',
    // 'core/html',
    // 'core/preformatted',
    // 'core/pullquote',

    // Mise en page
    //'core/button',
    //'core/columns',
    //'core/media-text',
    // 'core/more',
    // 'core/nextpage',
    // 'core/separator',
    // 'core/spacer',

    // Widgets
    // 'core/shortcode',
    // 'core/archives',
    // 'core/categories',
    // 'core/latest-comments',
    // 'core/latest-posts',

    // Contenus embarqués
    // 'core/embed',
    // 'core-embed/youtube',
    // 'core-embed/facebook',
    // 'core-embed/twitter',
    // 'core-embed/instagram',
    // core-embed/wordpress
    // core-embed/soundcloud
    // core-embed/spotify
    // core-embed/flickr
    // core-embed/vimeo
    // core-embed/animoto
    // core-embed/cloudup
    // core-embed/collegehumor
    // core-embed/dailymotion
    // core-embed/funnyordie
    // core-embed/hulu
    // core-embed/imgur
    // core-embed/issuu
    // core-embed/kickstarter
    // core-embed/meetup-com
    // core-embed/mixcloud
    // core-embed/photobucket
    // core-embed/polldaddy
    // core-embed/reddit
    // core-embed/reverbnation
    // core-embed/screencast
    // core-embed/scribd
    // core-embed/slideshare
    // core-embed/smugmug
    // core-embed/speaker
    // core-embed/ted
    // core-embed/tumblr
    // core-embed/videopress
    // core-embed/wordpress-tv
	);

	return $allowed_blocks;
}


// NETTOYAGE DES OPTIONS DE LA SIDEBAR
// cf. https://joseph-dickson.com/removing-specific-gutenberg-core-blocks-and-options/
// -----------------------------------------------------------------------------

// PALETTE DE COULEURS
// -----------------------------------------------------------------------------
// Désactive la palette de couleurs
add_theme_support( 'disable-custom-colors' );

// Supprime la palette de couleur
add_theme_support( 'editor-color-palette' );

// FONTS
// -----------------------------------------------------------------------------
// Désactive les tailles de typos
add_theme_support( 'disable-custom-font-sizes' );

// Crée une liste de choix de typos adaptée à la charte du site
add_theme_support( 'editor-font-sizes',
  array(
  	array(
  		'name' => "Petit",
  		'shortName' => 'S',
  		'size' => 13,
  		'slug' => 'small'
  	),
  	array(
    	'name' => 'Standard',
    	'shortName' => 'D',
    	'size' => 16,
    	'slug' => 'standard'
  	),
  	array(
    	'name' => 'Moyen',
    	'shortName' => 'M',
    	'size' => 20,
    	'slug' => 'medium'
  	),
  	array(
  		'name' => 'Grand',
  		'shortName' => 'L',
  		'size' => 24,
  		'slug' => 'large'
  	),
  	array(
  		'name' => 'Très grand',
    	'shortName' => 'XL',
  		'size' => 28,
  		'slug' => 'extra-large'
  	)
  )
);
