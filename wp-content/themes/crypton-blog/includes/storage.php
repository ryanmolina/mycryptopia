<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('crypton_blog_storage_get')) {
	function crypton_blog_storage_get($var_name, $default='') {
		global $CRYPTON_BLOG_STORAGE;
		return isset($CRYPTON_BLOG_STORAGE[$var_name]) ? $CRYPTON_BLOG_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('crypton_blog_storage_set')) {
	function crypton_blog_storage_set($var_name, $value) {
		global $CRYPTON_BLOG_STORAGE;
		$CRYPTON_BLOG_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('crypton_blog_storage_empty')) {
	function crypton_blog_storage_empty($var_name, $key='', $key2='') {
		global $CRYPTON_BLOG_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($CRYPTON_BLOG_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($CRYPTON_BLOG_STORAGE[$var_name][$key]);
		else
			return empty($CRYPTON_BLOG_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('crypton_blog_storage_isset')) {
	function crypton_blog_storage_isset($var_name, $key='', $key2='') {
		global $CRYPTON_BLOG_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($CRYPTON_BLOG_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($CRYPTON_BLOG_STORAGE[$var_name][$key]);
		else
			return isset($CRYPTON_BLOG_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('crypton_blog_storage_inc')) {
	function crypton_blog_storage_inc($var_name, $value=1) {
		global $CRYPTON_BLOG_STORAGE;
		if (empty($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = 0;
		$CRYPTON_BLOG_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('crypton_blog_storage_concat')) {
	function crypton_blog_storage_concat($var_name, $value) {
		global $CRYPTON_BLOG_STORAGE;
		if (empty($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = '';
		$CRYPTON_BLOG_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('crypton_blog_storage_get_array')) {
	function crypton_blog_storage_get_array($var_name, $key, $key2='', $default='') {
		global $CRYPTON_BLOG_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($CRYPTON_BLOG_STORAGE[$var_name][$key]) ? $CRYPTON_BLOG_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($CRYPTON_BLOG_STORAGE[$var_name][$key][$key2]) ? $CRYPTON_BLOG_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('crypton_blog_storage_set_array')) {
	function crypton_blog_storage_set_array($var_name, $key, $value) {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if ($key==='')
			$CRYPTON_BLOG_STORAGE[$var_name][] = $value;
		else
			$CRYPTON_BLOG_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('crypton_blog_storage_set_array2')) {
	function crypton_blog_storage_set_array2($var_name, $key, $key2, $value) {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name][$key])) $CRYPTON_BLOG_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$CRYPTON_BLOG_STORAGE[$var_name][$key][] = $value;
		else
			$CRYPTON_BLOG_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('crypton_blog_storage_merge_array')) {
	function crypton_blog_storage_merge_array($var_name, $key, $value) {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if ($key==='')
			$CRYPTON_BLOG_STORAGE[$var_name] = array_merge($CRYPTON_BLOG_STORAGE[$var_name], $value);
		else
			$CRYPTON_BLOG_STORAGE[$var_name][$key] = array_merge($CRYPTON_BLOG_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('crypton_blog_storage_set_array_after')) {
	function crypton_blog_storage_set_array_after($var_name, $after, $key, $value='') {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if (is_array($key))
			crypton_blog_array_insert_after($CRYPTON_BLOG_STORAGE[$var_name], $after, $key);
		else
			crypton_blog_array_insert_after($CRYPTON_BLOG_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('crypton_blog_storage_set_array_before')) {
	function crypton_blog_storage_set_array_before($var_name, $before, $key, $value='') {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if (is_array($key))
			crypton_blog_array_insert_before($CRYPTON_BLOG_STORAGE[$var_name], $before, $key);
		else
			crypton_blog_array_insert_before($CRYPTON_BLOG_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('crypton_blog_storage_push_array')) {
	function crypton_blog_storage_push_array($var_name, $key, $value) {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($CRYPTON_BLOG_STORAGE[$var_name], $value);
		else {
			if (!isset($CRYPTON_BLOG_STORAGE[$var_name][$key])) $CRYPTON_BLOG_STORAGE[$var_name][$key] = array();
			array_push($CRYPTON_BLOG_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('crypton_blog_storage_pop_array')) {
	function crypton_blog_storage_pop_array($var_name, $key='', $defa='') {
		global $CRYPTON_BLOG_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($CRYPTON_BLOG_STORAGE[$var_name]) && is_array($CRYPTON_BLOG_STORAGE[$var_name]) && count($CRYPTON_BLOG_STORAGE[$var_name]) > 0) 
				$rez = array_pop($CRYPTON_BLOG_STORAGE[$var_name]);
		} else {
			if (isset($CRYPTON_BLOG_STORAGE[$var_name][$key]) && is_array($CRYPTON_BLOG_STORAGE[$var_name][$key]) && count($CRYPTON_BLOG_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($CRYPTON_BLOG_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('crypton_blog_storage_inc_array')) {
	function crypton_blog_storage_inc_array($var_name, $key, $value=1) {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if (empty($CRYPTON_BLOG_STORAGE[$var_name][$key])) $CRYPTON_BLOG_STORAGE[$var_name][$key] = 0;
		$CRYPTON_BLOG_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('crypton_blog_storage_concat_array')) {
	function crypton_blog_storage_concat_array($var_name, $key, $value) {
		global $CRYPTON_BLOG_STORAGE;
		if (!isset($CRYPTON_BLOG_STORAGE[$var_name])) $CRYPTON_BLOG_STORAGE[$var_name] = array();
		if (empty($CRYPTON_BLOG_STORAGE[$var_name][$key])) $CRYPTON_BLOG_STORAGE[$var_name][$key] = '';
		$CRYPTON_BLOG_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('crypton_blog_storage_call_obj_method')) {
	function crypton_blog_storage_call_obj_method($var_name, $method, $param=null) {
		global $CRYPTON_BLOG_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($CRYPTON_BLOG_STORAGE[$var_name]) ? $CRYPTON_BLOG_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($CRYPTON_BLOG_STORAGE[$var_name]) ? $CRYPTON_BLOG_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('crypton_blog_storage_get_obj_property')) {
	function crypton_blog_storage_get_obj_property($var_name, $prop, $default='') {
		global $CRYPTON_BLOG_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($CRYPTON_BLOG_STORAGE[$var_name]->$prop) ? $CRYPTON_BLOG_STORAGE[$var_name]->$prop : $default;
	}
}
?>