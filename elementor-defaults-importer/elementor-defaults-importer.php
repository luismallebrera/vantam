<?php

/**
 * Plugin Name: Elementor Global Defaults
 * Plugin URI: https://github.com/luismallebrera/vantam
 * Description: Automatically applies global color and typography defaults to Elementor. Works with any WordPress theme.
 * Version: 1.0.0
 * Author: Luis Mallebrera
 * Text Domain: elementor-global-defaults
 * Domain Path: /languages
 * Author URI: https://github.com/luismallebrera
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

if ( ! class_exists( 'SodaElementorIntregration' ) ) {

	class SodaElementorIntregration {

		const PLUGIN_VERSION            = '1.0.0';
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
		const MINIMUM_PHP_VERSION       = '7.0';

		private static $_instance = null;

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			add_action( 'plugins_loaded', [ $this, 'init' ] );
		}

		public function init() {
			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				return;
			}

			// All checks passed, load the plugin.
			$this->load_plugin();
		}

		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-global-defaults' ),
				'<strong>' . esc_html__( 'Elementor Global Defaults', 'elementor-global-defaults' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'elementor-global-defaults' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		public function admin_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-global-defaults' ),
				'<strong>' . esc_html__( 'Elementor Global Defaults', 'elementor-global-defaults' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'elementor-global-defaults' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		public function load_plugin() {
			if ( ! defined( 'SODA_ELEMENTOR_INT_DIR' ) ) {
				define( 'SODA_ELEMENTOR_INT_DIR', plugin_dir_path( __FILE__ ) );
			}
			if ( ! defined( 'SODA_ELEMENTOR_DIR_PATH' ) ) {
				define( 'SODA_ELEMENTOR_DIR_PATH', SODA_ELEMENTOR_INT_DIR );
			}

			// Load only the defaults importer
			require_once SODA_ELEMENTOR_INT_DIR . 'includes/helpers/elementor-defaults-importer.php';
		}
	}

	SodaElementorIntregration::instance();
}
