<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Add Schema.org html markup, with override.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Schema' ) ) :

	/**
	 * Set up schema functionality
	 */ 
	final class IPR_Schema {

		/**
		 * Schema microdata elements
		 *
		 * @var	array	$elements
		 */
		private $elements = [ 
			'head', 'body', 'site-header', 'site-title', 'site-description',
			'breadcrumb', 'breadcrumb-item', 'breadcrumb-link', 'breadcrumb-text',
			'search-form', 'search-form-meta', 'search-form-input',
			'nav-item', 'nav-link-attr', 'nav-item-title',
			'article', 'article-title',	'article-image', 'widget-image',
			'article-author', 'article-author-link', 'article-author-name',	
			'article-time', 'article-modified-time', 'article-content',
			'comment', 'sidebar' 
		];

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Schema: structure & header
			add_filter( 'ipress_schema_head', 					[ $this, 'head' ], 						10, 1 );			
			add_filter( 'ipress_schema_body', 					[ $this, 'body' ],  					10, 1 );
			add_filter( 'ipress_schema_site-header', 			[ $this, 'site_header' ], 				10, 1 );
			add_filter( 'ipress_schema_site-title', 			[ $this, 'site_title' ],				10, 1 );
			add_filter( 'ipress_schema_site-description', 		[ $this, 'site_description' ],			10, 1 );

			// Schema: breadcrumbs
			add_filter( 'ipress_schema_breadcrumb',		 		[ $this, 'breadcrumb' ],				10, 1 );
			add_filter( 'ipress_schema_breadcrumb-item',		[ $this, 'breadcrumb_item' ],		 	10, 1 );
			add_filter( 'ipress_schema_breadcrumb-link', 		[ $this, 'breadcrumb_link' ], 			10, 1 );
			add_filter( 'ipress_schema_breadcrumb-text', 		[ $this, 'breadcrumb_text' ], 			10, 1 );

			// Schema: search
			add_filter( 'ipress_schema_search-form', 			[ $this, 'search_form' ],				10, 1 );
			add_filter( 'ipress_schema_search-form-meta',	 	[ $this, 'search_form_meta' ],			10, 1 );
			add_filter( 'ipress_schema_search-form-input', 		[ $this, 'search_form_input' ], 		10, 1 );
			
			// Schema: navigation
			add_filter( 'ipress_schema_nav-item', 				[ $this, 'nav_item' ], 					10, 1 );
			add_filter( 'nav_menu_link_attributes', 			[ $this, 'nav_link_attr' ], 			10, 3 );
			add_filter( 'nav_menu_item_title',					[ $this, 'nav_item_title' ], 			10, 1 );

			// Schema: content
			add_filter( 'ipress_schema_article', 				[ $this, 'article' ],					10, 1 );
			add_filter( 'ipress_schema_article-title', 			[ $this, 'article_title' ], 			10, 1 );
			add_filter( 'ipress_schema_article-image', 			[ $this, 'article_image' ],				10, 1 );
			add_filter( 'ipress_schema_widget-image', 			[ $this, 'widget_image' ], 				10, 1 );
			add_filter( 'ipress_schema_article-author', 		[ $this, 'article_author' ],			10, 1 );
			add_filter( 'ipress_schema_article-author-link',	[ $this, 'article_author_link' ],		10, 1 );
			add_filter( 'ipress_schema_article-author-name',	[ $this, 'article_author_name' ],		10, 1);
			add_filter( 'ipress_schema_article-time', 			[ $this, 'article_time' ],				10, 1 );
			add_filter( 'ipress_schema_article-modified-time',	[ $this, 'article_modified_time' ],		10, 1 );
			add_filter( 'ipress_schema_article-content', 		[ $this, 'article_content' ], 			10, 1 );

			// Schema: comments
			add_filter( 'ipress_schema_comment', 				[ $this, 'comment' ], 					10, 1 );
	
			// Schema: sidebars & widgets
			add_filter( 'ipress_schema_sidebar', 				[ $this, 'sidebar' ],					10, 1 );

			// Schema: footer
			add_filter( 'ipress_schema_site-footer', 			[ $this, 'site_footer' ], 				10, 1 );					

			// Selectively disable schema options
			add_action( 'init', 								[ $this, 'disable_schema_microdata' ], 	10 );
		}

		//----------------------------------------------
		//	Schema functions
		//----------------------------------------------

		/**
		 * Add schema markup attributes for head element.
		 *
		 * @param 	array 	$attr 	Existing attributes for `head` element.
		 * @return 	array 	$attr
		 */
		public function head( $attr ) {

			// Add only to front page
			if ( ! is_front_page() ) { return $attr; }

			// Set item attributes
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/WebSite';

			return $attr;
		}

		/**
		 * Add schema markup attributes for body element.
		 *
		 * @param 	array 	$attr Existing attributes for `body` element.
		 * @return 	array	$attr
		 */
		public function body( $attr ) {
			$attr['itemscope'] = true;
			$attr['itemtype']  = ( is_search() ) ? 'https://schema.org/SearchResultsPage' : 'https://schema.org/WebPage';

			return $attr;
		}

		/**
		 * Add schema markup attributes for site header element.
		 *
		 * @param 	array 	$attr Existing attributes for site header element.
		 * @return 	array 	$attr
		 */
		public function site_header( $attr ) {
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/WPHeader';

			return $attr;
		}

		/**
		 * Add schema markup attributes for site title element.
		 *
		 * @param 	array 	$attr Existing attributes for site header element.
		 * @return 	array 	$attr
		 */
		public function site_title( $attr ) {
			$attr['itemprop'] = 'headline';

			return $attr;
		}

		/**
		 * Add schema markup attributes for site description element.
		 *
		 * @param 	array 	$attr Existing attributes for site description element.
		 * @return 	array 	$attr
		 */
		public function site_description( $attr ) {
			$attr['itemprop'] = 'description';

			return $attr;
		}

		/**
		 * Add schema markup attributes for breadcrumbs wrapper.
		 *
		 * @param 	array 	$attr Existing attributes for breadcrumb container element.
		 * @return 	array 	$attr
		 */
		public function breadcrumb( $attr ) {

			// No homepage links, so no Schema needed
			if ( is_front_page() ) { return $attr; }

			// Set wrapper microdata.
			$attributes['itemscope'] = true;
			$attributes['itemtype']  = 'https://schema.org/BreadcrumbList';

			return $attr;
		}

		/**
		 * Add schema markup attributes for breadcrumb item element.
		 *
		 * @param 	array 	$attr Existing attributes for breadcrumb list item element.
		 * @return 	array 	$attr
		 */
		public function breadcrumb_item( $attr ) {
			$attr['itemprop']  = 'itemListElement';
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/ListItem';

			return $attr;
		}

		/**
		 * Add schema markup attributes for breadcrumb link element.
		 *
		 * @param 	array 	$attr Existing attributes for breadcrumb link element.
		 * @return 	array 	$attr
		 */
		public function breadcrumb_link( $attr ) {
			$attr['itemprop'] = 'item';

			return $attr;
		}

		/**
		 * Add schema markup attributes for breadcrumb link text.
		 *
		 * @param 	array 	$attr Existing attributes for breadcrumb link text element.
		 * @return 	array 	$attr
		 */
		public function breadcrumb_text( $attr ) {
			$attr['itemprop'] = 'name';

			return $attr;
		}

		/**
		 * Add schema markup attributes for search form.
		 *
		 * @param 	array 	$attr Existing attributes for search form element.
		 * @return 	array 	$attr
		 */
		public function search_form( $attr ) {
			$attr['itemprop']  = 'potentialAction';
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/SearchAction';

			return $attr;
		}

		/**
		 * Add schema markup attributes for search form meta tag.
		 *
		 * @param 	array 	$attr Existing attributes for search form meta element.
		 * @return 	array 	$attr
		 */
		public function search_form_meta( $attr ) {
			$attr['itemprop'] 	= 'target';
			$attr['content']	= esc_url( home_url('/') ) . '?s={s}';

			return $attr;
		}

		/**
		 * Add schema markup attributes for search form input element.
		 *
		 * @param 	array 	$attr Existing attributes for search form input element.
		 * @return 	array 	$attr
		 */
		public function search_form_input( $attributes) {
			$attributes['itemprop'] = 'query-input';

			return $attributes;
		}

		/**
		 * Add schema markup attributes for primary navigation element.
		 *
		 * @param 	array 	$attr Existing attributes for search form input element.
		 * @return 	array 	$attr
		 */
		public function nav_item( $attr ) {
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/SiteNavigationElement';

			return $attr;
		}

		/**
		 * Add extra schema item to list item.
		 *  
		 * @param   array   $atts
		 * @param   object  $item
		 * @param   array   $args
		 * @return  array
		 */
		public function nav_link_attr( $atts, $item, $args ) {
			return ( ipress_has_schema() ) ? array_merge( $atts, [ 'itemprop' => 'url' ] ) : $atts;
		}

		/**
		 * Add schema markup list item title.
		 *
		 * @param 	array 	$title.
		 * @return 	array 	$title
		 */
		public function nav_item_title( $title ) {
			return ( ipress_has_schema() ) ? sprintf( '<span itemprop="name">%s</span>', $title ) : $title;
		}

		/**
		 * Add schema markup attributes for article element.
		 *
		 * @param 	array 	$attr Existing attributes for article element.
		 * @return 	array 	$attr
		 */
		public function article( $attr ) {
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/CreativeWork';

			return $attr;
		}

		/**
		 * Add schema markup attributes for article title element.
		 *
		 * @param 	array 	$attr Existing attributes for article title element.
		 * @return 	array 	$attr
		 */
		public function article_title( $attr ) {
			$attr['itemprop'] = 'headline';

			return $attr;
		}

		/**
		 * Add schema markup attributes for article image element.
		 *
		 * @param 	array 	$attr Existing attributes for article image element.
		 * @return 	array 	$attr
		 */
		public function article_image( $attr ) {
			$attr['itemprop'] = 'image';

			return $attr;
		}

		/**
		 * Add schema markup attributes for article image element shown in a widget.
		 *
		 * @param 	array 	$attr Existing attributes for widget image element.
		 * @return 	array 	$attr
		 */
		public function widget_image( $attr ) {
			$attr['itemprop'] = 'image';

			return $attr;
		}

		/**
		 * Add schema markup attributes for author element for an article.
		 *
		 * @param 	array 	$attr Existing attributes for article author element.
		 * @return 	array 	$attr
		 */
		public function article_author( $attr ) {
			$attr['itemprop']  = 'author';
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/Person';

			return $attr;
		}

		/**
		 * Add schema markup attributes for entry author link element.
		 *
		 * @param 	array 	$attr Existing attributes for article author link element.
		 * @return 	array 	$attr
		 */
		public function article_author_link( $attr ) {
			$attr['itemprop'] = 'url';

			return $attr;
		}

		/**
		 * Add schema markup attributes for entry author name element.
		 *
		 * @param 	array 	$attr Existing attributes for article author name element.
		 * @return 	array 	$attr
		 */
		public function article_author_name( $attr ) {
			$attr['itemprop'] = 'name';

			return $attr;
		}

		/**
		 * Add schema markup attributes for time element for an entry.
		 *
		 * @param 	array 	$attr Existing attributes for article time element.
		 * @return 	array 	$attr
		 */
		public function article_time( $attr ) {
			$attr['itemprop'] = 'datePublished';
			$attr['datetime'] = get_the_time( DATE_W3C );

			return $attr;
		}

		/**
		 * Add schema markup attributes for modified time element for an entry.
		 *
		 * @param 	array 	$attr Existing attributes for article modified time element.
		 * @return 	array 	$attr
		 */
		public function article_modified_time( $attr ) {
			$attr['itemprop'] = 'dateModified';
			$attr['datetime'] = get_the_modified_time( DATE_W3C );

			return $attr;
		}

		/**
		 * Add schema markup attributes for article content element.
		 *
		 * @param 	array 	$attr Existing attributes for article content element.
		 * @return 	array 	$attr
		 */
		public function article_content( $attr ) {
			$attr['itemprop'] = 'text';

			return $attr;
		}

		/**
		 * Add schema markup attributes for single comment element.
		 *
		 * @param 	array 	$attr Existing attributes for single comment element.
		 * @return 	array 	$attr
		 */
		public function comment( $attr ) {
			$attr['itemprop']  = 'comment';
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/Comment';

			return $attr;
		}

		/**
		 * Add schema markup attributes for comment author element. NYI
		 *
		 * @param 	array 	$attr Existing attributes for single comment author element.
		 * @return 	array 	$attr
		 */
		public function comment_author( $attr ) {
			$attr['itemprop']  = 'author';
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/Person';

			return $attr;
		}

		/**
		 * Add schema markup attributes for comment author link element. NYI
		 *
		 * @param 	array 	$attr Existing attributes for single comment author url element.
		 * @return 	array 	$attr
		 */
		public function comment_author_link( $attr ) {
			$attr['itemprop'] = 'url';

			return $attr;
		}

		/**
		 * Add schema markup attributes for comment author name element. NYI
		 *
		 * @param 	array 	$attr Existing attributes for single comment author name element.
		 * @return 	array 	$attr
		 */
		public function comment_author_name( $attr ) {
			$attr['itemprop'] = 'name';

			return $attr;
		}

		/**
		 * Add schema markup attributes for comment time element. NYI
		 *
		 * @param 	array 	$attr Existing attributes for single comment time element.
		 * @return 	array 	$attr
		 */
		public function comment_time( $attr ) {
			$attr['datetime'] = get_comment_time( DATE_W3C );
			$attr['itemprop'] = 'datePublished';

			return $attr;
		}

		/**
		 * Add schema markup attributes for comment time link element.
		 *
		 * @param 	array 	$attr Existing attributes for single comment time url element.
		 * @return 	array 	$attr
		 */
		public function comment_time_link( $attr) {
			$attr['itemprop'] = 'url';

			return $attr;
		}

		/**
		 * Add schema markup attributes for comment content container.
		 *
		 * @param 	array 	$attr Existing attributes for single comment content element.
		 * @return 	array 	$attr
		 */
		public function comment_content( $attr ) {
			$attr['itemprop'] = 'text';

			return $attr;
		}

		/**
		 * Add schema markup attributes for sidebar element.
		 *
		 * @param 	array 	$attr Existing attributes for sidebar element.
		 * @return 	array 	$attr
		 */
		public function sidebar( $attr ) {
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/WPSideBar';

			return $attr;
		}

		/**
		 * Add schema markup attributes for site footer element.
		 *
		 * @param 	array 	$attr Existing attributes for site footer element.
		 * @return 	array 	$attr
		 */
		public function site_footer( $attr ) {
			$attr['itemscope'] = true;
			$attr['itemtype']  = 'https://schema.org/WPFooter';

			return $attr;
		}

		//----------------------------------------------
		//	Schema filter functionality
		//----------------------------------------------

		/**
		 * Selectively disable schema microdata 
		 */
		public function disable_schema_microdata() {

			// Get filterable elements
			$elements = (array) apply_filters( 'ipress_schema_disable', [] );

			// Iterate the elements with validation
			foreach ( $elements as $element ) {
				
				// Element validation
				if ( ! in_array( $element, $this->elements ) ) { continue; }

				// Generate the filterable elements
				add_filter( "ipress_schema_{$element}", [ $this, 'remove_schema_microdata' ], 20, 1 );
			}

			// Some standalone tweaks: nav
			if ( in_array( 'nav', $elements ) ) {
				remove_filter( 'ipress_schema_nav-item', 	[ $this, 'nav_item' ], 			10, 1 );
				remove_filter( 'nav_menu_link_attributes', 	[ $this, 'nav_link_attr' ], 	10, 3 );
				remove_filter( 'nav_menu_item_title',		[ $this, 'nav_item_title' ], 	10, 1 );
			} else {
				if ( in_array( 'nav-link-attr', $elements ) ) {
					remove_filter( 'nav_menu_link_attributes', 	[ $this, 'nav_link_attr' ], 	10, 3 );
				}
				if ( in_array( 'nav-item-title', $elements ) ) {
					remove_filter( 'nav_menu_item_title',		[ $this, 'nav_item_title' ], 	10, 1 );
				}
			}
		}

		/**
		 * Remove core schema microdata elements
		 *
		 * @param	array	$attr
		 * @return	array	$attr
		 */
		public function remove_schema_microdata( $attr ) {
			unset( $attr['itemprop'], $attr['itemtype'], $attr['itemscope'] );
			return $attr;
		}
	}

endif;

// Instantiate Schema class
return new IPR_Schema;

//end
