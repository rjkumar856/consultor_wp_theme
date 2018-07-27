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
$consultor_columns = empty($consultor_blog_style[1]) ? 1 : max(1, $consultor_blog_style[1]);
$consultor_expanded = !consultor_sidebar_present() && consultor_is_on(consultor_get_theme_option('expand_content'));
$consultor_post_format = get_post_format();
$consultor_post_format = empty($consultor_post_format) ? 'standard' : str_replace('post-format-', '', $consultor_post_format);
$consultor_animation = consultor_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($consultor_columns).' post_format_'.esc_attr($consultor_post_format) ); ?>
	<?php echo (!consultor_is_off($consultor_animation) ? ' data-animation="'.esc_attr(consultor_get_animation_classes($consultor_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($consultor_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	consultor_show_post_featured( array(
											'class' => $consultor_columns == 1 ? 'consultor-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => consultor_get_thumb_size(
																	strpos(consultor_get_theme_option('body_style'), 'full')!==false
																		? ( $consultor_columns > 1 ? 'huge' : 'original' )
																		: (	$consultor_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php

				do_action('consultor_action_before_post_meta');

				// Post meta
				$consultor_components = consultor_is_inherit(consultor_get_theme_option_from_meta('meta_parts'))
					? 'categories'.($consultor_columns < 3 ? '' : '').($consultor_columns == 1 ? '' : '')
					: consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts'));
				$consultor_counters = consultor_is_inherit(consultor_get_theme_option_from_meta('counters'))
					? ''
					: consultor_array_get_keys_by_value(consultor_get_theme_option('counters'));
				$consultor_post_meta = empty($consultor_components)
					? ''
					: consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
							'components' => $consultor_components,
							'counters' => $consultor_counters,
							'seo' => false,
							'echo' => false
						), $consultor_blog_style[0], $consultor_columns)
					);
				consultor_show_layout($consultor_post_meta);

			do_action('consultor_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('consultor_action_before_post_meta'); 

			// Post meta
			$consultor_components = consultor_is_inherit(consultor_get_theme_option_from_meta('meta_parts')) 
										? ''.($consultor_columns < 3 ? ',counters' : '').($consultor_columns == 1 ? '' : '')
										: consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts'));
			$consultor_counters = consultor_is_inherit(consultor_get_theme_option_from_meta('counters')) 
										? 'comments'
										: consultor_array_get_keys_by_value(consultor_get_theme_option('counters'));
			$consultor_post_meta = empty($consultor_components) 
										? '' 
										: consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
												'components' => $consultor_components,
												'counters' => $consultor_counters,
												'seo' => false,
												'echo' => false
												), $consultor_blog_style[0], $consultor_columns)
											);
			consultor_show_layout($consultor_post_meta);
		?><a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
					// Translators: Add the author's name in the <span>
					printf( esc_html__( 'by %s', 'consultor' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
					?></a>
			</div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$consultor_show_learn_more = !in_array($consultor_post_format, array('link', 'aside', 'status', 'quote'));
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
				consultor_show_layout($consultor_post_meta);
			}
			// More button
			if ( $consultor_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'consultor'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>