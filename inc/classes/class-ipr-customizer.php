<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress theme customizer features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Customizer' ) ) :

	/**
	 * Initialise and set up Customizer features
	 */
	final class IPR_Customizer extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Core WordPress functionality
			add_action( 'after_setup_theme', [ $this, 'setup_theme' ], 12 );

			// Main customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register' ] );

			// Theme customizer custom JS registration
			add_action( 'customize_register', [ $this, 'customize_register_js' ] );

			// Theme customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register_theme' ] );

			// Theme customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register_partials' ], 12 );

			// Enqueue scripts for customizer controls and settings
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'customize_controls_enqueue_scripts' ] );

			// Enqueue scripts for customizer preview
			add_action( 'customize_preview_init', [ $this, 'customize_preview_init' ] );
		}

		/**
		 * Set up core theme settings & functionality
		 */
		public function setup_theme() {

			//----------------------------------------------------------------
			// Customizer Support & Layout
			//
			// - add_theme_support( 'custom-logo' )
			// - add_theme_support( 'custom-header' )
			// - register_default_headers()
			// - add_theme_support( 'custom-background' )
			// - add_theme_support( 'customize-selective-refresh-widgets' )
			//----------------------------------------------------------------

			/**
			 * Enable support for custom logo within customizer and theme
			 *
			 * @see https://developer.wordpress.org/themes/functionality/custom-logo/
			 * 
			 * custom_logo_args = [
			 *   'width'       => 250, // Expected logo height in pixels.
			 *   'height'      => 80, // Expected logo width in pixels.
			 *   'flex-width'  => true, // Allow for a flexible height, skips cropping.
			 *   'flex-height' => true, // Whether to allow for a flexible width, skips cropping.
			 *   'header-text' => [ 'site-title', 'site-description ] // Classes of elements to hide.
			 * ];
			 *
			 * No width & height sets full flexibility support
			 */

			// Custom logo settings, custom logo is enabled by default in customizer
			$ip_custom_logo_args = (array) apply_filters(
				'ipress_custom_logo_args',
				[
					'width'       => 200,
					'height'      => 133,
					'flex-width'  => true,
					'flex-height' => true,
				]
			);
			add_theme_support( 'custom-logo', $ip_custom_logo_args );

			/**
			 * Enable support for custom headers within customizer and theme
			 *
			 * @see https://developer.wordpress.org/themes/functionality/custom-headers/
			 * 
			 * $header_args = [
			 *   'default-image'          => apply_filters( 'ipress_custom_header_default_image', get_stylesheet_directory_uri() . '/assets/images/header.png' ),
			 *   'header-text'            => true,              // Display the header text along with the image.
			 *   'default-text-color'     => '000',             // Header text color default.
			 *   'width'                  => 0,                 // Header image width (in pixels).
			 *   'height'                 => 0,                 // Header image height (in pixels).
			 *   'flex-height'            => false,             // Flexible image width, skips the crop stage.
			 *   'flex-width'             => false,             // Flexible image height, skips the crop stage.
			 *   'random-default'         => false,             // Header image random rotation default.
			 *   'uploads'                => true,              // Enable upload of image file in admin.
			 *   'wp-head-callback'       => 'wphead_cb',       // Function to be called in theme head section.
			 *   'admin-head-callback'    => 'adminhead_cb',    // Function to be called in preview page head section.
			 *   'admin-preview-callback' => 'adminpreview_cb', // Function to produce preview markup in the admin screen.
			 *   'video'                  => false,             // Display video in background.
			 *   'video-active-callback'  => 'is_front_page'    // Function to be called in video playback.
			 * ];
			 */

			// Filterable custom header setttings, no width & height sets full flexibility, custom header is disabled by default
			$ip_custom_header = (bool) apply_filters( 'ipress_custom_header', false );
			if ( true === $ip_custom_header ) {

				// Set up default header image
				$ip_custom_header_default_image = (string) apply_filters( 'ipress_custom_header_default_image', get_stylesheet_directory_uri() . '/assets/images/header.png' );

				// Set up custom header args if required
				$ip_custom_header_args = (array) apply_filters(
					'ipress_custom_header_args',
					[
						'default-image' => ( empty( $ip_custom_header_default_image ) ) ? '' : esc_url_raw( $ip_custom_header_default_image ),
						'header-text'   => false,
						'width'         => 1600,
						'height'        => 325,
						'flex-width'    => true,
						'flex-height'   => true,
					]
				);
				add_theme_support( 'custom-header', $ip_custom_header_args );

				// Force custom header uploads, requires custom headers to be active
				$ip_custom_header_uploads = (bool) apply_filters( 'ipress_custom_header_uploads', false );
				if ( true === $ip_custom_header_uploads ) {
					add_theme_support( 'custom-header-uploads' );
				}

				/**
				 * Register default headers
				 *
				 * @see https://codex.wordpress.org/Function_Reference/register_default_headers
				 *
				 * register_default_headers(
				 *   apply_filters(
				 *     'ipress_default_header_args',
				 *     [
				 *       'default-image-1' => [
				 *         'url'           => '%s/assets/images/header.jpg',
				 *         'thumbnail_url' => '%s/assets/images/header.jpg',
				 *         'description'   => __( 'Default Header Image', 'ipress' ),
				 *       ],
				 *       'default-image-2' => [
				 *         'url'           => '%s/assets/images/header-alt.jpg',
				 *         'thumbnail_url' => '%s/assets/images/header-alt.jpg',
				 *         'description'   => __( 'Default Header Image Alt', 'ipress' ),
				 *       ],
				 *     ]
				 *   )
				 * );
				 */

				// Filterable default header settings
				$ip_default_headers = (bool) apply_filters( 'ipress_default_headers', false );
				if ( true === $ip_default_headers ) {

					// Set up default header args
					$ip_default_header_args = (array) apply_filters( 'ipress_default_header_args', [] );

					// Register default headers if set
					if ( $ip_default_header_args ) {
						register_default_headers( $ip_default_header_args );
					}
				}
			}

			/**
			 * Enable support for custom backgrounds - default false
			 * 
			 * @see https://codex.wordpress.org/Custom_Backgrounds
			 * 
			 * $background_args = [
			 *   'default-image'          => apply_filters( 'ipress_custom_background_default_image', '' ),       // Default background image
			 *   'default-color'          => apply_filters( 'ipress_custom_background_default_color', 'ffffff' ), // Default background colour applied
			 *   'default-preset'         => 'default',  // Default image preset ( 'default', 'fill', 'fit', 'repeat', 'custom' ).
			 *   'default-position-x'     => 'left',     // Default image x-position ( 'left', 'center', 'right' ).
			 *   'default-position-y'     => 'top',      // Default image y-position ( 'top', 'center', 'bottom' ).
			 *   'default-size'           => 'auto',     // Default image sizing attribute ( 'auto', 'contain', 'cover' ).
			 *   'default-repeat'         => 'repeat',   // Default image repeat attribute ( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ).
			 *   'default-attachment'     => 'scroll',   // Default image attachment attribute ( 'scroll', 'fixed' ).
			 *   'admin-head-callback'    => '',         // Function to be called in preview page head section.
			 *   'admin-preview-callback' => '',         // Function to produce preview markup in the admin screen.
			 *   'wp-head-callback'       => '_custom_background_cb', // Function to be called in theme head section.
			 * ];
			 */

			// Filterable custom background settings
			$ip_custom_background = (bool) apply_filters( 'ipress_custom_background', false );
			if ( true === $ip_custom_background ) {

				// Set up a custm background image
				$ip_custom_background_default_image = (string) apply_filters( 'ipress_custom_background_default_image', '' );

				// Set up a default background colour
				$ip_custom_background_default_color = (string) apply_filters( 'ipress_custom_background_default_color', '#ffffff' );

				// Set up the default background image args from above
				$ip_custom_background_args = (array) apply_filters(
					'ipress_custom_background_args',
					[
						'default-image' => ( empty( $ip_custom_background_default_image ) ) ? '' : esc_url_raw( $ip_custom_background_default_image ),
						'default-color' => ( empty( $ip_custom_background_default_color ) ) ? '' : sanitize_hex_color( $ip_custom_background_default_color ),
					]
				);
				add_theme_support( 'custom-background', $ip_custom_backround_args );
			}

			// Add theme support for selective refresh for widgets, default true
			$ip_custom_selective_refresh = (bool) apply_filters( 'ipress_custom_selective_refresh', true );
			if ( true === $ip_custom_selective_refresh ) {
				add_theme_support( 'customize-selective-refresh-widgets' );
			}

			// Theme initialization
			do_action( 'ipress_setup_customizer' );
		}

		//----------------------------------------------
		//	Customizer Settings, Controls & Scripts
		//----------------------------------------------

		/**
		 * Set up customizer and theme panel
		 *
		 * - Child theme extends settings and controls
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register( WP_Customize_Manager $wp_customize ) {

			// Modify default controls
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';

			// Register Control Types for dynamic JS access
			$wp_customize->register_control_type( 'IPR_Checkbox_Multiple_Control' );
			$wp_customize->register_control_type( 'IPR_Separator_Control' );

			// Dynamic refresh for header partials, default true
			$ip_customize_header_partials = (bool) apply_filters( 'ipress_customize_header_partials', true );

			// Set titles & branding as refreshable tags if allowed
			if ( true === $ip_customize_header_partials && isset( $wp_customize->selective_refresh ) ) {

				// Blog name
				$wp_customize->selective_refresh->add_partial(
					'blogname',
					[
						'selector' => '.site-title a',
						'render_callback' => function() {
							return get_bloginfo( 'name', 'display' );
						},
					]
				);

				// Blog description
				$wp_customize->selective_refresh->add_partial(
					'blogdescription',
					[
						'selector' => '.site-description',
						'render_callback' => function() {
							return get_bloginfo( 'description', 'display' );
						},
					]
				);

				// Custom logo image
				$wp_customize->selective_refresh->add_partial(
					'custom_logo',
					[
						'selector' => '.site-branding',
						'render_callback' => function() {
							return ipress_site_title_or_logo( false );
						},
					]
				);
			}

			// Register external customizer control types for dynamic JS access
			$ip_customize_register_control_type = (array) apply_filters( 'ipress_customize_register_control_type', [] );
			if ( $ip_customize_register_control_type ) {
				array_walk( $ip_customize_register_control_type, function( $control, $k ) use ( $wp_customize ) {
					$wp_customize->register_control_type( $control );
				} );
			}	

			// Register external customizer section types
			$ip_customize_register_section_type = (array) apply_filters( 'ipress_customize_register_section_type', [] );
			if ( $ip_customize_register_section_type ) {
				array_walk( $ip_customize_register_section_type, function( $section, $k ) use ( $wp_customize ) {
					$wp_customize->register_control_type( $section );
				} );
			}

			// Custom background & header usage?
			$ip_custom_background = (bool) apply_filters( 'ipress_custom_background', false );
			$ip_custom_header = (bool) apply_filters( 'ipress_custom_header', false );

			// Option defaults
			$defaults = ipress_get_defaults();

			// Modify background section if custom background available
			if ( true === $ip_custom_background ) {

				// Change background image section title & priority if custom background image is active
				$wp_customize->get_section( 'background_image' )->title    = __( 'Background', 'ipress' );
				$wp_customize->get_section( 'background_image' )->priority = 30;

				// Move background color setting alongside background image if custom background image is active
				$wp_customize->get_control( 'background_color' )->section  = 'background_image';
				$wp_customize->get_control( 'background_color' )->priority = 20;
			}

			// Change header image section title & priority if custom header image is active
			if ( true === $ip_custom_header ) {
				$wp_customize->get_section( 'header_image' )->title    = __( 'Header', 'ipress' );
				$wp_customize->get_section( 'header_image' )->priority = 25;
			}

			// Change the default priority if custom header or background is available
			if ( true === $ip_custom_header || true === $ip_custom_background ) {
				$wp_customize->get_section( 'colors' )->priority = 90;
			}

			//----------------------------------------------
			//	Sections
			//----------------------------------------------

			// Add a footer/copyright information section.
			$wp_customize->add_section(
				'ipress_footer',
				[
					'title'       => __( 'Footer', 'ipress' ),
					'description' => esc_html__( 'Footer content', 'ipress' ),
					'priority'    => 150, // Before Default & After Front Page.
				]
			);

			//----------------------------------------------
			//	Settings & Controls
			//----------------------------------------------

			// Add a retina logo option
			$wp_customize->add_setting(
				'ipress_settings[retina_logo]',
				[
					'default' => $defaults['retina_logo'],
					'type' => 'option',
					'sanitize_callback' => 'esc_url_raw',
				]
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'ipress_settings[retina_logo]',
					[
						'label' => __( 'Retina Logo', 'ipress' ),
						'section' => 'title_tagline',
						'settings' => 'ipress_settings[retina_logo]',
						'priority' => 15,
						'active_callback' => function() {
							return get_theme_mod( 'custom_logo' ) ? true : false;
						}
					]
				)
			);

			// Add 'title_and_tagline' setting for displaying the site-title & tagline +/- logo.
			$wp_customize->add_setting(
				'ipress_settings[title_and_tagline]',
				[
					'default'			=> $defaults['title_and_tagline'],
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => 'ipress_sanitize_checkbox',			
				]
			);

			// Add control for the "display_title_and_tagline" setting.
			$wp_customize->add_control(
				'ipress_settings[title_and_tagline]',
				[
					'type'    => 'checkbox',
					'section' => 'title_tagline',
					'label'   => esc_html__( 'Display Site Title & Tagline', 'ipress' ),
				]
			);

			// Plugable registrations - pass customizer manager object
			do_action( 'ipress_customize_register', $wp_customize );
		}

		/**
		 * Set up customizer custom JS settings
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register_js( WP_Customize_Manager $wp_customize ) {

			// Filterable custom JS sections, default false
			$ip_custom_js = (bool) apply_filters( 'ipress_custom_js', false );
			if ( true !== $ip_custom_js ) {
				return;
			}

			// Option defaults
			$defaults = ipress_get_defaults();

			// Add section for additional scripts: header & footer
			$wp_customize->add_section(
				'ipress_custom_js',
				[
					'title'       => __( 'Additional JS', 'ipress' ),
					'description' => esc_html__( 'Add custom header & footer js.', 'ipress' ),
					'priority'    => 210,
				]
			);

			// Add settings for custom header scripts section
			$wp_customize->add_setting(
				'ipress_settings[header_js]',
				[
					'default'			=> $defaults['header_js'],
					'transport'         => 'refresh',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post',
				]
			);

			// Add control for custom header scripts section
			$wp_customize->add_control(
				new WP_Customize_Code_Editor_Control(
					$wp_customize,
					'ipress_settings[header_js]',
					[
						'label'       => __( 'Custom header JS', 'ipress' ),
						'description' => esc_html__( 'Custom inline header js. Exclude <script></script> tag.', 'ipress' ),
						'code_type'   => 'javascript',
						'section'     => 'ipress_custom_js',
						'settings'    => 'ipress_settings[header_js]',
						'priority'    => 10,
					]
				)
			);

			// Add settings and controls for custom scripts section
			$wp_customize->add_setting(
				'ipress_settings[footer_js]',
				[
					'default'			=> $defaults['footer_js'],
					'transport'         => 'refresh',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post',
				]
			);

			// Add control for custom footer scripts section
			$wp_customize->add_control(
				new WP_Customize_Code_Editor_Control(
					$wp_customize,
					'ipress_settings[footer_js]',
					[
						'label'       => __( 'Custom footer JS', 'ipress' ),
						'description' => esc_html__( 'Custom inline footer js. Exclude <script></script> tag.', 'ipress' ),
						'code_type'   => 'javascript',
						'section'     => 'ipress_custom_js',
						'settings'    => 'ipress_settings[footer_js]',
						'priority'    => 12,
					]
				)
			);

			// Add settings and controls for custom scripts section
			$wp_customize->add_setting(
				'ipress_settings[header_admin_js]',
				[
					'default'			=> $defaults['header_admin_js'],
					'transport'         => 'refresh',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post',
				]
			);

			// Add controls for custom header admin scripts section
			$wp_customize->add_control(
				new WP_Customize_Code_Editor_Control(
					$wp_customize,
					'ipress_settings[header_admin_js]',
					[
						'label'       => __( 'Custom admin header JS', 'ipress' ),
						'description' => esc_html__( 'Custom inline admin header js. Exclude <script></script> tag.', 'ipress' ),
						'code_type'   => 'javascript',
						'section'     => 'ipress_custom_js',
						'settings'    => 'ipress_settings[header_admin_js]',
						'priority'    => 14,
					]
				)
			);

			// Add settings and controls for custom scripts section
			$wp_customize->add_setting(
				'ipress_settings[footer_admin_js]',
				[
					'default'			=> $defaults['footer_admin_js'],
					'transport'         => 'refresh',
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'wp_kses_post',
				]
			);

			// Add controls for custom footer admin scripts section
			$wp_customize->add_control(
				new WP_Customize_Code_Editor_Control(
					$wp_customize,
					'ipress_settings[footer_admin_js]',
					[
						'label'       => __( 'Custom admin footer JS', 'ipress' ),
						'description' => esc_html__( 'Custom inline admin footer js. Exclude <script></script> tag.', 'ipress' ),
						'code_type'   => 'javascript',
						'section'     => 'ipress_custom_js',
						'settings'    => 'ipress_settings[footer_admin_js]',
						'priority'    => 16,
					]
				)
			);


			// Plugable registrations - pass customizer manager object to theme settings filter
			do_action( 'ipress_customize_register_js', $wp_customize );
		}

		/**
		 * Set up customizer and theme specific settings
		 * - Fonts & typography
		 * - Background & header colours
		 * - Button and text colours
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register_theme( WP_Customize_Manager $wp_customize ) {

			// Define settings & partials based on if selective refresh is active
			$transport = ( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

			// Option defaults
			$defaults = ipress_get_defaults();

			// Add the primary theme section. Won't show until settings & controls added
			$wp_customize->add_section(
				'ipress_theme',
				[
					'title'       => __( 'Theme', 'ipress' ),
					'description' => esc_html__( 'Add theme specific settings.', 'ipress' ),
					'capability'  => 'edit_theme_options',
					'priority'    => 250,
				]
			);

			// ----------------------------------------------
			// Theme setting: breadcrumbs
			// ----------------------------------------------

			// Add setting for breadcrumbs
			$wp_customize->add_setting(
				'ipress_settings[breadcrumbs]',
				[
					'default'			=> $defaults['breadcrumbs'],
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => 'ipress_sanitize_checkbox',
				]
			);

			// Add checkbox control for breadcrumbs setting
			$wp_customize->add_control(
				'ipress_settings[breadcrumbs]',
				[
					'label'       => __( 'Breadcrumbs', 'ipress' ),
					'description' => esc_html__( 'Display or hide the inner page breadcrumbs.', 'ipress' ),
					'type'        => 'checkbox',
					'section'     => 'ipress_theme',
					'priority'    => 20,
				]
			);

			// ----------------------------------------------
			// Theme setting: back_to_top
			// ----------------------------------------------

			// Add setting for back to top link
			$wp_customize->add_setting(
				'ipress_settings[back_to_top]',
				[
					'default'			=> $defaults['back_to_top'],
					'transport'         => $transport,
					'type'              => 'option',
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => 'ipress_sanitize_checkbox',
				]
			);

			// Add checkbox control for back to top setting
			$wp_customize->add_control(
				'ipress_settings[back_to_top]',
				[
					'label'       => __( 'Back To Top', 'ipress' ),
					'description' => esc_html__( 'Display or hide the back to top link.', 'ipress' ),
					'type'        => 'checkbox',
					'section'     => 'ipress_theme',
					'priority'    => 30,
				]
			);

			// Section separator
			$wp_customize->add_setting(
				'ipress_breadcrumbs_sep',
				[ 'sanitize_callback' => '__return_true' ]
			);

			$wp_customize->add_control(
				new IPR_Separator_Control(
					$wp_customize,
					'ipress_breadcrumbs_sep',
					[
						'section'  => 'ipress_theme',
						'priority' => 100,
					]
				)
			);

			// ----------------------------------------------
			// Theme settings
			// ----------------------------------------------

			// Plugable registrations - pass customizer manager object
			do_action( 'ipress_customize_register_theme', $wp_customize );
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

			// ----------------------------------------------
			// Theme partials
			// ----------------------------------------------

			// Plugable registrations - pass customizer manager object
			do_action( 'ipress_customize_register_partials', $wp_customize );
		}

		//----------------------------------------------
		// Load Control and Preview Scripts & Styles
		//----------------------------------------------

		/**
		 * Enqueue scripts for the customizer settings & controls
		 */
		public function customize_controls_enqueue_scripts() {
			$theme_version = wp_get_theme()->get( 'Version' );
			wp_enqueue_script( 'ipress-customize', IPRESS_ASSETS_URL . '/js/customize.js', [ 'jquery' ], $theme_version, false );
			wp_enqueue_script( 'ipress-customize-controls', IPRESS_ASSETS_URL . '/js/customize-controls.js', [ 'customize-controls', 'underscore', 'jquery' ], $theme_version, false );
		}

		/**
		 * Enqueue scripts for the customizer preview
		 */
		public function customize_preview_init() {
			$theme_version = wp_get_theme()->get( 'Version' );
			wp_enqueue_script( 'ipress-customize-preview', IPRESS_ASSETS_URL . '/js/customize-preview.js', [ 'customize-preview', 'customize-selective-refresh', 'jquery' ], $theme_version, true );
		}
	}

endif;

// Instantiate Customizer class
return IPR_Customizer::Init();
