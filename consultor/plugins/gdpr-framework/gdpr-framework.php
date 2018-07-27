<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('consultor_gdpr_theme_setup9')) {
	add_action( 'after_setup_theme', 'consultor_gdpr_theme_setup9', 9 );
	function consultor_gdpr_theme_setup9() {
		if (consultor_exists_gdpr()) {
			add_filter( 'consultor_filter_merge_styles',					'consultor_gdpr_merge_styles');
		}
		if (is_admin()) {
			add_filter( 'consultor_filter_tgmpa_required_plugins',		'consultor_gdpr_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'consultor_gdpr_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('consultor_filter_tgmpa_required_plugins',	'consultor_gdpr_tgmpa_required_plugins');
	function consultor_gdpr_tgmpa_required_plugins($list=array()) {
		if (consultor_storage_isset('required_plugins', 'gdpr-framework')) {
			$list[] = array(
				'name' 		=> consultor_storage_get_array('required_plugins', 'gdpr-framework'),
				'slug' 		=> 'gdpr-framework',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'consultor_exists_gdpr' ) ) {
	function consultor_exists_gdpr() {
		return function_exists('__gdpr_load_plugin') || defined('GDPR_VERSION');
	}
}


