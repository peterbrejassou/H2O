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
		<a href="<?php the_permalink();?>"><h2><?php the_title();?></h2></a>
		<?php if(is_single()):?>
		<?php the_content();?>
		<?php else:?>
		<?php the_excerpt();?>
		<?php endif;?>
		<div class="entry-meta">
			<?php
			$time_string = 'Le <time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			echo sprintf( $time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( DATE_W3C ) ),
				esc_html( get_the_modified_date() )
			);
			echo " par ".esc_html( get_the_author() );
			?>
		</div><!-- .entry-meta -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
