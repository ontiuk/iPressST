<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for front-page Hero features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Hero' ) ) :

	/**
	 * Set up user features
	 */
	final class IPR_Hero extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Theme customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register_hero' ] );

			// Theme customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register_partials' ], 12 );
			
			// Output custom hero css to header
			add_action( 'wp_head', 'ipress_hero_css_output' );

			// Add custom hero image size
			add_filter( 'ipress_add_image_size', 'ipress_hero_image_size', 10, 1 );
		}

		//----------------------------------------------
		//	Hero Functionality
		//----------------------------------------------

		/**
		 * Set up customizer hero section and settings
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register_hero( WP_Customize_Manager $wp_customize ) {

			// Does the theme utilise a front-page hero section? Default, true
			$ip_custom_hero = (bool) apply_filters( 'ipress_custom_hero', true );
			if ( false === $ip_custom_hero ) { return; }

			// Define settings & partials based on if selective refresh is active
			$transport = ( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

			// Add front page hero. Most themes will have this, block above if not required
			$wp_customize->add_section(
				'ipress_hero',
				[
					'title'           => __( 'Hero', 'ipress' ),
					'description'     => esc_html__( 'Front page hero image and details', 'ipress' ),
					'priority'        => 260,
					'active_callback' => function() use ( $wp_customize ) {
						return ( is_front_page() && true === $wp_customize->get_setting( 'ipress_hero' )->value() );
					},
				]
			);

			// Add setting for frontpage hero section
			$wp_customize->add_setting(
				'ipress_hero',
				[
					'transport'         => $transport,
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => 'ipress_sanitize_checkbox',
				]
			);

			// Add checkbox control for frontpage hero section
			$wp_customize->add_control(
				'ipress_hero',
				[
					'label'       => __( 'Front Page Hero Area', 'ipress' ),
					'description' => esc_html__( 'Display or hide the front page hero section.', 'ipress' ),
					'type'        => 'checkbox',
					'section'     => 'ipress_theme',
					'settings'    => 'ipress_hero',					
					'priority'    => 10,
				]
			);

			// Section separator
			$wp_customize->add_setting(
				'ipress_hero_sep',
				[ 'sanitize_callback' => '__return_true' ]
			);

			$wp_customize->add_control(
				new IPR_Separator_Control(
					$wp_customize,
					'ipress_hero_sep',
					[
						'section'  => 'ipress_theme',
						'priority' => 15,
					]
				)
			);

			// ----------------------------------------------
			// Set up Hero settings, modify as appropriate
			// ----------------------------------------------

			// Add setting for hero title
			$wp_customize->add_setting(
				'ipress_settings[hero_title]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '',
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			// Add text control for hero title
			$wp_customize->add_control(
				'ipress_settings[hero_title]',
				[
					'label'       => __( 'Hero Title', 'ipress' ),
					'description' => esc_html__( 'Modify the front page hero section title', 'ipress' ),
					'section'     => 'ipress_hero',
					'settings'    => 'ipress_settings[hero_title]',
					'type'        => 'text',
					'priority'    => 10,
				]
			);

			// Add setting & control for hero description
			$wp_customize->add_setting(
				'ipress_settings[hero_description]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '',
					'sanitize_callback' => 'sanitize_textarea_field',
				]
			);

			// Add control for hero
			$wp_customize->add_control(
				'ipress_settings[hero_description]',
				[
					'label'       => __( 'Hero Description', 'ipress' ),
					'description' => esc_html__( 'Modify the front page hero section description', 'ipress' ),
					'section'     => 'ipress_hero',
					'settings'    => 'ipress_settings[hero_description]',
					'type'        => 'textarea',
					'priority'    => 12,
				]
			);

			// Add setting for button page link
			$wp_customize->add_setting(
				'ipress_settings[hero_button_link]',
				[
					'transport'         => 'none',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '',
					'sanitize_callback' => 'absint',
				]
			);

			// Add control for hero button page link
			$wp_customize->add_control(
				'ipress_settings[hero_button_link]',
				[
					'label'       => __( 'Button Page Link', 'ipress' ),
					'description' => esc_html__( 'Link to page via button', 'ipress' ),
					'section'     => 'ipress_hero',
					'settings'    => 'ipress_settings[hero_button_link]',
					'type'        => 'dropdown-pages',
					'priority'    => 14,
				]
			);

			// Add setting for hero button text
			$wp_customize->add_setting(
				'ipress_settings[hero_button_text]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => esc_attr__( 'Learn More', 'ipress' ),
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			// Add control for hero button text
			$wp_customize->add_control(
				'ipress_settings[hero_button_text]',
				[
					'label'       => __( 'Hero Button Text', 'ipress' ),
					'description' => esc_html__( 'Hero button text', 'ipress' ),
					'section'     => 'ipress_hero',
					'settings'    => 'ipress_settings[hero_button_text]',
					'type'        => 'text',
					'priority'    => 16,
				]
			);

			// Add setting & control for hero image
			$wp_customize->add_setting(
				'ipress_settings[hero_image]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => IPRESS_ASSETS_URL . '/images/hero.svg',
					'sanitize_callback' => 'ipress_sanitize_image',
				]
			);

			// Add control for hero image
			$wp_customize->add_control(
				new WP_Customize_Cropped_Image_Control(
					$wp_customize,
					'ipress_settings[hero_image]',
					[
						'label'       => __( 'Hero Image', 'ipress' ),
						'description' => esc_html__( 'Add the hero section background image', 'ipress' ),
						'section'     => 'ipress_hero',
						'settings'    => 'ipress_settings[hero_image]',
						'context'     => 'hero-image',
						'flex_width'  => true,
						'flex_height' => true,
						'width'       => 1240,
						'height'      => 480,
						'priority'    => 18,
					]
				)
			);

			// Add setting for hero background color
			$wp_customize->add_setting(
				'ipress_settings[hero_background_color]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '#c3f2f5',
					'sanitize_callback' => 'sanitize_hex_color',
				]
			);

			// Add control for hero background color
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'ipress_settings[hero_background_color]',
					[
						'label'       => __( 'Hero Background Color', 'ipress' ),
						'description' => esc_html__( 'Hero background color', 'ipress' ),
						'section'     => 'ipress_hero',
						'settings'    => 'ipress_settings[hero_background_color]',
						'priority'    => 20,
					]
				)
			);

			// Add setting & control for hero image overlay
			$wp_customize->add_setting(
				'ipress_settings[hero_overlay]',
				[
					'transport'         => 'refresh',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => 'ipress_sanitize_checkbox',
				]
			);

			// Add control for hero overlay
			$wp_customize->add_control(
				'ipress_settings[hero_overlay]',
				[
					'label'       => __( 'Hero Overlay', 'ipress' ),
					'description' => esc_html__( 'Display an overlay with opacity on the hero image.', 'ipress' ),
					'section'     => 'ipress_hero',
					'settings'    => 'ipress_settings[hero_overlay]',
					'type'		  => 'checkbox',
					'priority'    => 22,
				]
			);

			// Add setting & control for hero overlay color
			$wp_customize->add_setting(
				'ipress_settings[hero_overlay_color]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '#000',
					'sanitize_callback' => 'sanitize_hex_color',
				]
			);

			// Add control for hero overlay color
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'ipress_settings[hero_overlay_color]',
					[
						'label'       => __( 'Hero Overlay Color', 'ipress' ),
						'description' => esc_html__( 'Hero overlay color', 'ipress' ),
						'section'     => 'ipress_hero',
						'settings'    => 'ipress_settings[hero_overlay_color]',
						'priority'    => 24,
					]
				)
			);

			// Add setting for hero overlay opacity
			$wp_customize->add_setting(
				'ipress_settings[hero_overlay_opacity]',
				[
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => '80',
					'sanitize_callback' => 'absint',
					'validate_callback' => function ( $validity, $value ) {
						$value = intval( $value );
						if ( $value < 0 || $value > 100 ) {
							$validity->add( 'out_of_range', __( 'Value must be between 0 and 100', 'ipress' ) );
						}
						return $validity;
					},
				]
			);

			// Add control for hero overlay opacity
			$wp_customize->add_control(
				'ipress_settings[hero_overlay_opacity]',
				[
					'label'       => __( 'Hero Overlay Opacity', 'ipress' ),
					'description' => esc_html__( 'Hero overlay opacity', 'ipress' ),
					'section'     => 'ipress_hero',
					'settings'    => 'ipress_settings[hero_overlay_opacity]',
					'type'        => 'range',
					'input_attrs' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 5,
						'style' => 'width: 100%',
					],
					'priority'    => 26,
				]
			);

			// Plugable registrations - pass customizer manager object to theme settings filter
			do_action( 'ipress_customize_register_hero', $wp_customize );
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

			// Does the theme utilise a front-page hero section? Default, true
			$ip_custom_hero = (bool) apply_filters( 'ipress_custom_hero', true );
			if ( true === $ip_custom_hero ) {

				// Hero title markup
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_title',
					[
						'selector'        => '.hero-title',
						'settings'        => 'ipress_settings[hero_title]',
						'render_callback' => function() {
							return ipress_get_option( 'hero_title' );
						},
					]
				);

				// Hero description markup
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_description',
					[
						'selector'        => '.hero-description',
						'settings'        => 'ipress_settings[hero_description]',
						'render_callback' => function() {
							return ipress_get_option( 'hero_description' );
						},
					]
				);

				// Hero image markup
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_image',
					[
						'selector'        => '.hero-image img',
						'settings'        => 'ipress_settings[hero_image]',
						'render_callback' => 'ipress_hero_image',
					]
				);

				// Hero section background colour
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_background_color',
					[
						'selector'        => '#hero-css',
						'settings'        => 'ipress_settings[hero_background_color]',
						'render_callback' => 'ipress_hero_css',
					]
				);

				// Hero section button text
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_button_text',
					[
						'selector'        => '.hero .button',
						'settings'        => 'ipress_settings[hero_button_text]',
						'render_callback' => function() {
							return ipress_get_option( 'hero_button_text' );
						},
					]
				);

				// Hero section overlay colour
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_overlay_color',
					[
						'selector'        => '#hero-css',
						'settings'        => 'ipress_settings[hero_overlay_color]',
						'render_callback' => 'ipress_hero_css',
					]
				);

				// Hero section overlay opacity
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_overlay_opacity',
					[
						'selector'        => '#hero-css',
						'settings'        => 'ipress_settings[hero_overlay_opacity]',
						'render_callback' => 'ipress_hero_css',
					]
				);
			}
		}
	}

endif;

// Instantiate User Class
return IPR_Hero::Init();
