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
			
			// Output custom hero css
			add_action( 'wp_enqueue_scripts', [ $this, 'hero_css' ], 60 );

			// Set up hero css caching
			add_action( 'init', [ $this, 'set_hero_css_cache' ] );
			add_action( 'customize_save_after',  [ $this, 'update_hero_css_cache' ] );

			// Add custom hero image size
			add_filter( 'ipress_add_image_size', [ $this, 'hero_image_size' ], 10, 1 );
		}

		//----------------------------------------------
		//	Hero Customizer Functionality
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
					'title'           => __( 'Hero', 'ipress-standalone' ),
					'description'     => esc_html__( 'Front page hero image and details', 'ipress-standalone' ),
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
					'label'       => __( 'Front Page Hero Area', 'ipress-standalone' ),
					'description' => esc_html__( 'Display or hide the front page hero section.', 'ipress-standalone' ),
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
					'label'       => __( 'Hero Title', 'ipress-standalone' ),
					'description' => esc_html__( 'Modify the front page hero section title', 'ipress-standalone' ),
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
					'label'       => __( 'Hero Description', 'ipress-standalone' ),
					'description' => esc_html__( 'Modify the front page hero section description', 'ipress-standalone' ),
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
					'label'       => __( 'Button Page Link', 'ipress-standalone' ),
					'description' => esc_html__( 'Link to page via button', 'ipress-standalone' ),
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
					'default'           => esc_attr__( 'Learn More', 'ipress-standalone' ),
					'sanitize_callback' => 'sanitize_text_field',
				]
			);

			// Add control for hero button text
			$wp_customize->add_control(
				'ipress_settings[hero_button_text]',
				[
					'label'       => __( 'Hero Button Text', 'ipress-standalone' ),
					'description' => esc_html__( 'Hero button text', 'ipress-standalone' ),
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
						'label'       => __( 'Hero Image', 'ipress-standalone' ),
						'description' => esc_html__( 'Add the hero section background image', 'ipress-standalone' ),
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
						'label'       => __( 'Hero Background Color', 'ipress-standalone' ),
						'description' => esc_html__( 'Hero background color', 'ipress-standalone' ),
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
					'label'       => __( 'Hero Overlay', 'ipress-standalone' ),
					'description' => esc_html__( 'Display an overlay with opacity on the hero image.', 'ipress-standalone' ),
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
						'label'       => __( 'Hero Overlay Color', 'ipress-standalone' ),
						'description' => esc_html__( 'Hero overlay color', 'ipress-standalone' ),
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
							$validity->add( 'out_of_range', __( 'Value must be between 0 and 100', 'ipress-standalone' ) );
						}
						return $validity;
					},
				]
			);

			// Add control for hero overlay opacity
			$wp_customize->add_control(
				'ipress_settings[hero_overlay_opacity]',
				[
					'label'       => __( 'Hero Overlay Opacity', 'ipress-standalone' ),
					'description' => esc_html__( 'Hero overlay opacity', 'ipress-standalone' ),
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
						'render_callback' => [ 'IPR_Hero', 'HeroImage' ],
					]
				);

				// Hero section background colour
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_background_color',
					[
						'selector'        => '#hero-css',
						'settings'        => 'ipress_settings[hero_background_color]',
						'render_callback' => [ $this, 'get_hero_css' ],
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
						'render_callback' => [ $this, 'get_hero_css' ],
					]
				);

				// Hero section overlay opacity
				$wp_customize->selective_refresh->add_partial(
					'ipress_hero_overlay_opacity',
					[
						'selector'        => '#hero-css',
						'settings'        => 'ipress_settings[hero_overlay_opacity]',
						'render_callback' => [ $this, 'get_hero_css' ],
					]
				);
			}
		}

		//----------------------------------------------
		//	Hero CSS Functionality
		//----------------------------------------------

		/**
		 * Process Hero CSS if active
		 */
		public function hero_css() {

			$ip_custom_hero = (bool) apply_filters( 'ipress_custom_hero', true );
			if ( true === $ip_custom_hero ) {

				// Are we using caching?
				$ip_hero_css_cache = (bool) apply_filters( 'ipress_hero_css_cache', false );
	
				// Get css, cached if available
				$css = ( ( $ip_hero_css_cache && ! get_option( 'ipress_hero_css_cache', false ) ) || is_customize_preview() ) ? $this->get_hero_css() : get_option( 'ipress_hero_css_cache' );

				// Link to main style css handle
				if ( $css ) {
					wp_add_inline_style( 'ipress-standalone', wp_strip_all_tags( $css ) );
				}	
			}
		}
		
		/**
		 * Retrieve hero image if set
		 *
		 * @return string
		 */
		public function get_hero_css() {

			// Initiate CSS
			$css = new IPR_CSS;

			// Get theme values, default ''
			$ip_hero_background_color = ipress_get_option( 'hero_background_color', '' );

			// Add selector and property: .hero
			if ( $ip_hero_background_color ) {
				$css->set_selector( '.hero' );
				$css->add_property( 'position', 'relative' );
				$css->add_property( 'background-color', $ip_hero_background_color );
			}

			// Hero overlay
			$ip_hero_overlay = ipress_get_option( 'hero_overlay', false );
			if ( $ip_hero_overlay ) {

				// Overlay selectors	
				$ip_hero_overlay_color = ipress_get_option( 'hero_overlay_color', '' );
				$ip_hero_overlay_opacity = ipress_get_option( 'hero_overlay_opacity', 0 );

				// Add selector and properties: .hero-overlay
				if ( $ip_hero_overlay_color || $ip_hero_overlay_opacity ) {
					$css->set_selector( '.hero-overlay' );
				}

				// Overlay core selectors
				$css->add_property( 'position', 'absolute' );
				$css->add_property( 'width', '100%' ); $css->add_property(
					'height', '100%' );

				// Overlay selectors: color
				if ( $ip_hero_overlay_color ) {
					$css->add_property( 'background-color', $ip_hero_overlay_color );
				}

				// Overlay selectors: opacity, convert from %
				if ( $ip_hero_overlay_opacity ) {
					$css->add_property( 'opacity', ( $ip_hero_overlay_opacity / 100 ) );
				}
			}

			do_action( 'ipress_hero_css', $css );
			
			return apply_filters( 'ipress_hero_css', $css->css_output(), $css );
		}

		/**
		 * Sets hero CSS cache if required
		 */
		public function set_hero_css_cache() {

			global $ipress;
			
			// Filterable caching, default on
			$ip_hero_css_cache = (bool) apply_filters( 'ipress_hero_css_cache', false );
			if ( $ip_hero_css_cache ) {

				// Get current hero css cache
				$ip_hero_css_cache = get_transient( 'ipress_hero_css_cache' );
				$ip_hero_css_version = get_transient( 'ipress_hero_css_version' );

				// Test for cache and/or versioning change
				if ( ! $ip_hero_css_cache || $ipress->version !== $ip_hero_css_version ) {

					$hero_css = ( $this->get_hero_css() ) ? $this->get_hero_css() . '/* End cached CSS */' : '';
					$hero_css_version = $ipress->version;

					set_transient( 'ipress_hero_css_cache', wp_strip_all_tags( $hero_css ) );
					set_transient( 'ipress_hero_css_version', esc_attr( $hero_css_version ) );
				}
			}
		}

		/**
		 * Sets hero CSS cache if customizer data is updated
		 */
		public function update_hero_css_cache() {

			global $ipress;
			
			// Filterable caching, default on
			$ip_hero_css_cache = (bool) apply_filters( 'ipress_hero_css_cache', false );
			if ( $ip_hero_css_cache ) {

				// Update core hero css & versioning
				$hero_css = ( $this->get_hero_css() ) ? $this->get_hero_css() . '/* End cached CSS */' : '';
				$hero_css_version = $ipress->version;

				set_transient( 'ipress_hero_css_cache', wp_strip_all_tags( $hero_css ) );
				set_transient( 'ipress_hero_css_version', esc_attr( $hero_css_version ) );
			}
		}

		//----------------------------------------------
		//	Hero Image Functionality
		//----------------------------------------------

		/**
		 * Add custom hero image size
		 *
		 * @param array $sizes Image sizes
		 * @return array $sizes
		 */
		public function hero_image_size( $sizes ) {
			
			$ip_custom_hero = (bool) apply_filters( 'ipress_custom_hero', true );
			if ( true === $ip_custom_hero ) {
				$sizes['hero-image'] = [ 1080 ];
			}
			return $sizes;
		}

		/**
		 * Retrieve hero image if available
		 *
		 * @return string
		 */
		static public function HeroImage() {

			// Get hero image if set default 0
			$ip_hero_image_id = (int) ipress_get_option( 'hero_image', 0 );
			if ( $ip_hero_image_id > 0 ) {

				// Hero image details
				$hero_image = wp_get_attachment_image_src( $ip_hero_image_id, 'hero-image' );
				$hero_image_alt = trim( strip_tags( get_post_meta( $ip_hero_image_id, '_wp_attachment_image_alt', true ) ) );

				// Destruct image params
				[ $hero_image_src, $hero_image_width, $hero_image_height ] = $hero_image;

				// Set hero image class, default none
				$ip_hero_image_class = (array) apply_filters( 'ipress_hero_image_class', [] );
				$ip_hero_image_class = ( $ip_hero_image_class ) ? sprintf( 'class="%1$s"', join( ', ', array_map( 'sanitize_html', $ip_hero_image_class ) ) ) : '';
						
				// Set hero image
				$hero_image_hw = image_hwstring( $hero_image_width, $hero_image_height );

				return sprintf( '<img %1$s src="%2$s" %3$s alt="%4$s" />', $ip_hero_image_class, $hero_image_src, trim( $hero_image_hw ), $hero_image_alt );
			}

			return false;
		}
	}

endif;

// Instantiate User Class
return IPR_Hero::Init();
