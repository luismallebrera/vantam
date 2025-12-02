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
		add_action( 'admin_notices', [ $this, 'show_import_notice' ] );
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

		// Check if user wants to skip import
		if ( isset( $_GET['vamtam_skip_defaults'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'skip_defaults' ) ) {
			$this->mark_defaults_imported();
			wp_safe_redirect( admin_url() );
			exit;
		}

		// Check if user wants to import now
		if ( isset( $_GET['vamtam_import_defaults'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'import_defaults' ) ) {
			$this->import_defaults();
			$this->mark_defaults_imported();
			wp_safe_redirect( add_query_arg( 'vamtam_defaults_imported', '1', admin_url() ) );
			exit;
		}
	}

	/**
	 * Show admin notice for importing defaults
	 */
	public function show_import_notice() {
		// Don't show if already imported
		if ( $this->defaults_imported() ) {
			// Show success message if just imported
			if ( isset( $_GET['vamtam_defaults_imported'] ) ) {
				?>
				<div class="notice notice-success is-dismissible">
					<p><strong>Elementor Integration Extended:</strong> Global styles and settings have been imported successfully!</p>
				</div>
				<?php
			}
			return;
		}

		// Don't show if Elementor is not active
		if ( ! $this->is_elementor_active() ) {
			return;
		}

		// Don't show if not on main admin pages
		$screen = get_current_screen();
		if ( ! in_array( $screen->id, [ 'dashboard', 'plugins', 'toplevel_page_elementor' ] ) ) {
			return;
		}

		$import_url = wp_nonce_url( add_query_arg( 'vamtam_import_defaults', '1' ), 'import_defaults', '_wpnonce' );
		$skip_url = wp_nonce_url( add_query_arg( 'vamtam_skip_defaults', '1' ), 'skip_defaults', '_wpnonce' );
		?>
		<div class="notice notice-info">
			<p>
				<strong>Elementor Integration Extended:</strong> Would you like to import default global colors and typography styles? 
				This will enhance your Elementor experience with pre-configured design system.
			</p>
			<p>
				<a href="<?php echo esc_url( $import_url ); ?>" class="button button-primary">Import Defaults</a>
				<a href="<?php echo esc_url( $skip_url ); ?>" class="button">Skip</a>
			</p>
		</div>
		<?php
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
					// Import system colors
					if ( ! empty( $defaults['system_colors'] ) ) {
						update_post_meta( $active_kit_id, '_elementor_page_settings', [
							'system_colors' => $defaults['system_colors'],
						] );
					}

					// Import system typography
					if ( ! empty( $defaults['system_typography'] ) ) {
						$settings = get_post_meta( $active_kit_id, '_elementor_page_settings', true );
						if ( ! is_array( $settings ) ) {
							$settings = [];
						}
						$settings['system_typography'] = $defaults['system_typography'];
						update_post_meta( $active_kit_id, '_elementor_page_settings', $settings );
					}

					// Import custom colors
					if ( ! empty( $defaults['custom_colors'] ) ) {
						$settings = get_post_meta( $active_kit_id, '_elementor_page_settings', true );
						if ( ! is_array( $settings ) ) {
							$settings = [];
						}
						$settings['custom_colors'] = $defaults['custom_colors'];
						update_post_meta( $active_kit_id, '_elementor_page_settings', $settings );
					}

					// Import custom typography
					if ( ! empty( $defaults['custom_typography'] ) ) {
						$settings = get_post_meta( $active_kit_id, '_elementor_page_settings', true );
						if ( ! is_array( $settings ) ) {
							$settings = [];
						}
						$settings['custom_typography'] = $defaults['custom_typography'];
						update_post_meta( $active_kit_id, '_elementor_page_settings', $settings );
					}
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
