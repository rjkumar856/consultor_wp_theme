<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.10
 */

// Logo
if (consultor_is_on(consultor_get_theme_option('logo_in_footer'))) {
	$consultor_logo_image = '';
	if (consultor_is_on(consultor_get_theme_option('logo_retina_enabled')) && consultor_get_retina_multiplier(2) > 1)
		$consultor_logo_image = consultor_get_theme_option( 'logo_footer_retina' );
	if (empty($consultor_logo_image)) 
		$consultor_logo_image = consultor_get_theme_option( 'logo_footer' );
	$consultor_logo_text   = get_bloginfo( 'name' );
	if (!empty($consultor_logo_image) || !empty($consultor_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($consultor_logo_image)) {
					$consultor_attr = consultor_getimagesize($consultor_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($consultor_logo_image).'" class="logo_footer_image" alt=""'.(!empty($consultor_attr[3]) ? ' ' . wp_kses_data($consultor_attr[3]) : '').'></a>' ;
				} else if (!empty($consultor_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($consultor_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>