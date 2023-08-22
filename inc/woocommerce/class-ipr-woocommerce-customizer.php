<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme WooCommerce settings functionality via customizer.
 *
 * @package iPress\WooCommerce
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Woocommerce_Customizer' ) ) :

	/**
	 * Set up ajax features
	 */
	final class IPR_Woocommerce_Customizer extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Theme Woocommerce customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register' ], 10 );

			// Theme customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register_partials' ], 12 );
		}

		//----------------------------------------------
		//	Customizer Settings Actions
		//----------------------------------------------

		/**
		 * Set up customizer and theme specific Woocommerce settings
		 * - Fonts & typography
		 * - Background & header colours
		 * - Button and text colours
		 * - Breadcrumbs
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register( WP_Customize_Manager $wp_customize ) {

			// Define settings & partials based on if selective refresh is active
			$transport = ( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

			// Option defaults
			$defaults = ipress_get_defaults();

			// Add the theme section. Won't show until settings & controls added
			$wp_customize->add_section(
				'ipress_woocommerce',
				[
					'panel'       => 'woocommerce',
					'title'       => __( 'Theme', 'ipress' ),
					'description' => esc_html__( 'Add theme specific Woocommerce settings.', 'ipress' ),
					'capability'  => 'edit_theme_options',
					'priority'    => 50,
				]
			);

			// ----------------------------------------------
			// Theme setting: woocommerce breadcrumbs
			// ----------------------------------------------

			// Add setting for breadcrumbs
			$wp_customize->add_setting(
				'ipress_settings[woocommerce_breadcrumbs]',
				[
					'default' 			=> $defaults['woocommerce_breadcrumbs'],
					'transport' 		=> $transport,
					'type' 				=> 'option',
					'capability' 		=> 'edit_theme_options',
					'sanitize_callback' => 'ipress_sanitize_checkbox'
				]
			);

			// Add checkbox control for breadcrumbs setting
			$wp_customize->add_control(
				'ipress_settings[woocommerce_breadcrumbs]',
				[
					'label'       => __( 'Breadcrumbs', 'ipress' ),
					'description' => esc_html__( 'Display or hide the store pages breadcrumbs.', 'ipress' ),
					'type'        => 'checkbox',
					'section'     => 'ipress_woocommerce',
					'priority'    => 10,
				]
			);

			// Section separator
			$wp_customize->add_setting(
				'ipress_settings[woocommerce_sep_top]',
				[ 'sanitize_callback' => '__return_true' ]
			);

			$wp_customize->add_control(
				new IPR_Separator_Control(
					$wp_customize,
					'ipress_settings[woocommerce_sep_top]',
					[
						'section'  => 'ipress_woocommerce',
						'priority' => 15,
					]
				)
			);

			// ------------------------------------------------------
			// Theme setting: woocommerce single product pagination
			// ------------------------------------------------------

			$wp_customize->add_setting(
				'ipress_settings[woocommerce_product_pagination]',
				[
					'default'			=> $defaults['woocommerce_product_pagination'],
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'ipress_sanitize_checkbox'
				]
			);

			$wp_customize->add_control(
				'ipress_settings[woocommerce_product_pagination]',
				[
					'type'        => 'checkbox',
					'section'     => 'ipress_woocommerce',
					'label'       => __( 'Product Pagination', 'ipress' ),
					'description' => __( 'Displays next and previous links on product pages. Hover reveals product details & thumbnail.', 'ipress' ),
					'priority'    => 20,
				]
			);

			// Section separator
			$wp_customize->add_setting(
				'ipress_settings[woocommerce_sep_bottom]',
				[ 'sanitize_callback' => '__return_true' ]
			);

			$wp_customize->add_control(
				new IPR_Separator_Control(
					$wp_customize,
					'ipress_settings[woocommerce_sep_bottom]',
					[
						'section'  => 'ipress_woocommerce',
						'priority' => 25,
					]
				)
			);

			$wp_customize->add_setting(
				'ipress_settings[woocommerce_product_search]',
				[
					'default' 			=> $defaults['woocommerce_product_search'],
					'transport' 		=> $transport,
					'type' 				=> 'option',
					'capability' 		=> 'edit_theme_options',
					'sanitize_callback' => 'ipress_sanitize_checkbox'
				]
			);

			$wp_customize->add_control(
				'ipress_settings[woocommerce_product_search]',
				[
					'type'        => 'checkbox',
					'section'     => 'ipress_woocommerce',
					'label'       => __( 'Product Search', 'ipress' ),
					'description' => __( 'Displays header product search box.', 'ipress' ),
					'priority'    => 30,
				]
			);

			// Pluggable registrations - pass customizer manager object to filter
			do_action( 'ipress_customize_register_woocommerce', $wp_customize );
		}

		/**
		 * Set up customizer and theme partials
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register_partials( WP_Customize_Manager $wp_customize ) {

			// Abort if selective refresh is not available.
			if ( ! isset( $wp_customize->selective_refresh ) ) {
				return;
			}

			// Pluggable registrations - pass customizer manager object to filter
			do_action( 'ipress_customize_register_partials_woocommerce', $wp_customize );
		}
	}

endif;

// Instantiate Theme Woocommerce Customizer Class
return IPR_Woocommerce_Customizer::Init();
