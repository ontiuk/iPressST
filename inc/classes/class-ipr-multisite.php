<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress MultiSite features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Multisite' ) ) :

	/**
	 * Set up multisite features
	 */
	final class IPR_Multisite {

		/**
		 * Current Blog ID
		 *
		 * @var integer
		 */
		private $current_blog_id;

		/**
		 * Current User
		 *
		 * @var integer
		 */
		private $current_user;

		/**
		 * Collection of blog objects
		 *
		 * @var array
		 */
		private $blogs = [];

		/**
		 * Collection of sites objects
		 *
		 * @var array
		 */
		private $sites = [];

		/**
		 * Class Constructor
		 */
		public function __construct() {

			// Not a multisite?
			if ( ! is_multisite() ) {
				return;
			}

			// Set up current blog id
			$this->current_blog_id = get_current_blog_id();

			// Set up current user - should be network admin, normally user_id: 1
			$this->current_user = current( $this->get_current_blog_users( 'ID', 1 ) );

			// Get list of blogs
			$this->blogs = apply_filters( 'ipress_multisite_blogs', $this->get_blogs_by_user() );
		}

		//------------------------------------------
		// Core Functions
		//------------------------------------------

		/**
		 * Get blogs by user ID
		 *
		 * @param integer $uid user ID
		 * @param boolean $all all users? default true
		 * @return array $blogs
		 */
		public function get_blogs_by_user( $uid = 0, $all = true ) {

			// Sanitize input
			$uid = absint( $uid );

			// Preset user ID, use current user ID if default
			$uid = ( 0 === $uid ) ? $this->current_user : $uid;

			// Get blogs for user or [], ignores deleted, archived, spam
			$blogs = get_blogs_of_user( $uid );

			// Set up the list of network sites
			$this->set_sites( $all );

			// Update blog list with sanitized ID and language
			foreach ( $blogs as $k => $blog ) {

				// Set ID & description
				$blogs[ $k ]->blog_id     = $blog->userblog_id;
				$blogs[ $k ]->description = sanitize_text_field( apply_filters( 'ipress_multisite_description', '', $blog->userblog_id ) );

				// Set language
				$blog_language         = (string) get_blog_option( $blog->userblog_id, 'WPLANG' );
				$blogs[ $k ]->language = ( empty( $blog_language ) ) ? 'us' : $blog_language;
				$blogs[ $k ]->alpha    = substr( $blogs[ $k ]->language, 0, 2 );

				// Set public value, see WordPress TRAC #48192
				$blogs[ $k ]->public = $this->get_site_by_id( $k )->public;
			}

			return $blogs;
		}

		/**
		 * Gets the registered users of the current blog
		 *
		 * @param string $fields get record set by field or all
		 * @param int|string $number record count, default -1 all
		 * @return array
		 */
		public function get_current_blog_users( $fields = 'all', $number = -1 ) {

			// Set get_users function args
			$args = [
				'blog_id' => $this->current_blog_id,
				'orderby' => 'registered',
				'fields'  => $fields,
				'number'  => $number,
			];

			return get_users( $args );
		}

		/**
		 * Check if user is a super admin
		 * - Defaults to current_user
		 *
		 * @param integer $uid user ID, default 0
		 * @return boolean
		 */
		public function is_super_admin( $uid = 0 ) {

			// Sanitize input
			$uid = absint( $uid );

			// Check UID, default to current user
			$uid = ( 0 === $uid ) ? $this->current_user : $uid;

			// Check user status
			return is_super_admin( $uid );
		}

		/**
		 * Check if a site is the main site
		 * - Defaults to current site ID
		 *
		 * @param integer $sid site ID, default 0
		 * @param integer $network_id network ID, default 0
		 * @return boolean
		 */
		public function is_main_site( $sid = 0, $network_id = 0 ) {

			// Sanitize input
			$sid        = absint( $sid );
			$network_id = absint( $network_id );

			// Check site ID, defaults to current blog ID
			$sid = ( 0 === $sid ) ? get_current_blog_id() : $sid;

			// Check SID, defaults to current network
			return ( $network_id > 0 ) ? is_main_site( $sid, $network_id ) : is_main_site( $sid );
		}

		/**
		 * Gets blog by language
		 *
		 * @param string $language
		 * @param boolean $alpha default false, uses language
		 * @return array|null $blog_id
		 */
		public function get_blog_by_language( $language, $alpha = false ) {

			// Set blog
			$blog_id = null;

			// Iterate blog list
			foreach ( $this->blogs as $blog ) {
				$blog_language = ( $alpha ) ? $blog->alpha : $blog->language;
				if ( $language === $blog_language ) {
					$blog_id = $blog->userblog_id;
					break;
				}
			}

			return $blog_id;
		}

		/**
		 * Checks if current blog is in the blogs list
		 *
		 * @return boolean
		 */
		public function has_current_blog() {
			return isset( $this->blogs[ $this->current_blog_id ] );
		}

		/**
		 * Gets current blog as object
		 *
		 * @return object|null
		 */
		public function get_current_blog() {
			return ( $this->has_current_blog() ) ? $this->blogs[ $this->current_blog_id ] : null;
		}

		/**
		 * Gets an array list of blog objects
		 *
		 * @param boolean $all true for all blogs, false removes current blog if set
		 * @return array
		 */
		public function get_blogs( $all = true ) {

			// Remove currrent blog?
			if ( true !== $all && $this->has_current_blog() ) {
				unset( $this->blogs[ $this->current_blog_id ] );
			}

			// Return blog list
			return $this->blogs;
		}

		/**
		 * Get the ID of the current blog
		 *
		 * @return integer
		 */
		public function get_current_blog_id() {
			return $this->current_blog_id;
		}

		/**
		 * Get blog option by ID
		 *
		 * @param string $option
		 * @param integer $blog_id blog ID, default 0, current blog ID
		 * @return object
		 */
		public function get_blog_option( $option, $blog_id = 0 ) {
			$blog_id = absint( $blog_id );
			return ( 0 === $blog_id ) ? get_blog_option( $option, $this->get_current_blog_id() ) : get_blog_option( $option, $blog_id );
		}

		/**
		 * Get blog details by ID
		 *
		 * @param integer $blog_id blog ID, default 0, current blog ID
		 * @return object WP_Site_Object
		 */
		public function get_blog_details_by_id( $blog_id = 0 ) {
			$blog_id = absint( $blog_id );
			return ( 0 === $blog_id ) ? get_blog_details( $this->get_current_blog_id() ) : get_blog_details( $blog_id );
		}

		//------------------------------------------
		// Additional Site Functions
		//------------------------------------------

		/**
		 * Set the current network sites
		 *
		 * @param boolean $all default true, all sites
		 */
		private function set_sites( $all = true ) {

			// Set site args
			$sites = [];
			$args  = [];

			// Get archived & trashed sites?
			if ( ! $all ) {
				$args['archived'] = 0;
				$args['spam']     = 0;
				$args['deleted']  = 0;
			}

			// Get network site list
			$_sites = get_sites( $args );

			// Iterate sites if set & set to key pair
			if ( is_array( $_sites ) ) {
				foreach ( $_sites as $site ) {
					$sites[ $site->id ] = (object) [
						'userblog_id' => $site->id,
						'blogname'    => $site->blogname,
						'domain'      => $site->domain,
						'path'        => $site->path,
						'site_id'     => $site->network_id,
						'siteurl'     => $site->siteurl,
						'archived'    => $site->archived,
						'mature'      => $site->mature,
						'spam'        => $site->spam,
						'deleted'     => $site->deleted,
						'public'      => $site->public,
					];
				}
			}

			// Get list of sites
			$this->sites = apply_filters( 'ipress_multisite_sites', $sites );
		}

		/**
		 * Get multisite sites
		 *
		 * @return array WP_Site_Object List
		 */
		public function get_sites() {
			return $this->sites;
		}

		/**
		 * Get the id of the current site
		 * - defaults to main site ID:1
		 *
		 * @param int|string $sid default 1, main site
		 * @return array|null
		 */
		public function get_site_by_id( $sid = 1 ) {
			$sid = absint( $sid );
			return ( 0 === $sid || ! array_key_exists( $sid, $this->sites, true ) ) ? null : $this->sites[ $sid ];
		}

		/**
		 * Get the current site or ID
		 *
		 * @param boolean $sid, default false, site object
		 * @return array|integer
		 */
		public function get_current_site( $sid = false ) {
			return ( true === $sid ) ? get_current_site()->blog_id : get_current_site();
		}
	}

endif;

// Instantiate Multisite Class
return new IPR_Multisite;
