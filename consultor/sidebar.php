<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

if (consultor_sidebar_present()) {
	ob_start();
	$consultor_sidebar_name = consultor_get_theme_option('sidebar_widgets');
	consultor_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($consultor_sidebar_name) ) {
		dynamic_sidebar($consultor_sidebar_name);
	}
	$consultor_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($consultor_out)) {
		$consultor_sidebar_position = consultor_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($consultor_sidebar_position); ?> widget_area<?php if (!consultor_is_inherit(consultor_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(consultor_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'consultor_action_before_sidebar' );
				consultor_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $consultor_out));
				do_action( 'consultor_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>