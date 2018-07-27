<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

$consultor_args = get_query_var('consultor_logo_args');

// Site logo
$consultor_logo_type   = isset($consultor_args['type']) ? $consultor_args['type'] : '';
$consultor_logo_image  = consultor_get_logo_image($consultor_logo_type);
$consultor_logo_text   = consultor_is_on(consultor_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$consultor_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($consultor_logo_image) || !empty($consultor_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($consultor_logo_image)) {
			if (empty($consultor_logo_type) && function_exists('the_custom_logo') && (int) $consultor_logo_image > 0) {
				the_custom_logo();
			} else {
				$consultor_attr = consultor_getimagesize($consultor_logo_image);
				echo '<img src="'.esc_url($consultor_logo_image).'" alt=""'.(!empty($consultor_attr[3]) ? ' '.wp_kses_data($consultor_attr[3]) : '').'>';
			}
		} else {
			consultor_show_layout(consultor_prepare_macros($consultor_logo_text), '<span class="logo_text">', '</span>');
			consultor_show_layout(consultor_prepare_macros($consultor_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>