<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.10
 */

// Footer menu
$consultor_menu_footer = consultor_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($consultor_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php consultor_show_layout($consultor_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>