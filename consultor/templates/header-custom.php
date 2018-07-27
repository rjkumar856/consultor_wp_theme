<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.06
 */

$consultor_header_css = $consultor_header_image = '';
$consultor_header_video = consultor_get_header_video();
if (true || empty($consultor_header_video)) {
	$consultor_header_image = get_header_image();
	if (consultor_trx_addons_featured_image_override()) $consultor_header_image = consultor_get_current_mode_image($consultor_header_image);
}

$consultor_header_id = str_replace('header-custom-', '', consultor_get_theme_option("header_style"));
if ((int) $consultor_header_id == 0) {
	$consultor_header_id = consultor_get_post_id(array(
												'name' => $consultor_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$consultor_header_id = apply_filters('consultor_filter_get_translated_layout', $consultor_header_id);
}
$consultor_header_meta = get_post_meta($consultor_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($consultor_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($consultor_header_id)));
				echo !empty($consultor_header_image) || !empty($consultor_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($consultor_header_video!='') 
					echo ' with_bg_video';
				if ($consultor_header_image!='') 
					echo ' '.esc_attr(consultor_add_inline_css_class('background-image: url('.esc_url($consultor_header_image).');'));
				if (!empty($consultor_header_meta['margin']) != '') 
					echo ' '.esc_attr(consultor_add_inline_css_class('margin-bottom: '.esc_attr(consultor_prepare_css_value($consultor_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (consultor_is_on(consultor_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight consultor-full-height';
				?> scheme_<?php echo esc_attr(consultor_is_inherit(consultor_get_theme_option('header_scheme')) 
												? consultor_get_theme_option('color_scheme') 
												: consultor_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($consultor_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('consultor_action_show_layout', $consultor_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>