<?php
/**
 * Elementor Defaults Importer
 * 
 * Handles importing default Elementor settings and global styles
 *
 * @package VamtamElementorIntegration
 */

namespace VamtamElementorIntegration;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Defaults_Importer {
	
	/**
	 * Instance of this class.
	 */
	private static $instance = null;

	/**
	 * Get instance
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'admin_init', [ $this, 'maybe_import_defaults' ] );
	}

	/**
	 * Check if defaults have been imported
	 */
	private function defaults_imported() {
		return get_option( 'vamtam_elementor_defaults_imported', false );
	}

	/**
	 * Mark defaults as imported
	 */
	private function mark_defaults_imported() {
		update_option( 'vamtam_elementor_defaults_imported', true );
	}

	/**
	 * Check if Elementor is active
	 */
	private function is_elementor_active() {
		return did_action( 'elementor/loaded' );
	}

	/**
	 * Get the path to defaults files
	 */
	private function get_defaults_file_path( $filename ) {
		return VAMTAM_ELEMENTOR_DIR_PATH . $filename;
	}

	/**
	 * Maybe import defaults on first activation
	 */
	public function maybe_import_defaults() {
		// Don't import if already done
		if ( $this->defaults_imported() ) {
			return;
		}

		// Don't import if Elementor is not active
		if ( ! $this->is_elementor_active() ) {
			return;
		}

		// Check if user has capability
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Automatically import defaults
		$this->import_defaults();
		$this->mark_defaults_imported();
	}



	/**
	 * Import default settings and styles
	 */
	private function import_defaults() {
		// Import global defaults (colors and typography)
		$this->import_global_defaults();

		// Import Elementor settings
		$this->import_elementor_settings();

		// Clear Elementor cache
		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}
	}

	/**
	 * Import global defaults (colors and typography)
	 */
	private function import_global_defaults() {
		// Try PHP file first (more reliable)
		$php_file = $this->get_defaults_file_path( 'elementor-global-defaults.php' );
		
		if ( file_exists( $php_file ) ) {
			$defaults = include $php_file;
			
			if ( is_array( $defaults ) ) {
				// Get active kit
				$active_kit_id = get_option( 'elementor_active_kit' );
				
				if ( $active_kit_id ) {
					// Get existing settings
					$settings = get_post_meta( $active_kit_id, '_elementor_page_settings', true );
					if ( ! is_array( $settings ) ) {
						$settings = [];
					}

					// Merge all defaults into settings
					if ( ! empty( $defaults['system_colors'] ) ) {
						$settings['system_colors'] = $defaults['system_colors'];
					}

					if ( ! empty( $defaults['system_typography'] ) ) {
						$settings['system_typography'] = $defaults['system_typography'];
					}

					if ( ! empty( $defaults['custom_colors'] ) ) {
						$settings['custom_colors'] = $defaults['custom_colors'];
					}

					if ( ! empty( $defaults['custom_typography'] ) ) {
						$settings['custom_typography'] = $defaults['custom_typography'];
					}

					// Save all settings at once
					update_post_meta( $active_kit_id, '_elementor_page_settings', $settings );
				}
			}
		}
	}

	/**
	 * Import Elementor settings
	 */
	private function import_elementor_settings() {
		$settings_file = $this->get_defaults_file_path( 'elementor-settings.json' );
		
		if ( file_exists( $settings_file ) ) {
			$settings_json = file_get_contents( $settings_file );
			$settings = json_decode( $settings_json, true );
			
			if ( is_array( $settings ) ) {
				foreach ( $settings as $key => $value ) {
					// Only import non-critical settings
					if ( in_array( $key, [
						'elementor_allow_svg',
						'elementor_cpt_support',
						'elementor_disable_color_schemes',
						'elementor_disable_typography_schemes',
					] ) ) {
						update_option( $key, $value );
					}
				}
			}
		}
	}

	/**
	 * Get import status for debugging
	 */
	public function get_import_status() {
		return [
			'defaults_imported' => $this->defaults_imported(),
			'elementor_active' => $this->is_elementor_active(),
			'active_kit' => get_option( 'elementor_active_kit' ),
		];
	}
}

// Initialize
Elementor_Defaults_Importer::get_instance();
