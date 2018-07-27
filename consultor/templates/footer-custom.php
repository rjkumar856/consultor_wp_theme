<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.10
 */

$consultor_footer_scheme =  consultor_is_inherit(consultor_get_theme_option('footer_scheme')) ? consultor_get_theme_option('color_scheme') : consultor_get_theme_option('footer_scheme');
$consultor_footer_id = str_replace('footer-custom-', '', consultor_get_theme_option("footer_style"));
if ((int) $consultor_footer_id == 0) {
	$consultor_footer_id = consultor_get_post_id(array(
												'name' => $consultor_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$consultor_footer_id = apply_filters('consultor_filter_get_translated_layout', $consultor_footer_id);
}
$consultor_footer_meta = get_post_meta($consultor_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($consultor_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($consultor_footer_id))); 
						if (!empty($consultor_footer_meta['margin']) != '') 
							echo ' '.esc_attr(consultor_add_inline_css_class('margin-top: '.consultor_prepare_css_value($consultor_footer_meta['margin']).';'));
						?> scheme_<?php echo esc_attr($consultor_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('consultor_action_show_layout', $consultor_footer_id);
	?>
</footer><!-- /.footer_wrap -->
