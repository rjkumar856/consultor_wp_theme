<?php
/**
 * The Gallery template to display posts
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
$consultor_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($consultor_columns).' post_format_'.esc_attr($consultor_post_format) ); ?>
	<?php echo (!consultor_is_off($consultor_animation) ? ' data-animation="'.esc_attr(consultor_get_animation_classes($consultor_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($consultor_image[1]) && !empty($consultor_image[2])) echo intval($consultor_image[1]) .'x' . intval($consultor_image[2]); ?>"
	data-src="<?php if (!empty($consultor_image[0])) echo esc_url($consultor_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$consultor_image_hover = 'icon';	//consultor_get_theme_option('image_hover');
	if (in_array($consultor_image_hover, array('icons', 'zoom'))) $consultor_image_hover = 'dots';
	$consultor_components = consultor_is_inherit(consultor_get_theme_option_from_meta('meta_parts')) 
								? 'categories,date,counters,share'
								: consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts'));
	$consultor_counters = consultor_is_inherit(consultor_get_theme_option_from_meta('counters')) 
								? 'comments'
								: consultor_array_get_keys_by_value(consultor_get_theme_option('counters'));
	consultor_show_post_featured(array(
		'hover' => $consultor_image_hover,
		'thumb_size' => consultor_get_thumb_size( strpos(consultor_get_theme_option('body_style'), 'full')!==false || $consultor_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($consultor_components)
										? consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
											'components' => $consultor_components,
											'counters' => $consultor_counters,
											'seo' => false,
											'echo' => false
											), $consultor_blog_style[0], $consultor_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'consultor') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>