<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('consultor_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'consultor_cf7_theme_setup9', 9 );
	function consultor_cf7_theme_setup9() {
		
		if (consultor_exists_cf7()) {
			add_action( 'wp_enqueue_scripts', 								'consultor_cf7_frontend_scripts', 1100 );
			add_filter( 'consultor_filter_merge_styles',						'consultor_cf7_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'consultor_filter_tgmpa_required_plugins',			'consultor_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'consultor_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('consultor_filter_tgmpa_required_plugins',	'consultor_cf7_tgmpa_required_plugins');
	function consultor_cf7_tgmpa_required_plugins($list=array()) {
		if (consultor_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> consultor_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
			// CF7 extension - datepicker 
			if (!CONSULTOR_THEME_FREE) {
				$params = array(
					'name' 		=> esc_html__('Contact Form 7 Datepicker', 'consultor'),
					'slug' 		=> 'contact-form-7-datepicker',
					'required' 	=> false
				);
				$path = consultor_get_file_dir('plugins/contact-form-7/contact-form-7-datepicker.zip');
				if ($path != '')
					$params['source'] = $path;
				$list[] = $params;
			}
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'consultor_exists_cf7' ) ) {
	function consultor_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'consultor_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'consultor_cf7_frontend_scripts', 1100 );
	function consultor_cf7_frontend_scripts() {
		if (consultor_is_on(consultor_get_theme_option('debug_mode')) && consultor_get_file_dir('plugins/contact-form-7/contact-form-7.css')!='')
			wp_enqueue_style( 'consultor-contact-form-7',  consultor_get_file_url('plugins/contact-form-7/contact-form-7.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'consultor_cf7_merge_styles' ) ) {
	//Handler of the add_filter('consultor_filter_merge_styles', 'consultor_cf7_merge_styles');
	function consultor_cf7_merge_styles($list) {
		$list[] = 'plugins/contact-form-7/contact-form-7.css';
		return $list;
	}
}
?>