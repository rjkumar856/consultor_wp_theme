<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.10
 */


// Socials
if ( consultor_is_on(consultor_get_theme_option('socials_in_footer')) && ($consultor_output = consultor_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php consultor_show_layout($consultor_output); ?>
		</div>
	</div>
	<?php
}
?>