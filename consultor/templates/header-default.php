<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */


$consultor_header_css = $consultor_header_image = '';
$consultor_header_video = consultor_get_header_video();
if (true || empty($consultor_header_video)) {
	$consultor_header_image = get_header_image();
	if (consultor_trx_addons_featured_image_override()) $consultor_header_image = consultor_get_current_mode_image($consultor_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($consultor_header_image) || !empty($consultor_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($consultor_header_video!='') echo ' with_bg_video';
					if ($consultor_header_image!='') echo ' '.esc_attr(consultor_add_inline_css_class('background-image: url('.esc_url($consultor_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (consultor_is_on(consultor_get_theme_option('header_fullheight'))) echo ' header_fullheight consultor-full-height';
					?> scheme_<?php echo esc_attr(consultor_is_inherit(consultor_get_theme_option('header_scheme')) 
													? consultor_get_theme_option('color_scheme') 
													: consultor_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($consultor_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (consultor_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Header for single posts
	get_template_part( 'templates/header-single' );

?></header>