<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_seo = consultor_is_on(consultor_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($consultor_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="http://schema.org/<?php echo esc_attr(consultor_get_markup_schema()); ?>" 
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php echo esc_attr(get_the_title()); ?>"<?php
		}
?>><?php

	do_action('consultor_action_before_post_data'); 

	// Structured data snippets
	if ($consultor_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( consultor_is_off(consultor_get_theme_option('hide_featured_on_single'))
			&& !consultor_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('consultor_action_before_post_featured'); 
		consultor_show_post_featured();
		do_action('consultor_action_after_post_featured'); 
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="http://schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!consultor_sc_layouts_showed('title') || !consultor_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('consultor_action_before_post_title'); 
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if (!consultor_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($consultor_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			if (!consultor_sc_layouts_showed('postmeta') && consultor_is_on(consultor_get_theme_option('show_post_meta'))) {
				consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
					'components' => consultor_array_get_keys_by_value(consultor_get_theme_option('meta_parts')),
					'counters' => consultor_array_get_keys_by_value(consultor_get_theme_option('counters')),
					'seo' => consultor_is_on(consultor_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?><a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
				// Translators: Add the author's name in the <span>
				printf( esc_html__( 'by %s', 'consultor' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
				?></a>
		</div><!-- .post_header -->
		<?php
		do_action('consultor_action_after_post_title'); 
	}

	do_action('consultor_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content( );

		do_action('consultor_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'consultor' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'consultor' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('consultor_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php

			// Share
			if (consultor_is_on(consultor_get_theme_option('show_share_links'))) {
				consultor_show_share_links(array(
					'type' => 'block',
					'caption' => 'Be Sociable, Share!',
					'before' => '<div class="post_meta_item post_share">',
					'after' => '</div>'
				));
			}

				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"> ', ', ', '</span>' );


			?></div><?php

			do_action('consultor_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('consultor_action_after_post_content'); 

	// Author bio.
	if ( consultor_get_theme_option('show_author_info')==1 && is_single() && !is_attachment() && get_the_author_meta( 'description' ) ) {	// && is_multi_author()
		do_action('consultor_action_before_post_author'); 
		get_template_part( 'templates/author-bio' );
		do_action('consultor_action_after_post_author'); 
	}

	do_action('consultor_action_after_post_data'); 
	?>
</article>
