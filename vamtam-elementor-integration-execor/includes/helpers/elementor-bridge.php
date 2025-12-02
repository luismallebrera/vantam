<?php
/**
 * Bridge class for Elementor integration
 * Provides widget and WooCommerce modification lists
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class VamtamElementorBridge {
	/**
	 * Get list of widgets that have modifications
	 * 
	 * @return array Widget mods list with widget names as keys and settings as values
	 */
	public static function get_widget_mods_list() {
		return [
			'button' => [
				'label' => __( 'Button', 'vamtam-elementor-integration' ),
			],
			'container' => [
				'label' => __( 'Container', 'vamtam-elementor-integration' ),
			],
			'form' => [
				'label' => __( 'Form', 'vamtam-elementor-integration' ),
			],
			'icon' => [
				'label' => __( 'Icon', 'vamtam-elementor-integration' ),
			],
			'nav-menu' => [
				'label' => __( 'Nav Menu', 'vamtam-elementor-integration' ),
			],
			'page' => [
				'label' => __( 'Page', 'vamtam-elementor-integration' ),
			],
		];
	}

	/**
	 * Get list of WooCommerce modifications
	 * 
	 * @return array WC mods list with mod names as keys and settings as values
	 */
	public static function get_wc_mods_list() {
		// Currently no WooCommerce specific mods, but keeping for future extensibility
		return [];
	}
}
