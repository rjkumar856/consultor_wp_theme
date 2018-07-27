<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$consultor_content = '';
$consultor_blog_archive_mask = '%%CONTENT%%';
$consultor_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $consultor_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($consultor_content = apply_filters('the_content', get_the_content())) != '') {
		if (($consultor_pos = strpos($consultor_content, $consultor_blog_archive_mask)) !== false) {
			$consultor_content = preg_replace('/(\<p\>\s*)?'.$consultor_blog_archive_mask.'(\s*\<\/p\>)/i', $consultor_blog_archive_subst, $consultor_content);
		} else
			$consultor_content .= $consultor_blog_archive_subst;
		$consultor_content = explode($consultor_blog_archive_mask, $consultor_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) consultor_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$consultor_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$consultor_args = consultor_query_add_posts_and_cats($consultor_args, '', consultor_get_theme_option('post_type'), consultor_get_theme_option('parent_cat'));
$consultor_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($consultor_page_number > 1) {
	$consultor_args['paged'] = $consultor_page_number;
	$consultor_args['ignore_sticky_posts'] = true;
}
$consultor_ppp = consultor_get_theme_option('posts_per_page');
if ((int) $consultor_ppp != 0)
	$consultor_args['posts_per_page'] = (int) $consultor_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($consultor_args);


// Add internal query vars in the new query!
if (is_array($consultor_content) && count($consultor_content) == 2) {
	set_query_var('blog_archive_start', $consultor_content[0]);
	set_query_var('blog_archive_end', $consultor_content[1]);
}

get_template_part('index');
?>