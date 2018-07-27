<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('consultor_storage_get')) {
	function consultor_storage_get($var_name, $default='') {
		global $CONSULTOR_STORAGE;
		return isset($CONSULTOR_STORAGE[$var_name]) ? $CONSULTOR_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('consultor_storage_set')) {
	function consultor_storage_set($var_name, $value) {
		global $CONSULTOR_STORAGE;
		$CONSULTOR_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('consultor_storage_empty')) {
	function consultor_storage_empty($var_name, $key='', $key2='') {
		global $CONSULTOR_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($CONSULTOR_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($CONSULTOR_STORAGE[$var_name][$key]);
		else
			return empty($CONSULTOR_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('consultor_storage_isset')) {
	function consultor_storage_isset($var_name, $key='', $key2='') {
		global $CONSULTOR_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($CONSULTOR_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($CONSULTOR_STORAGE[$var_name][$key]);
		else
			return isset($CONSULTOR_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('consultor_storage_inc')) {
	function consultor_storage_inc($var_name, $value=1) {
		global $CONSULTOR_STORAGE;
		if (empty($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = 0;
		$CONSULTOR_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('consultor_storage_concat')) {
	function consultor_storage_concat($var_name, $value) {
		global $CONSULTOR_STORAGE;
		if (empty($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = '';
		$CONSULTOR_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('consultor_storage_get_array')) {
	function consultor_storage_get_array($var_name, $key, $key2='', $default='') {
		global $CONSULTOR_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($CONSULTOR_STORAGE[$var_name][$key]) ? $CONSULTOR_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($CONSULTOR_STORAGE[$var_name][$key][$key2]) ? $CONSULTOR_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('consultor_storage_set_array')) {
	function consultor_storage_set_array($var_name, $key, $value) {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if ($key==='')
			$CONSULTOR_STORAGE[$var_name][] = $value;
		else
			$CONSULTOR_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('consultor_storage_set_array2')) {
	function consultor_storage_set_array2($var_name, $key, $key2, $value) {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if (!isset($CONSULTOR_STORAGE[$var_name][$key])) $CONSULTOR_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$CONSULTOR_STORAGE[$var_name][$key][] = $value;
		else
			$CONSULTOR_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('consultor_storage_merge_array')) {
	function consultor_storage_merge_array($var_name, $key, $value) {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if ($key==='')
			$CONSULTOR_STORAGE[$var_name] = array_merge($CONSULTOR_STORAGE[$var_name], $value);
		else
			$CONSULTOR_STORAGE[$var_name][$key] = array_merge($CONSULTOR_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('consultor_storage_set_array_after')) {
	function consultor_storage_set_array_after($var_name, $after, $key, $value='') {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if (is_array($key))
			consultor_array_insert_after($CONSULTOR_STORAGE[$var_name], $after, $key);
		else
			consultor_array_insert_after($CONSULTOR_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('consultor_storage_set_array_before')) {
	function consultor_storage_set_array_before($var_name, $before, $key, $value='') {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if (is_array($key))
			consultor_array_insert_before($CONSULTOR_STORAGE[$var_name], $before, $key);
		else
			consultor_array_insert_before($CONSULTOR_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('consultor_storage_push_array')) {
	function consultor_storage_push_array($var_name, $key, $value) {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($CONSULTOR_STORAGE[$var_name], $value);
		else {
			if (!isset($CONSULTOR_STORAGE[$var_name][$key])) $CONSULTOR_STORAGE[$var_name][$key] = array();
			array_push($CONSULTOR_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('consultor_storage_pop_array')) {
	function consultor_storage_pop_array($var_name, $key='', $defa='') {
		global $CONSULTOR_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($CONSULTOR_STORAGE[$var_name]) && is_array($CONSULTOR_STORAGE[$var_name]) && count($CONSULTOR_STORAGE[$var_name]) > 0) 
				$rez = array_pop($CONSULTOR_STORAGE[$var_name]);
		} else {
			if (isset($CONSULTOR_STORAGE[$var_name][$key]) && is_array($CONSULTOR_STORAGE[$var_name][$key]) && count($CONSULTOR_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($CONSULTOR_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('consultor_storage_inc_array')) {
	function consultor_storage_inc_array($var_name, $key, $value=1) {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if (empty($CONSULTOR_STORAGE[$var_name][$key])) $CONSULTOR_STORAGE[$var_name][$key] = 0;
		$CONSULTOR_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('consultor_storage_concat_array')) {
	function consultor_storage_concat_array($var_name, $key, $value) {
		global $CONSULTOR_STORAGE;
		if (!isset($CONSULTOR_STORAGE[$var_name])) $CONSULTOR_STORAGE[$var_name] = array();
		if (empty($CONSULTOR_STORAGE[$var_name][$key])) $CONSULTOR_STORAGE[$var_name][$key] = '';
		$CONSULTOR_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('consultor_storage_call_obj_method')) {
	function consultor_storage_call_obj_method($var_name, $method, $param=null) {
		global $CONSULTOR_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($CONSULTOR_STORAGE[$var_name]) ? $CONSULTOR_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($CONSULTOR_STORAGE[$var_name]) ? $CONSULTOR_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('consultor_storage_get_obj_property')) {
	function consultor_storage_get_obj_property($var_name, $prop, $default='') {
		global $CONSULTOR_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($CONSULTOR_STORAGE[$var_name]->$prop) ? $CONSULTOR_STORAGE[$var_name]->$prop : $default;
	}
}
?>