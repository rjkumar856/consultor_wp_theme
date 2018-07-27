<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_post_id    = get_the_ID();
$consultor_post_date  = consultor_get_date();
$consultor_post_title = get_the_title();
$consultor_post_link  = get_permalink();
$consultor_post_author_id   = get_the_author_meta('ID');
$consultor_post_author_name = get_the_author_meta('display_name');
$consultor_post_author_url  = get_author_posts_url($consultor_post_author_id, '');

$consultor_args = get_query_var('consultor_args_widgets_posts');
$consultor_show_date = isset($consultor_args['show_date']) ? (int) $consultor_args['show_date'] : 1;
$consultor_show_image = isset($consultor_args['show_image']) ? (int) $consultor_args['show_image'] : 1;
$consultor_show_author = isset($consultor_args['show_author']) ? (int) $consultor_args['show_author'] : 1;
$consultor_show_counters = isset($consultor_args['show_counters']) ? (int) $consultor_args['show_counters'] : 1;
$consultor_show_categories = isset($consultor_args['show_categories']) ? (int) $consultor_args['show_categories'] : 1;

$consultor_output = consultor_storage_get('consultor_output_widgets_posts');

$consultor_post_counters_output = '';
if ( $consultor_show_counters ) {
	$consultor_post_counters_output = '<span class="post_info_item post_info_counters">'
								. consultor_get_post_counters('comments')
							. '</span>';
}


$consultor_output .= '<article class="post_item with_thumb">';

if ($consultor_show_image) {
	$consultor_post_thumb = get_the_post_thumbnail($consultor_post_id, consultor_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($consultor_post_thumb) $consultor_output .= '<div class="post_thumb">' . ($consultor_post_link ? '<a href="' . esc_url($consultor_post_link) . '">' : '') . ($consultor_post_thumb) . ($consultor_post_link ? '</a>' : '') . '</div>';
}

$consultor_output .= '<div class="post_content">'
			. ($consultor_show_categories 
					? '<div class="post_categories">'
						. consultor_get_post_categories()
						. $consultor_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($consultor_post_link ? '<a href="' . esc_url($consultor_post_link) . '">' : '') . ($consultor_post_title) . ($consultor_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('consultor_filter_get_post_info', 
								'<div class="post_info">'
									. ($consultor_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($consultor_post_link ? '<a href="' . esc_url($consultor_post_link) . '" class="post_info_date">' : '') 
											. esc_html($consultor_post_date) 
											. ($consultor_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($consultor_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'consultor') . ' ' 
											. ($consultor_post_link ? '<a href="' . esc_url($consultor_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($consultor_post_author_name) 
											. ($consultor_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$consultor_show_categories && $consultor_post_counters_output
										? $consultor_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
consultor_storage_set('consultor_output_widgets_posts', $consultor_output);
?>