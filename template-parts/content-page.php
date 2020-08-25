<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Susty
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wrapper'); ?>>
	
	<div>
		<?php
		the_content(); 
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
