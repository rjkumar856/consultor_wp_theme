<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.31
 */

get_header();

// If front-page is a static page
if (get_option('show_on_front') == 'page') {

	// If Front Page Builder is enabled - display sections
	if (consultor_is_on(consultor_get_theme_option('front_page_enabled'))) {

		if ( have_posts() ) the_post();

		$consultor_sections = consultor_array_get_keys_by_value(consultor_get_theme_option('front_page_sections'), 1, false);
		if (is_array($consultor_sections)) {
			foreach ($consultor_sections as $consultor_section) {
				get_template_part("front-page/section", $consultor_section);
			}
		}
	
	// Else if this page is blog archive
	} else if (is_page_template('blog.php')) {
		get_template_part('blog');

	// Else - display native page content
	} else {
		get_template_part('page');
	}

// Else get index template to show posts
} else {
	get_template_part('index');
}

get_footer();
?>