<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$consultor_post_format = get_post_format();
$consultor_post_format = empty($consultor_post_format) ? 'standard' : str_replace('post-format-', '', $consultor_post_format);
$consultor_animation = consultor_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($consultor_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($consultor_post_format) ); ?>
	<?php echo (!consultor_is_off($consultor_animation) ? ' data-animation="'.esc_attr(consultor_get_animation_classes($consultor_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	consultor_show_post_featured(array(
		'thumb_size' => consultor_get_thumb_size($consultor_columns==1 ? 'big' : ($consultor_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($consultor_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(), 'sticky', $consultor_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>