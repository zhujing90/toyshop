<?php
/*
  Plugin Name: Cherry WooCommerce Package
  Version: 1.0.0
  Plugin URI: http://www.cherryframework.com/
  Description: Extend shop functionality for Cherry themes
  Author: Cherry Team.
  Author URI: http://www.cherryframework.com/
  Text Domain: cherry-woocommerce-package
  Domain Path: languages/
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Main class
 */
class cherry_woocommerce {

	public $version = '1.0.0';
	public $compatible_cherry_version = '3.1.4';

	function __construct() {
		
		if ( !$this->has_woocommerce() ) {
			return;
		}
		
		$this->include_files();

		add_action( 'wp_enqueue_scripts', array( $this, 'include_assets' ) );
	}

	public function include_assets() {
		wp_enqueue_style( 'cherry_woocommerce_style', $this->url( '/assets/css/style.css' ), '', $this->version, 'all' );
		wp_enqueue_script( 'cherry_woocommerce_script', $this->url( '/assets/js/script.js' ), array( 'jquery' ), $this->version, true );
	}

	/**
	 * include necessary files
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	private function include_files() {
		require( 'includes/functions-core.php' );
		require( 'includes/class-menu-badges.php' );
		require( 'includes/class-account-dropdown.php' );
	}

	/**
	 * get file URL inside plugin
	 * @since 1.0.0
	 * 
	 * @param  string $path path to file inside plugin
	 * @return string       file URL
	 */
	public function url( $path = null ) {
		$base_url = untrailingslashit( plugin_dir_url( __FILE__ ) );
		if ( !$path ) {
			return $base_url;
		} else {
			return esc_url( $base_url . '/' . $path );
		}
	}

	/**
	 * get file dir inside plugin
	 * @since 1.0.0
	 * 
	 * @param  string $path path to file inside plugin
	 * @return string       file dir
	 */
	public function dir( $path = null ) {
		$base_dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
		if ( !$path ) {
			return $base_dir;
		} else {
			return $base_dir . '/' . $path;
		}
	}

	/**
	 * Check if WooCommerce plugin is active
	 * @since 1.0.0
	 * 
	 * @return boolean true if WooCommerce active
	 */
	public function has_woocommerce() {
		return  in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
	}

}

$GLOBALS['cherry_woocommerce'] = new cherry_woocommerce();