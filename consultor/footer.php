<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

						// Widgets area inside page content
						consultor_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					consultor_create_widgets_area('widgets_below_page');

					$consultor_body_style = consultor_get_theme_option('body_style');
					if ($consultor_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$consultor_footer_type = consultor_get_theme_option("footer_type");
			if ($consultor_footer_type == 'custom' && !consultor_is_layouts_available())
				$consultor_footer_type = 'default';
			get_template_part( "templates/footer-{$consultor_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (consultor_is_on(consultor_get_theme_option('debug_mode')) && consultor_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(consultor_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>