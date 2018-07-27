<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_blog_style = explode('_', consultor_get_theme_option('blog_style'));
$consultor_columns = empty($consultor_blog_style[1]) ? 2 : max(2, $consultor_blog_style[1]);
$consultor_expanded = !consultor_sidebar_present() && consultor_is_on(consultor_get_theme_option('expand_content'));
$consultor_post_format = get_post_format();
$consultor_post_format = empty($consultor_post_format) ? 'standard' : str_replace('post-format-', '', $consultor_post_format);
$consultor_animation = consultor_get_theme_option('blog_animation');
$consultor_components = consultor_is_inherit(consultor_get_theme_option_from_meta('meta_parts')) 
							? 'counters'.($consultor_columns < 3 ? '' : '')
							: consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts'));
$consultor_counters = consultor_is_inherit(consultor_get_theme_option_from_meta('counters')) 
							? 'comments'
							: consultor_array_get_keys_by_value(consultor_get_theme_option('counters'));

?><div class="<?php echo esc_html($consultor_blog_style[0] == 'classic') ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($consultor_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($consultor_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($consultor_columns)
					. ' post_layout_'.esc_attr($consultor_blog_style[0]) 
					. ' post_layout_'.esc_attr($consultor_blog_style[0]).'_'.esc_attr($consultor_columns)
					); ?>
	<?php echo (!consultor_is_off($consultor_animation) ? ' data-animation="'.esc_attr(consultor_get_animation_classes($consultor_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	consultor_show_post_featured( array( 'thumb_size' => consultor_get_thumb_size($consultor_blog_style[0] == 'classic'
													? (strpos(consultor_get_theme_option('body_style'), 'full')!==false 
															? ( $consultor_columns > 2 ? 'big' : 'huge' )
															: (	$consultor_columns > 2
																? ($consultor_expanded ? 'med' : 'small')
																: ($consultor_expanded ? 'big' : 'med')
																)
														)
													: (strpos(consultor_get_theme_option('body_style'), 'full')!==false 
															? ( $consultor_columns > 2 ? 'masonry-big' : 'full' )
															: (	$consultor_columns <= 2 && $consultor_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($consultor_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('consultor_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h5 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );

			do_action('consultor_action_before_post_meta'); 

			// Post meta
			if (!empty($consultor_components))
				consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
					'components' => $consultor_components,
					'counters' => $consultor_counters,
					'seo' => false
					), $consultor_blog_style[0], $consultor_columns)
				);

			do_action('consultor_action_after_post_meta'); 
			?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
				// Translators: Add the author's name in the <span>
				printf( esc_html__( 'by %s', 'consultor' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
				?></a>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$consultor_show_learn_more = false; //!in_array($consultor_post_format, array('link', 'aside', 'status', 'quote'));
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($consultor_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($consultor_post_format == 'quote') {
				if (($quote = consultor_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					consultor_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($consultor_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($consultor_components))
				consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
					'components' => $consultor_components,
					'counters' => $consultor_counters
					), $consultor_blog_style[0], $consultor_columns)
				);
		}
		// More button
		if ( $consultor_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'consultor'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>