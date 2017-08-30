<?php
/**
 * Include core functions
 *
 *
 * @author 		Cherry Team
 * @category 	Core
 * @package 	cherry-woocommerce-package/functions
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * get theme option by name
 * @since 1.0.0
 * 
 * @param  string  $name    option name
 * @param  mixed   $default default option value
 * @return mixed            option value 
 */
function cherry_wc_get_option( $name, $default = false ) {
	
	if ( function_exists( 'of_get_option' ) ) {
		return of_get_option( $name, $default );
	}

	$config = get_option( 'optionsframework' );

	if ( ! isset( $config['id'] ) ) {
		return $default;
	}

	$options = get_option( $config['id'] );

	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}

/**
 * Get template part (for templates like the shop-loop).
 * @since 1.0.0
 *
 * @param  string $name
 * @return void
 */
function cherry_wc_get_template_part( $name ) {

	if ( !$name ) {
		return;
	}

	global $cherry_woocommerce;

	$template = '';

	// Look in yourtheme/name.php and yourtheme/woocommerce/name.php
	$template = locate_template( array( "{$name}.php", "/woocommerce/{$name}.php" ) );

	// Get template file from plugin templates
	if ( ! $template ) {
		$template = $cherry_woocommerce->dir( 'templates' ) . "/{$name}.php";
	}

	// Allow 3rd party plugin filter template file from their plugin
	$template = apply_filters( 'cherry_woocommerce_get_template_part', $template, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}