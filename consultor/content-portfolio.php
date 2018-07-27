<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_blog_style = explode('_', consultor_get_theme_option('blog_style'));
$consultor_columns = empty($consultor_blog_style[1]) ? 2 : max(2, $consultor_blog_style[1]);
$consultor_post_format = get_post_format();
$consultor_post_format = empty($consultor_post_format) ? 'standard' : str_replace('post-format-', '', $consultor_post_format);
$consultor_animation = consultor_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($consultor_columns).' post_format_'.esc_attr($consultor_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!consultor_is_off($consultor_animation) ? ' data-animation="'.esc_attr(consultor_get_animation_classes($consultor_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$consultor_image_hover = consultor_get_theme_option('image_hover');
	// Featured image
	consultor_show_post_featured(array(
		'thumb_size' => consultor_get_thumb_size(strpos(consultor_get_theme_option('body_style'), 'full')!==false || $consultor_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $consultor_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $consultor_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>