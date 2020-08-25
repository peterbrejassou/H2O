<?php
function my_plugin_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'horizons',
                'title' => __( 'Les Horizons', 'horizon' ),
                'icon'  => 'star-empty'
            ),
        )
    );
}
add_filter( 'block_categories', 'my_plugin_block_categories', 10, 2 );


add_action('acf/init', 'acf_init_blocs');
function acf_init_blocs() {
    if( function_exists('acf_register_block_type') ) {
        acf_register_block_type(
            array(
                'name'				    => 'article-1-5',
                'title'				    => __('Article 5+1'),
                'description'		    => __('Article 5+1'),
                'placeholder'		    => __('Article 5+1'),
                'render_template'	    => 'template-parts/block/article-1-5.php',
                'category'			    => 'horizons',
                'mode'                  => 'edit',
                'icon'				    => 'excerpt-view',
                'keywords'			    => array('home', 'accueil', '5', 'main'),
                'supports'	            => array(
                                            'align'		=> false,
                                        ),
            )
        );
    }
}