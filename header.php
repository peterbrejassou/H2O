<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Susty
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>

	<!-- Matomo -->
	<script type="text/javascript">
		var _paq = window._paq || [];
		/* tracker methods like "setCustomDimension" should be called before "trackPageView" */
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		(function() {
			var u="//matomo-ecv.ihaveagreen.fr/";
			_paq.push(['setTrackerUrl', u+'piwik.php']);
			_paq.push(['setSiteId', '1']);
			var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
			g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
		})();
	</script>
	<!-- End Matomo Code -->
</head>

<body <?php body_class(); ?>>

<div id="page">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'susty' ); ?></a>
	<a class="skip-link screen-reader-text" href="#menu"><?php esc_html_e( 'Menu', 'susty' ); ?></a>
	<header id="masthead">
		<div class="wrapper">
			<a href="<?= get_home_url(); ?>"><img src="<?php the_field("logo_h2o", "options"); ?>" alt="Logo H2O"></a>
			<div id="menu">
				<?= ihag_menu('primary'); ?>
			</div>
			<button id="btnMenu" class="btn-menu hidden">Menu</button>
		</div>

		<div id="menu-mobile" class="hidden">
				<?= ihag_menu('primary'); ?>
				<p id="close-menu-mobile">Fermer</p>
			</div>
	</header>

	<div id="content-site">
