<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Add search engine structured data functionality.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Structured_Data' ) ) :

	/**
	 * Set up admin functionality
	 */ 
	final class IPR_Structured_Data {

		/**
		 * Stores the structured data.
		 *
		 * @var array $_data Array of structured data.
		 */
		private $_data = array();

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Generate structured data.
			add_action( 'ipress_before_main_content', 		[ $this, 'generate_structured_data' ], 	30 );
//			add_action( 'ipress_breadcrumb', 				[ $this, 'generate_breadcrumb_data' ], 	10 );
			
//			add_action( 'woocommerce_single_product_summary', array( $this, 'generate_product_data' ), 60 );
//			add_action( 'woocommerce_email_order_details', array( $this, 'generate_order_data' ), 20, 3 );

			// Output structured data.
			//add_action( 'woocommerce_email_order_details', array( $this, 'output_email_structured_data' ), 30, 3 );
			add_action( 'wp_footer', 						[ $this, 'output_structured_data' ], 	10 );		
		}

		//----------------------------------------------
		//	Structured Data Functions
		//----------------------------------------------

		/**
		 * Sets data.
		 *
		 * @param	array	$data	Structured data.
		 * @param 	bool	$reset	Unset data (default: false).
		 * @return	bool
		 */
		public function set_data( $data, $reset = false ) {

			// No, or invalid, data type?
			if ( ! isset( $data['@type'] ) || ! preg_match( '|^[a-zA-Z]{1,20}$|', $data['@type'] ) ) {
				return false;
			}

			// Are we initially resetting the data
			if ( $reset && isset( $this->_data ) ) {
				unset( $this->_data );
			}

			// Set data
			$this->_data[] = $data;

			return true;
		}

		/**
		 * Get the structured data.
		 *
		 * @return array
		 */
		public function get_data() {
			return $this->_data;
		}

		/**
		 * Structures and returns data.
		 *
		 * List of types available by default for specific request:
		 *
		 * 'product',
		 * 'review',
		 * 'breadcrumb',
		 * 'website',
		 * 'order',
		 *
		 * @param  array $types Structured data types.
		 * @return array
		 */
		public function get_structured_data( $types ) {
			$data = array();

			// Put together the values of same type of structured data.
			foreach ( $this->get_data() as $value ) {
				$data[ strtolower( $value['@type'] ) ][] = $value;
			}

			// Wrap the multiple values of each type inside a graph... Then add context to each type.
			foreach ( $data as $type => $value ) {
				$data[ $type ] = count( $value ) > 1 ? array( '@graph' => $value ) : $value[0];
				$data[ $type ] = apply_filters( 'woocommerce_structured_data_context', array( '@context' => 'https://schema.org/' ), $data, $type, $value ) + $data[ $type ];
			}

			// If requested types, pick them up... Finally change the associative array to an indexed one.
			$data = $types ? array_values( array_intersect_key( $data, array_flip( $types ) ) ) : array_values( $data );

			if ( ! empty( $data ) ) {
				if ( 1 < count( $data ) ) {
					$data = apply_filters( 'woocommerce_structured_data_context', array( '@context' => 'https://schema.org/' ), $data, '', '' ) + array( '@graph' => $data );
				} else {
					$data = $data[0];
				}
			}

			return $data;
		}

		/**
		 * Get data types for pages.
		 *
		 * @return array
		 */
		protected function get_data_type_for_page() {
			$types   = [];
//			$types[] = is_shop() || is_product_category() || is_product() ? 'product' : '';
//			$types[] = is_shop() && is_front_page() ? 'website' : '';
//			$types[] = is_product() ? 'review' : '';
//			$types[] = 'breadcrumblist';
//			$types[] = 'order';

			$types[] = ( is_front_page() ) ? 'website' : '';


			return array_filter( apply_filters( 'ipress_structured_data_type_for_page', $types ) );
		}

		//----------------------------------------------
		//	Markup Generation Functions
		//----------------------------------------------

		/**
		 * Generates main site structured data.
		 *
		 * Hooked into 'ipress_before_main_content' action hook.
		 */
		public function generate_structured_data() {
			
			// Vendor page restrictions: Woocommerce, deals with its own json data
			if ( $this->is_woocommerce_page() ) { return; }

			// Initiate JSON
			$markup                    = [];
			$markup['@type']           = 'WebSite';
			$markup['name']            = get_bloginfo( 'name' );
			$markup['url']             = home_url();

			// Search page?
			if ( is_search() ) {

				// Get available custom post types
				$post_type_args = [
					'public'   	=> true,
					'_builtin' 	=> false
				];
				$post_types = get_post_types( $args, 'names' );

				// Custom post type, if set
				$post_type = get_post_type();

				// Add search markup, test for post-type
				$markup['potentialAction'] = [
					'@type'       => 'SearchAction',
					'target'      => ( empty( $post_type ) || ! in_array( $post_type, $post_types ) ) ? home_url( '?s={search_term_string}' ) : home_url( '?s={search_term_string}&post_type=' . $post_type ),
					'query-input' => 'required name=search_term_string',
				];
			}

			// Initiate main structured data
			$this->set_data( apply_filters( 'ipress_structured_data', $markup ) );
		}

		/**
		 * Generates BreadcrumbList structured data.
		 *
		 * Hooked into ipress_breadcrumb action hook.
		 *
		 * @param	IPR_Breadcrumb	$breadcrumbs	Breadcrumb data.
		 */
		public function generate_breadcrumblist_data( $breadcrumbs ) {
			$crumbs = $breadcrumbs->get_breadcrumb();

			if ( empty( $crumbs ) || ! is_array( $crumbs ) ) {
				return;
			}

			$markup                    = array();
			$markup['@type']           = 'BreadcrumbList';
			$markup['itemListElement'] = array();

			foreach ( $crumbs as $key => $crumb ) {
				$markup['itemListElement'][ $key ] = array(
					'@type'    => 'ListItem',
					'position' => $key + 1,
					'item'     => array(
						'name' => $crumb[0],
					),
				);

				if ( ! empty( $crumb[1] ) ) {
					$markup['itemListElement'][ $key ]['item'] += array( '@id' => $crumb[1] );
				} elseif ( isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
					$current_url = set_url_scheme( 'http://' . wp_unslash( $_SERVER['HTTP_HOST'] ) . wp_unslash( $_SERVER['REQUEST_URI'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

					$markup['itemListElement'][ $key ]['item'] += array( '@id' => $current_url );
				}
			}

			$this->set_data( apply_filters( 'ipress_structured_data_breadcrumblist', $markup, $breadcrumbs ) );
		}

		/**
		 *	Generate post data
		 */
		public function generate_post_data() {

			// Must be in the loop
			if ( ! in_the_loop() ) { return; }

			// Post Type structured data.
			if ( is_home() || is_category() || is_date() || is_search() || is_single() ) {

				$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
				$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

				$json['@type']            = 'BlogPosting';

				$json['mainEntityOfPage'] = array(
					'@type'                 => 'webpage',
					'@id'                   => get_the_permalink(),
				);

				$json['publisher']        = array(
					'@type'                 => 'organization',
					'name'                  => get_bloginfo( 'name' ),
					'logo'                  => array(
						'@type'               => 'ImageObject',
						'url'                 => $logo[0],
						'width'               => $logo[1],
						'height'              => $logo[2],
					),
				);

				$json['author']           = array(
					'@type'                 => 'person',
					'name'                  => get_the_author(),
				);

				if ( $image ) {
					$json['image']            = array(
						'@type'                 => 'ImageObject',
						'url'                   => $image[0],
						'width'                 => $image[1],
						'height'                => $image[2],
					);
				}

				$json['datePublished']    = get_post_time( 'c' );
				$json['dateModified']     = get_the_modified_date( 'c' );
				$json['name']             = get_the_title();
				$json['headline']         = $json['name'];
				$json['description']      = get_the_excerpt();

			}
			$this->set_data( apply_filters( 'ipress_structured_data_post', $markup, $post ) );

		}

		/**
		 * Generate search page data
		 */
		public function generate_search_data() {

			// Search page only? i.e. home page with header search i.e. one with a search form? js element search?

/*
“@context”: “http://schema.org”,
“@type”: “WebSite”,
“url”: “https://www.example.com/”,
“potentialAction”: {
“@type”: “SearchAction”,
“target”: “https://query.example.com/search?q={search_term_string}”,
“query-input”: “required name=search_term_string”
}
}
 */
		}

		/**
		 * Generate page data
		 */
		
		/**
		 * Generates Review structured data.
		 *
		 * Hooked into `woocommerce_review_meta` action hook.
		 *
		 * @param WP_Comment $comment Comment data.
		 */
		public function generate_review_data( $comment ) {
			$markup                  = array();
			$markup['@type']         = 'Review';
			$markup['@id']           = get_comment_link( $comment->comment_ID );
			$markup['datePublished'] = get_comment_date( 'c', $comment->comment_ID );
			$markup['description']   = get_comment_text( $comment->comment_ID );
			$markup['itemReviewed']  = array(
				'@type' => 'Product',
				'name'  => get_the_title( $comment->comment_post_ID ),
			);

			// Skip replies unless they have a rating.
			$rating = get_comment_meta( $comment->comment_ID, 'rating', true );

			if ( $rating ) {
				$markup['reviewRating'] = array(
					'@type'       => 'Rating',
					'bestRating'  => '5',
					'ratingValue' => $rating,
					'worstRating' => '1',
				);
			} elseif ( $comment->comment_parent ) {
				return;
			}

			$markup['author'] = array(
				'@type' => 'Person',
				'name'  => get_comment_author( $comment->comment_ID ),
			);

			$this->set_data( apply_filters( 'woocommerce_structured_data_review', $markup, $comment ) );
		}

		//----------------------------------------------
		//	Render Data Functions
		//----------------------------------------------

		/**
		 * Sanitizes, encodes and outputs structured data.
		 *
		 * Hooked into `wp_footer` action hook.
		 * Hooked into `woocommerce_email_order_details` action hook.
		 */
		public function output_structured_data() {
			$types = $this->get_data_type_for_page();
			$data  = $this->get_structured_data( $types );

			if ( $data ) {
				echo '<script type="application/ld+json">' . wc_esc_json( wp_json_encode( $data ), true ) . '</script>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		//----------------------------------------------
		//	Vendor Restriction Functions
		//----------------------------------------------

		/**
		 * Woocommerce handles its own data
		 *
		 * @return boolean
		 */
		private function is_woocommerce_page() {

			// Check if woocommerce enabled
			if ( ! ipress_wc_active() ) { return false; }

			// Check is we're on a Woocommerce page
			return ( ipress_wc_archive() || ipress_is_wc_page() ) ? true : false;
		}
	}

endif;

// Instantiate Structured Data class
return new IPR_Structured_Data;

//end
