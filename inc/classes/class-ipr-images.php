<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress images functionality.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Deny unauthorised access
defined( 'ABSPATH' ) ||	exit;

if ( ! class_exists( 'IPR_Images' ) ) :

	/**
	 * Set up image features
	 */
	final class IPR_Images extends IPR_Registry {

		/**
		 * Class constructor, protected, set hooks
		 */
		protected function __construct() {

			// Image size media editor support
			add_filter( 'image_size_names_choose', [ $this, 'media_images' ] );

			// Remove default image sizes
			add_filter( 'intermediate_image_sizes_advanced', [ $this, 'remove_default_image_sizes' ] );

			// Enable SVG mime type plus filterable other types
			add_filter( 'upload_mimes', [ $this, 'custom_upload_mimes' ] );

			// Custom avatar in settings > discussion
			add_filter( 'avatar_defaults', [ $this, 'custom_gravatar' ] );

			// Responsive image sizes for theme images
			add_filter( 'wp_calculate_image_sizes', [ $this, 'image_sizes' ], 10, 2 );

			// Provide media gallery svg thumbnail support
			add_filter( 'wp_prepare_attachment_for_js', [ $this, 'svg_media_thumbnails' ], 10, 3 );

			// Remove WordPress's default padding on images with captions
			add_filter( 'img_caption_shortcode_width', [ $this, 'image_caption_padding' ] );
		}

		//----------------------------------------------
		//	Image & Media Action & Filter Hooks
		//----------------------------------------------

		/**
		 * Image size media editor support
		 * 
		 * - Should match custom images from add_images_size
		 *
		 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/image_size_names_choose
		 *
		 * @param array $sizes List of image sizes
		 * @return array
		 */
		public function media_images( $sizes ) {

			// Filterable custom images
			$ip_media_images = (array) apply_filters( 'ipress_media_images', []	);

			return ( $ip_media_images ) ? $sizes : array_merge( $sizes, $ip_media_images );
		}

		/**
		 * Remove default image sizes
		 *
		 * unset( $sizes['thumbnail'] );
		 * unset( $sizes['medium'] );
		 * unset( $sizes['medium_large'] );
		 * unset( $sizes['large'] );
		 *
		 * @param array $sizes Default image sizes
		 * @return array
		 */
		public function remove_default_image_sizes( $sizes ) {
			return (array) apply_filters( 'ipress_media_images_sizes', $sizes );
		}

		/**
		 * Allow additional mime-types & force restrictions
		 *
		 * - Default to add SVG support
		 *
		 * - For example, the following line allows PDF uploads
		 * - $existing_mimes['pdf'] = 'application/pdf';
		 *
		 * @param array $mimes Mime types, default []
		 * @return array $mimes
		 */
		public function custom_upload_mimes( $mimes = [] ) {

			// Add the file extension to the list of valid mime types
			$ip_upload_mimes = (array) apply_filters(
				'ipress_upload_mimes',
				[
					'svg'  => 'image/svg+xml',
					'svgz' => 'image/svg+xml',
				]
			);

			// Restricted formats
			$ip_restricted = (array) apply_filters( 'ipress_restricted_mimes', [] );

			// Validate new mimes against restrictions
			$ip_upload_mimes = array_filter( $ip_upload_mimes, function( $mime, $key ) use ( $ip_restricted ) {
				return ( in_array( $key, $ip_restricted ) && ! current_user_can( 'manage_options' ) ) ? false : true;
			}, ARRAY_FILTER_USE_BOTH );

			// Add the file extension to the current mimes
			array_walk( $ip_upload_mimes, function( $mime, $key ) use ( &$mimes ) {
				if ( ! array_key_exists( $key, $mimes ) ) {
					$mimes[ $key ] = esc_attr( $mime );
				}
			} );
				
			return $mimes;
		}

		/**
		 * Add svg image support to media editor thumbnails - todo: add sanitizer class
		 *
		 * @param array $response Available mime types
		 * @param object $attachment Attachment object
		 * @param array $meta Meta data
		 * @return array $response
		 */
		public function svg_media_thumbnails( $response, $attachment, $meta ) {

			// Only if current type is svg
			if ( 'image' === $response['type'] && 'svg+xml' === $response['subtype'] ) {

				// get file path
				$path = get_attached_file( $attachment->ID );

				// validate file in path
				if ( file_exists( $path ) ) {

					// extract file data
					[ $width, $height, $type, $attr ] = getimagesize( $path );

					// Set src
					$src = $response['url'];

					// media gallery
					$response['image'] = compact( 'src', 'width', 'height' );
					$response['thumb'] = compact( 'src', 'width', 'height' );

					// media single
					$response['sizes']['full'] = [
						'height' => $height,
						'width' => $width,
						'url' => $src,
						'orientation' => $height > $width ? 'portrait' : 'landscape',
					];
				}
			}

			return $response;
		}

		/**
		 * Custom Gravatar in Settings > Discussion
		 *
		 * - Add as array ( 'name' => '', 'path' => '' )
		 *
		 * @param array $avatars Avatar list
		 * @return array $avatars
		 */
		public function custom_gravatar( $avatars ) {

			// Filterable markup
			$ip_gravatar = (array) apply_filters( 'ipress_custom_gravatar', [] );
			if ( $ip_gravatar ) {
	
				// Set avatar with caveats for index keys: path & name
				$ip_avatar_path = esc_url( $ip_gravatar['path'], false );
				$avatars[ $ip_avatar_path ] = $ip_gravatar['name'];
			}
			
			return $avatars;
		}

		/**
		 * Modify custom image sizes attribute for responsive image functionality
		 *
		 * @global $content_width
		 * @param string $sizes A source size value for use in a 'sizes' attribute
		 * @param array $size Image size [ width, height ]
		 * @return string
		 */
		public function image_sizes( $sizes, $size ) {

			global $content_width;

			$width = $size[0];
			return ( is_null( $content_width ) || $width < $content_width ) ? $sizes : '(min-width: ' . $content_width . 'px) ' . $content_width . 'px, 100vw';
		}

		/**
		 * Remove padding for images with captions
		 *
		 * @param integer $width Caption width
		 * @return integer
		 */
		public function image_caption_padding( $width ) {
			return $width - 10;
		}
	}

endif;

// Instantiate Images Class
return IPR_Images::Init();
