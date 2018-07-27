<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

consultor_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	consultor_show_layout(get_query_var('blog_archive_start'));

	$consultor_classes = 'posts_container '
						. (substr(consultor_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap columns_padding_bottom' : 'masonry_wrap');
	$consultor_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$consultor_sticky_out = consultor_get_theme_option('sticky_style')=='columns' 
							&& is_array($consultor_stickies) && count($consultor_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($consultor_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$consultor_sticky_out) {
		if (consultor_get_theme_option('first_post_large') && !is_paged() && !in_array(consultor_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($consultor_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($consultor_sticky_out && !is_sticky()) {
			$consultor_sticky_out = false;
			?></div><div class="<?php echo esc_attr($consultor_classes); ?>"><?php
		}
		get_template_part( 'content', $consultor_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	consultor_show_pagination();

	consultor_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>