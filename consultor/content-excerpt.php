<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_post_format = get_post_format();
$consultor_post_format = empty($consultor_post_format) ? 'standard' : str_replace('post-format-', '', $consultor_post_format);
$consultor_animation = consultor_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($consultor_post_format) ); ?>
	<?php echo (!consultor_is_off($consultor_animation) ? ' data-animation="'.esc_attr(consultor_get_animation_classes($consultor_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	consultor_show_post_featured(array( 'thumb_size' => consultor_get_thumb_size( strpos(consultor_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));

	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header"><div class="post_meta_cat">
			<?php

			do_action('consultor_action_before_post_meta');

			// Post meta
			$consultor_components = consultor_is_inherit(consultor_get_theme_option_from_meta('meta_parts'))
				? 'categories'
				: consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts'));


			if (!empty($consultor_components))
				consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
						'components' => $consultor_components,
						'seo' => false
					), 'excerpt', 1)
				);
			?></div><?php

			do_action('consultor_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('consultor_action_before_post_meta'); 

			// Post meta
			$consultor_components = consultor_is_inherit(consultor_get_theme_option_from_meta('meta_parts')) 
										? 'counters'
										: consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts'));
			$consultor_counters = consultor_is_inherit(consultor_get_theme_option_from_meta('counters')) 
										? 'comments'
										: consultor_array_get_keys_by_value(consultor_get_theme_option('counters'));

			if (!empty($consultor_components))
				consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
					'components' => $consultor_components,
					'counters' => $consultor_counters,
					'seo' => false
					), 'excerpt', 1)
				);
			?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
				// Translators: Add the author's name in the <span>
				printf( esc_html__( 'by %s', 'consultor' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
				?></a>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (consultor_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'consultor' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'consultor' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$consultor_show_learn_more = !in_array($consultor_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $consultor_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'consultor'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>