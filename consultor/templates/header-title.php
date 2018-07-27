<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

// Page (category, tag, archive, author) title

if ( consultor_need_page_title() ) {
	consultor_sc_layouts_showed('title', true);
	consultor_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								consultor_show_post_meta(apply_filters('consultor_filter_post_meta_args', array(
									'components' => 'categories,date,counters,edit',
									'counters' => 'views,comments,likes',
									'seo' => true
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$consultor_blog_title = consultor_get_blog_title();
							$consultor_blog_title_text = $consultor_blog_title_class = $consultor_blog_title_link = $consultor_blog_title_link_text = '';
							if (is_array($consultor_blog_title)) {
								$consultor_blog_title_text = $consultor_blog_title['text'];
								$consultor_blog_title_class = !empty($consultor_blog_title['class']) ? ' '.$consultor_blog_title['class'] : '';
								$consultor_blog_title_link = !empty($consultor_blog_title['link']) ? $consultor_blog_title['link'] : '';
								$consultor_blog_title_link_text = !empty($consultor_blog_title['link_text']) ? $consultor_blog_title['link_text'] : '';
							} else
								$consultor_blog_title_text = $consultor_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($consultor_blog_title_class); ?>"><?php
								$consultor_top_icon = consultor_get_category_icon();
								if (!empty($consultor_top_icon)) {
									$consultor_attr = consultor_getimagesize($consultor_top_icon);
									?><img src="<?php echo esc_url($consultor_top_icon); ?>" alt="" <?php if (!empty($consultor_attr[3])) consultor_show_layout($consultor_attr[3]);?>><?php
								}
								echo wp_kses_data($consultor_blog_title_text);
							?></h1>
							<?php
							if (!empty($consultor_blog_title_link) && !empty($consultor_blog_title_link_text)) {
								?><a href="<?php echo esc_url($consultor_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($consultor_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'consultor_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>