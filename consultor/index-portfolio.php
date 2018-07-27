<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

consultor_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	consultor_show_layout(get_query_var('blog_archive_start'));

	$consultor_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$consultor_sticky_out = consultor_get_theme_option('sticky_style')=='columns' 
							&& is_array($consultor_stickies) && count($consultor_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$consultor_cat = consultor_get_theme_option('parent_cat');
	$consultor_post_type = consultor_get_theme_option('post_type');
	$consultor_taxonomy = consultor_get_post_type_taxonomy($consultor_post_type);
	$consultor_show_filters = consultor_get_theme_option('show_filters');
	$consultor_tabs = array();
	if (!consultor_is_off($consultor_show_filters)) {
		$consultor_args = array(
			'type'			=> $consultor_post_type,
			'child_of'		=> $consultor_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $consultor_taxonomy,
			'pad_counts'	=> false
		);
		$consultor_portfolio_list = get_terms($consultor_args);
		if (is_array($consultor_portfolio_list) && count($consultor_portfolio_list) > 0) {
			$consultor_tabs[$consultor_cat] = esc_html__('All', 'consultor');
			foreach ($consultor_portfolio_list as $consultor_term) {
				if (isset($consultor_term->term_id)) $consultor_tabs[$consultor_term->term_id] = $consultor_term->name;
			}
		}
	}
	if (count($consultor_tabs) > 0) {
		$consultor_portfolio_filters_ajax = true;
		$consultor_portfolio_filters_active = $consultor_cat;
		$consultor_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters consultor_tabs consultor_tabs_ajax">
			<ul class="portfolio_titles consultor_tabs_titles">
				<?php
				foreach ($consultor_tabs as $consultor_id=>$consultor_title) {
					?><li><a href="<?php echo esc_url(consultor_get_hash_link(sprintf('#%s_%s_content', $consultor_portfolio_filters_id, $consultor_id))); ?>" data-tab="<?php echo esc_attr($consultor_id); ?>"><?php echo esc_html($consultor_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$consultor_ppp = consultor_get_theme_option('posts_per_page');
			if (consultor_is_inherit($consultor_ppp)) $consultor_ppp = '';
			foreach ($consultor_tabs as $consultor_id=>$consultor_title) {
				$consultor_portfolio_need_content = $consultor_id==$consultor_portfolio_filters_active || !$consultor_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $consultor_portfolio_filters_id, $consultor_id)); ?>"
					class="portfolio_content consultor_tabs_content"
					data-blog-template="<?php echo esc_attr(consultor_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(consultor_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($consultor_ppp); ?>"
					data-post-type="<?php echo esc_attr($consultor_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($consultor_taxonomy); ?>"
					data-cat="<?php echo esc_attr($consultor_id); ?>"
					data-parent-cat="<?php echo esc_attr($consultor_cat); ?>"
					data-need-content="<?php echo (false===$consultor_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($consultor_portfolio_need_content) 
						consultor_show_portfolio_posts(array(
							'cat' => $consultor_id,
							'parent_cat' => $consultor_cat,
							'taxonomy' => $consultor_taxonomy,
							'post_type' => $consultor_post_type,
							'page' => 1,
							'sticky' => $consultor_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		consultor_show_portfolio_posts(array(
			'cat' => $consultor_cat,
			'parent_cat' => $consultor_cat,
			'taxonomy' => $consultor_taxonomy,
			'post_type' => $consultor_post_type,
			'page' => 1,
			'sticky' => $consultor_sticky_out
			)
		);
	}

	consultor_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>