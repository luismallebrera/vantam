<?php
/**
 * Plugin Name: Elementor Global Defaults
 * Plugin URI: https://github.com/luismallebrera
 * Description: Automatically applies predefined global colors and typography to Elementor on first activation.
 * Version: 1.0.0
 * Author: Luis Mallebrera
 * Author URI: https://github.com/luismallebrera
 * Text Domain: elementor-global-defaults
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Requires Plugins: elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Global_Defaults {
	
	const VERSION = '1.0.0';
	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		// Check if Elementor is active
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'elementor_missing_notice' ] );
			return;
		}

		// Apply defaults on first activation
		add_action( 'elementor/init', [ $this, 'maybe_apply_defaults' ], 20 );
	}

	public function elementor_missing_notice() {
		?>
		<div class="notice notice-error">
			<p><?php esc_html_e( 'Elementor Global Defaults requires Elementor to be installed and activated.', 'elementor-global-defaults' ); ?></p>
		</div>
		<?php
	}

	public function maybe_apply_defaults() {
		// Check if already applied
		if ( get_option( 'elementor_global_defaults_applied', false ) ) {
			return;
		}

		// Get active Elementor kit
		$active_kit_id = get_option( 'elementor_active_kit' );
		if ( ! $active_kit_id ) {
			return;
		}

		// Apply defaults
		$this->apply_defaults( $active_kit_id );

		// Mark as applied
		update_option( 'elementor_global_defaults_applied', true );

		// Clear Elementor cache
		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}
	}

	private function apply_defaults( $kit_id ) {
		$defaults = $this->get_defaults();
		
		if ( empty( $defaults ) ) {
			return;
		}

		// Get existing settings
		$settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
		if ( ! is_array( $settings ) ) {
			$settings = [];
		}

		// Merge defaults
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

		// Save settings
		update_post_meta( $kit_id, '_elementor_page_settings', $settings );
	}

	private function get_defaults() {
		return array(
			'system_colors' => array(
				array(
					'_id' => 'vamtam_accent_1',
					'title' => 'Accent 1',
					'color' => '#0F3D3A',
				),
				array(
					'_id' => 'vamtam_accent_2',
					'title' => 'Accent 2',
					'color' => '#C8F8A9',
				),
				array(
					'_id' => 'vamtam_accent_3',
					'title' => 'Accent 3',
					'color' => '#F2F5F1',
				),
				array(
					'_id' => 'vamtam_accent_4',
					'title' => 'Accent 4',
					'color' => '#F8F7F3',
				),
				array(
					'_id' => 'vamtam_accent_5',
					'title' => 'Accent 5',
					'color' => '#FFFFFF',
				),
				array(
					'_id' => 'vamtam_accent_6',
					'title' => 'Accent 6',
					'color' => '#000000',
				),
				array(
					'_id' => 'vamtam_accent_7',
					'title' => 'Accent 7',
					'color' => '#0000001A',
				),
				array(
					'_id' => 'vamtam_accent_8',
					'title' => 'Accent 8',
					'color' => '#00000099',
				),
				array(
					'_id' => 'vamtam_sticky_header_bg_color',
					'title' => 'Sticky Header Bg Color',
					'color' => '#0F3D3ACC',
				),
			),
			'system_typography' => array(
				array(
					'_id' => 'vamtam_primary_font',
					'title' => 'Primary Font',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '400',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 15,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.5,
						'sizes' => array(),
					),
					'typography_font_size_mobile' => array(
						'unit' => 'px',
						'size' => 16,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1.5,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'vamtam_h1',
					'title' => 'H1',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '400',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 46,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 36,
						'sizes' => array(),
					),
					'typography_font_size_mobile' => array(
						'unit' => 'px',
						'size' => 30,
						'sizes' => array(),
					),
					'typography_line_height_tablet' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'vamtam_h2',
					'title' => 'H2',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '300',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 40,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 32,
						'sizes' => array(),
					),
					'typography_font_size_mobile' => array(
						'unit' => 'px',
						'size' => 28,
						'sizes' => array(),
					),
					'typography_line_height_tablet' => array(
						'unit' => 'em',
						'size' => 1.1,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1.3,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'vamtam_h3',
					'title' => 'H3',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '400',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 30,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 24,
						'sizes' => array(),
					),
					'typography_line_height_tablet' => array(
						'unit' => 'em',
						'size' => 1.1,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1.1,
						'sizes' => array(),
					),
					'typography_font_size_mobile' => array(
						'unit' => 'px',
						'size' => 24,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'vamtam_h4',
					'title' => 'H4',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '300',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 24,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.4,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1.4,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 20,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'vamtam_h5',
					'title' => 'H5',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '400',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 20,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.4,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 18,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'vamtam_h6',
					'title' => 'H6',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_weight' => '400',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 16,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
				),
			),
			'custom_colors' => array(
				array(
					'_id' => '0e53263',
					'title' => 'Accent 9',
					'color' => '#FFFFFF80',
				),
				array(
					'_id' => 'cd36427',
					'title' => 'Accent 10',
					'color' => '#1F6E69',
				),
				array(
					'_id' => '597ed21',
					'title' => 'Body Text',
					'color' => '#000000BF',
				),
				array(
					'_id' => 'd8fe409',
					'title' => 'Background Blur',
					'color' => '#0F3D3A66',
				),
			),
			'custom_typography' => array(
				array(
					'_id' => '1c16242',
					'title' => 'Accent Title',
					'typography_typography' => 'custom',
					'typography_font_family' => 'Forum',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 56,
						'sizes' => array(),
					),
					'typography_font_weight' => '400',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 46,
						'sizes' => array(),
					),
					'typography_font_size_mobile' => array(
						'unit' => 'px',
						'size' => 36,
						'sizes' => array(),
					),
					'typography_line_height_mobile' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
				),
				array(
					'_id' => 'd778ca5',
					'title' => 'Body S',
					'typography_typography' => 'custom',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 12,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.4,
						'sizes' => array(),
					),
				),
				array(
					'_id' => '0c1fb19',
					'title' => 'Body L',
					'typography_typography' => 'custom',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 17,
						'sizes' => array(),
					),
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.5,
						'sizes' => array(),
					),
					'typography_font_weight' => '400',
				),
				array(
					'_id' => 'aa3d2ee',
					'title' => 'Quote',
					'typography_typography' => 'custom',
					'typography_font_family' => 'Forum',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 21,
						'sizes' => array(),
					),
					'typography_font_weight' => '400',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.4,
						'sizes' => array(),
					),
				),
				array(
					'_id' => '47d0553',
					'title' => 'Menu',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 16,
						'sizes' => array(),
					),
					'typography_font_weight' => '500',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
				),
				array(
					'_id' => '6cc3f6e',
					'title' => 'Button',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 14,
						'sizes' => array(),
					),
					'typography_font_weight' => '500',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
				),
				array(
					'_id' => '798d94d',
					'title' => 'Title Label',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 12,
						'sizes' => array(),
					),
					'typography_font_weight' => '500',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
				),
				array(
					'_id' => '82eb0df',
					'title' => 'Statistics Numbers',
					'typography_typography' => 'custom',
					'typography_font_family' => 'DM Sans',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 66,
						'sizes' => array(),
					),
					'typography_font_weight' => '200',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1,
						'sizes' => array(),
					),
					'typography_font_size_tablet' => array(
						'unit' => 'px',
						'size' => 56,
						'sizes' => array(),
					),
					'typography_font_size_mobile' => array(
						'unit' => 'px',
						'size' => 50,
						'sizes' => array(),
					),
				),
				array(
					'_id' => '8f74279',
					'title' => 'Handwrite',
					'typography_typography' => 'custom',
					'typography_font_family' => 'Nothing You Could Do',
					'typography_font_size' => array(
						'unit' => 'px',
						'size' => 20,
						'sizes' => array(),
					),
					'typography_font_weight' => '400',
					'typography_line_height' => array(
						'unit' => 'em',
						'size' => 1.2,
						'sizes' => array(),
					),
				),
			),
		);
	}
}

// Initialize plugin
Elementor_Global_Defaults::get_instance();
