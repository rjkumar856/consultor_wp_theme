<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_link = get_permalink();
$consultor_post_format = get_post_format();
$consultor_post_format = empty($consultor_post_format) ? 'standard' : str_replace('post-format-', '', $consultor_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($consultor_post_format) ); ?>><?php
	consultor_show_post_featured(array(
		'thumb_size' => consultor_get_thumb_size( (int) consultor_get_theme_option('related_posts') == 1 ? 'huge' : 'big' ),
		'show_no_image' => false,
		'singular' => false
		)
	);
	?><div class="post_header entry-header"><?php
		if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
			?><span class="post_date"><a href="<?php echo esc_url($consultor_link); ?>"><?php echo wp_kses_data(consultor_get_date()); ?></a></span><?php
		}
		?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url($consultor_link); ?>"><?php the_title(); ?></a></h6>
	</div>
</div>