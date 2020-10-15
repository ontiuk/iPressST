iPress PT - WordPress Theme Framework 
=======================================

http://on.tinternet.co.uk

## About

iPressST is a Standalone Theme framework based on the iPress Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton themes such as underscores, bones, and html5blank, as well as the latest default WordPress themes, 
this uses best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Structured hierarchy template structure with hooks: actions & filters
- Highly configurable class-based functionality hooking into core WordPress functionality
- Simple default theme that can be easily replaced with your own via child theme.
- Plugin integration: Woocommerce, Advanced Custom Fields, JetPack
- Lots of helpful stuff: helper functions, shortcodes, menus etc.

Note: this was intended primarily a development version for personal & client e-commerce projects. 
It contains a very basic css structure. This can be readily replace all or in part by structured framework such as Bootstrap. 

## Install

1. Upload the theme folder via FTP to your wp-content/themes/ directory.
2. Upload the child theme folder via FTP to your wp-content/themes/ directory
3. Go to your WordPress dashboard and select Appearance.
4. Select and activate the child theme

## User Manual

Will be updating this asap with details of available filters on the dedicated ipress.uk site.

## Widget Areas

* Primary Sidebar - This is the primary sidebar.
* Secondary Sidebar - This is the secondary sidebar.
* Header Sidebar - This is the widgeted area for the top right of the header.

## Support

Please visit the github page: https://github.com/ontiuk.

## Other Stuff

iPress consists of 3 primary themes:
iPressPT	- Parent Theme. Not to be used on it's own. Designed to work with an iPressCT child theme.
iPressCT	- Child Theme. Requires iPressPT. Child themes can be configured and styled as required via a base template.
iPressST	- Standalone Theme. Integrates iPressPT and iPressCT. Used for standalone theme development.

Older deprecated but still functional themes:
iPress RD 
iPress RD2

Upcoming
iPress-NG(x)- Theme Framework integrating iPress with Angular and the WordPress WP-API
iPress-RX	- Theme Framework integrating iPress with React and the WordPress WP-API

## Structure: Folders & Files

/
|-404.php
|-archive.php
|-attachment.php
|-author.php
|-browserconfig.xml
|-category.php
|-comments.php
|-date.php
|-favicon.ico
|-footer.php
|-front-page.php
|-functions.php
|-header.php
|-home.php
|-index.php
|-page.php
|-privacy-policy.php
|-screenshot.jpg
|-search.php
|-searchform.php
|-sidebar.php
|-sidebar-shop.php
|-sidebar-shop-category.php
|-sidebar-shop-product.php
|-single.php
|-style.css
|-tag.php
|-taxonomy.php
|-template-account.php
|-template-cart.php
|-template-checkout.php
|-/assets
| 	|-/css
| 	|-/fonts
| 	|-/images
| 	|-/js
| 	|-/scss
|-/inc
|	|-blocks.php
|	|-bootstrap.php
| 	|-config.php
| 	|-customizer.php
| 	|-functions.php
| 	|-shortcodes.php
| 	|-template-functions.php
| 	|-template-hooks.php
| 	|-template-tags.php
| 	|-/admin
| 	|-/classes
| 		|-class-acf.php
| 		|-class-admin.php
| 		|-class-ajax.php
| 		|-class-api.php
| 		|-class-blocks.php
| 		|-class-compat.php
| 		|-class-content.php
| 		|-class-cron.php
| 		|-class-custom.php
| 		|-class-customizer.php
| 		|-class-hooks.php
| 		|-class-images.php
| 		|-class-init.php
| 		|-class-layout.php
| 		|-class-load-scripts.php
| 		|-class-load-styles.php
| 		|-class-login.php
| 		|-class-multisite.php
| 		|-class-navigation.php
| 		|-class-page.php
| 		|-class-query.php
| 		|-class-redirect.php
| 		|-class-rewrite.php
| 		|-class-rules.php
| 		|-class-schema.php
| 		|-class-sidebars.php
| 		|-class-structured-data.php
| 		|-class-template.php
| 		|-class-theme.php
| 		|-class-user.php
| 		|-class-widgets.php
| 		|-class-woocommerce.php
| 	|-/controls
| 	|-/functions
|		|-content.php
|		|-image.php
|		|-navigation.php
|		|-pagination.php
|		|-product.php
|		|-schema.php
|		|-user.php
| 	|-/languages
| 	|-/lib
|		|-/acf
|		|-acf-config.php
| 	|-/shortcodes
|		|-analytics.php
|		|-category.php
|		|-date.php
|		|-links.php
|		|-media.php
|		|-post.php
|		|-search.php
|		|-user.php
| 	|-/widgets
|-/templates
| 	|-account.php
| 	|-archive.php
| 	|-attachment.php
| 	|-cart.php
| 	|-checkout.php
| 	|-content.php
| 	|-content-page.php
| 	|-content-privacy.php
| 	|-content-search.php
| 	|-content-single.php
| 	|-home.php
| 	|-index.php
| 	|-search.php
| 	|-/front
| 	|-/global
| 		|-/breadcrumbs
| 		|-/footer
| 		|-/header
| 	|-/layout
| 	|-/loop
| 	|-/page
| 	|-/single
| 	|-/widget
|-/woocommerce
| 	|-/admin
| 	|-/auth
| 	|-/cart
| 	|-/checkout
| 	|-/emails
| 	|-/global
| 	|-/loop
| 	|-/myaccount
| 	|-/notices
| 	|-/order
| 	|-/reports
| 	|-/single-product

## Structure: Files & Templates

/
|- 404.php
|	|- templates/global/404.php (alternate: 404-full.php)
|- archive.php ( / author.php / date.php / category.php / tag.php / taxonomy.php )
|	|- templates/archive.php
|		|- templates/content.php 
|			|- templates/loop/header.php
|			|- templates/loop/thumbnail.php
|			|- templates/loop/meta.php
|			|- templates/loop/content.php
|			|- templates/loop/excerpt.php
|			|- templates/loop/footer.php
|	|- templates/global/content-none.php
|- attachment.php
|	|- templates/attachment.php
|	|- templates/global/content-none.php
|- comments.php
|- footer.php
|	|- templates/global/footer/site-credit.php
|	|- templates/global/footer/footer-widgets.php
|- front-page.php
|	|- templates/global/content.php
|- functions.php
|- header.php
|	|- templates/global/header/site-branding.php
|	|- templates/global/site-navigation.php
|- home.php
|	|- templates/home.php
|		|- templates/content.php
|			|- templates/loop/header.php
|			|- templates/loop/thumbnail.php
|			|- templates/loop/meta.php
|			|- templates/loop/content.php
|			|- templates/loop/excerpt.php
|			|- templates/loop/footer.php
|	|- templates/global/content-none.php
|- index.php
|	|- templates/index.php
|		|- templates/content.php
|			|- templates/loop/header.php
|			|- templates/loop/thumbnail.php
|			|- templates/loop/meta.php
|			|- templates/loop/content.php
|			|- templates/loop/excerpt.php
|			|- templates/loop/footer.php
|	|- templates/global/content-none.php
|- page.php
|	|- templates/content-page.php
|		|- templates/page/header.php
|		|- templates/page/image.php
|		|- templates/loop/attachment.php
|		|- templates/loop/edit-link.php
|		|- templates/loop/content.php
|- privacy-policy.php
|	|- templates/content-privacy.php
|- search.php
|	|- templates/search.php
|		|- templates/content-search.php
|			|- templates/loop/header.php
|			|- templates/loop/thumbnail.php
|			|- templates/loop/meta.php
|			|- templates/loop/excerpt.php
|			|- templates/loop/footer.php
|	|- templates/global/content-none.php
|- single.php
|	|- templates/single.php
|		|- templates/content-single.php
|			|- templates/single/header.php
|			|- templates/single/image.php
|			|- templates/single/meta.php
|			|- templates/single/footer.php
|			|- templates/single/edit-link.php
|			|- templates/single/content.php
|	|- templates/global/content-none.php
|- template-account.php
|	|- templates/account.php
|- template-cart.php
|	|- templates/cart.php
|- template-checkout.php
|	|- templates/checkout.php


## Hooks & Classes

404.php
actions: 
	ipress_before_main_content
		ipress_404_before 
		ipress_404_after 
	ipress_after_main_content	
'main' class: error-page

archive.php ( author.php / date.php / category.php / tag.php / taxonomy.php )
actions: 
	ipress_before_main_content
	ipress_archive_before
		ipress_loop_before
			ipress_article_before
			ipress_loop
				ipress_loop_header_before, ipress_loop_header_after
				ipress_loop_content_before
				ipress_loop_content 				ipress_loop_content_after
				ipress_loop_footer
			ipress_article_after
		ipress_loop_after
	ipress_archive_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: archive-page ( author-page, data-page, category-page, tag-page, taconomy-page )

attachment.php
actions: 
	ipress_before_main_content
	ipress_page_before
		ipress_attachment_before, ipress_attachment, ipress_attachment_before
	ipress_page_after
	ipress_after_main_content	
'main' class: attachment-page

comments.php
actions:
	ipress_before_comments
	ipress_before_comment_form
	ipress_after_comments

header.php ( included & called before all other templates via get_header() )
actions:
	wp_body_open ( via wp_body_open() ) 
	ipress_before_header
	ipress_header_top
	ipress_header
	ipress_header_bottom
	ipress_before_content

footer.php ( included and called after all other templates via get_footer() )
actions:
	ipress_before_footer
	ipress_footer_top
	ipress_footer
	ipress_footer_bottom
	ipress_after_footer
	ipress_after

front-page.php
actions:
	ipress_before_main_content
	ipress_homepage
	ipress_homepage_after
	ipress_after_main_content	
'main' class: front-page

home.php
actions:
	ipress_before_main_content
	ipress_archive_before
		ipress_loop_before 
			ipress_article_before
			ipress_loop
				ipress_loop_header_before, ipress_loop_header_after
				ipress_loop_content_before, ipress_loop_content_after
				ipress_loop_footer
			ipress_article_after
		ipress_loop_after
	ipress_archive_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: home-page

index.php
actions:
	ipress_before_main_content
	ipress_archive_before
		ipress_loop_before 
			ipress_article_before
			ipress_loop, ipress_loop_xxx ( allowed post-formats )
				ipress_loop_header_before, ipress_loop_header_after
				ipress_loop_content_before, ipress_loop_content_after
				ipress_loop_footer
			ipress_article_after
		ipress_loop_after
	ipress_archive_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: index-page

page.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_article_before
			ipress_page
			ipress_page_header_before
			ipress_page_content_before, ipress_page_content_after						ipress_article_after
	ipress_page_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: content-page

privacy-policy.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_privacy_before
			ipress_privacy
			ipress_page_header_before
			ipress_page_content_before, ipress_page_content_after						ipress_privacy_after
	ipress_page_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: privacy-page

search.php
actions:
	ipress_before_main_content
	ipress_search_before
		ipress_loop_before
			ipress_article_before
			ipress_loop, ipress_loop_xxx ( allowed post-formats )
				ipress_loop_header_before, ipress_loop_header_after
				ipress_loop_content_before, ipress_loop_content_after
				ipress_loop_footer
			ipress_article_after
		ipress_loop_after
	ipress_search_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: search-page

single.php
actions:
	ipress_before_main_content
	ipress_single_before
		ipress_article_before
			ipress_single_top
			ipress_single
			ipress_single_bottom										ipress_article_after
	ipress_single_after
	ipress_sidebar
	ipress_after_main_content	
'main' class: single-page

template-account.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_account_before
			ipress_account
		ipress_account_after
	ipress_page_after, 
	ipress_after_main_content	
'main' class: account-page

template-cart.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_cart_before
			ipress_cart
		ipress_cart_after
	ipress_page_after
	ipress_after_main_content	
'main' class: cart-page

template-checkout.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_checkout_before
			ipress_checkout
		ipress_checkout_after
	ipress_page_after 
	ipress_after_main_content	
'main' class: checkout-page

## Hooks - Filters

class-acf.php
----------------
Advanced Custom Fields Theme Options Page. See class docs for example.
- Requires ACF Pro 5.x to be active and enabled.

'ipress_acf_title'
- filter: Set theme options page title, or turn off - default iPress Child.

ipress_acf_capability'
- filter: Options page capability - default 'manage_options'.

'ipress_acf_pages'
- filter: Options page sub-pages - default [].

class-compat.php
-----------------
Initialise and set up theme compatibility functionality.

'ipress_theme_php'
- minimum theme PHP version
- default, IPRESS_THEME_PHP set in bootstrap.php.

'ipress_theme_wp'
- minimum theme WP version
- default IPRESS_THEME_WP set in bootstrap.php.

class-content.php
-----------------
Set up theme starter content via starter-content theme support.

'ipress_starter_content'
- filter: Construct theme starter content - (array) default [].
- adds 'starter-content' theme support if active.

class-custom.php
------------------
Initialize theme specific custom post-types and taxonomies. In general custompost-types and taxonomies should be created
using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the
theme and integral to it's functionality so they can be more tightly linked to the child theme itself.

'ipress_custom_post_types'
- filter: Construct theme custom post-types - (array) default [].
- config driven post-type generation, see separate docs / config.php for parameters.

'ipress_taxonomies'
- filter: Construct theme custom taxonomies - (array) default [].
- config driven taxonomy generation, see separate docs / config.php for parameters.

'ipress_custom_post_type_reserved'
- filter: Takes the codex list of reserved post-types.

'ipress_custom_post_type_valid_args'
- filter: Takes the codes list of valid 'register_post_type' args parameter values.

'ipress_{post-type}_prefix
- filter: Generate a prefix for a custom post-type a-z, hyphen, underscore.

'ipress_{post-type}_labels'
- filter: Takes the generated post-type labels array.

'ipress_{post-type}_supports'
- filter: Takes the default post-type supports: default 'title', 'editor', 'thumbnails'.

'ipress_taxonomy_reserved'
- filter: Takes the codex list of reserved post-types.

'ipress_taxonomy_valid_args'
- filter: Takes the codes list of valid 'register_post_type' args parameter values.

'ipress_{taxonomy}_labels'
- filter: Takes the generated taxonomy labels array.

'ipress_post_type_messages'
- filter: Messages Callback - default [].

'ipress_{$screen->id}_help'
- filter: Contextual help tabs.

class-customizer.php
---------------------
Initialize theme WordPress theme customizer features.

'ipress_add_image_size'
- filter: Add hero image size.

'ipress_custom_logo';
- filter: Enable custom_logo theme support - (bool) default true.

'ipress_custom_logo_args'
- filter: Default args for add_theme_support( 'custom_logo' ).

'ipress_custom_header'
- filter: Enable custom_header theme support - (bool) default false.

'ipress_custom_header_default_image'
- filter: Set the default header image, default header.png.

'ipress_custom_header_args'
- filter: Default args for add_theme_support( 'custom-header' ).

'ipress_custom_header_uploads'
- filter: Enable custom header uploads, default false.
- Requires custom headers to be enabled.

'ipress_default_headers';
- filter: Register default headers - (bool) default false.

'ipress_default_header_args'
- filter: Default args for register_default_headers - default [].

'ipress_custom_background'
- filter: Enable support for custom backgrounds - default false.

'ipress_custom_background_default_image'
- filter: Custom background default image, default empty.
- Requires custom background to be enabled.

'ipress_custom_background_default_color'
- filter: Custom background default color, default #fff.
- Requires custom background to be enabled.

'ipress_custom_background_args'
- filter: Default args for add_theme_support( 'custom-background' ).
- Takes defaults from default image and default colour filters.

'ipress_custom_selective_refresh'
- filter: Enable theme support for 'selective_refresh'.

'ipress_customize_header_partials'
- filter: Enable selective refresh for header partials.

'ipress_custom_background'
- filter: Turn on/off the config driven customizer custom background section, default false/off.

'ipress_custom_header'
- filter: Turn on/off the config driven customizer custom header section, default false/off.

'ipress_custom_js'
- filter: Turn on/off the config driven customizer custom Javascript section, default false/off.

'ipress_default_layout'
- filter: Set the default content & sidebar layout. Default empty for full width layout.

class-images.php
-----------------
Initialize theme custom images & core images functionality.

'ipress_media_images'
- filter: Image size media editor add custom image sizes.
- default [ 'image-in-post' => __( 'Image in Post', 'ipress' ), 'full'	=> __( 'Original size', 'ipress' ) ].
- should match custom images from add_images_size.

'ipress_media_images_sizes'
- filter: Remove default image sizes.
- default sizes [] - thumbnail / medium / large.

'ipress_upload_mimes'
- filter: Add / Remove Mime type support for file uploads.
- default [ 'svg' => 'mime/type' ] add svg support, default to add SVG support.

'ipress_custom_mimes_restricted'
- filter: Set mime types that are restricted to admin only upload, default [].

'ipress_custom_gravatar'
- filter: (Gr)Avatar support - default []. 
- add as array ( 'name' => '', 'path' => '' ).

class-init.php
-------------------
Initialisation theme header fuctionality with core WordPress features.

'ipress_header_clean'
- filter: Activate the WP header clean up - default false.

'ipress_header_links'
- filter: Remove feed, rsd, manifest & shortlink links - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_index'
- filter: Remove noindex & rel link actions - default false.
- Requires 'ipress_header_clean' to be true.
	
'ipress_header_generator'
- filter: Disable XHTML generator - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_version'
- filter: Remove Versioning from scripts - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_css'
- filter: Clean CSS tags - from enqueued stylesheet - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_comments'
- filter: Remove inline Recent Comment Styles from wp_head() - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_canonical'
- filter: Disable canonical refereneces - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_login'
- filter: Show less info to users on failed login for security - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_login_info'
- filter: Generate custom text for login error - default '<strong>ERROR</strong>: Stop guessing!'.

'ipress_disable_emojicons' 
- filter: disable theme emojicon support - default true.

class-layout.php
-------------------
Initialize theme layour features with core WordPress functionality.

'ipress_theme_direction'
- filter: theme layout direction - default ''.

'ipress_breadcrumbs'
- filter: add breadcrumbs body class if breadcrumbs active.

'ipress_body_class'
- filter: add body class attributes - default [].

'ipress_read_more_link'
- filter: read more link - default false.

'ipress_view_more'
filter - custom view more link - default false.

'ipress_view_more_link'
filter - custom view more link - default ''.

'ipress_embed_video'
filter - embed video html - default html.

class-load-scripts.php
-----------------------
Initialize theme and plugin scripts.

'ipress_scripts'
- filter: Initialise scripts via config file - default [].
- Set up scripts list in config.php file, example provided.

'ipress_scripts_core'
- filter: Set core scripts for enqueueing.

'ipress_comment_reply'
- filter: Turn comments on/off, default true.

'ipress_scripts_local'
- filter: Set local scripts for enqueing via inline script, default [].

'ipress_header_scripts'
- filter: Apply header scripts - default ''. 
- loads: Theme mod - 'ipress_header_js'.
- Must have <script></script> wrapper.

'ipress_footer_scripts'
- filter: Apply footer scripts - default ''.
- loads: Theme mod - 'ipress_footer_js'.
- Must have <script></script> wrapper.

'ipress_header_admin_scripts'
- filter: Apply header admin scripts - default ''. 
- loads: Theme mod - 'ipress_header_admin_js'.
- Must have <script></script> wrapper.

'ipress_footer_admin_scripts'
- filter: Apply footer admin scripts - default ''. 
- loads: Theme mod - 'ipress_footer_admin_js'.
- Must have <script></script> wrapper.

class-load-styles.php
-----------------------
Initialize theme and plugin styles and fonts.

'ipress_styles'
- filter: Initialise main styles via config file - default [].
- Set up scripts list in config.php file, example provided.

'ipress_fonts'
- filter: Load google API fonts from external source e.g. googleapi - default [].

'ipress_fonts_url'
- filter: Set fonts url when loading external fonts - default: 'https://fonts.googleapis.com/css'.

'ipress_header_styles'
- filter: Apply inline header styles - default ''.
- Loads: Theme Mod - 'ipress_header_styles'.

'ipress_header_admin_styles'
- filter: Apply inline header admin styles - default ''.
- Loads: Theme Mod - 'ipress_header_admin_styles'. 

"ipress_{$k}_style_data"
- filter: Add rtl data for editor style, default false.

class-login.php
-------------------
Initialisation login page custom features and redirects

'ipress_login_page'
- filter: Redirect the default login page.
- default [] uses WP login page.

ipress_login_failed_page'
- filter: Custom login failed redirect.
- default [] uses WP login page.

ipress_login_verify_page'
- filter: Custom login verify redirect.
- default [] uses WP login page.

ipress_login_logout_page'
- filter: Custom login logout redirect.
- default [] uses WP login page.

class-multisite.php
-------------------
Initialize MultiSite features if theme is multisite enabled.

'ipress_multisite_blogs'
- filter: Set up list of blogs.
- default generic blogs list.

'ipress_multisite_description'
- filter: Set up blog description.
- default individual blog ID.

'ipress_multisite_sites'
- filter: Set up list of sites.
- default generics sites list.

class-navigation.php
-------------------
Initialisation theme navigation features.

'ipress_nav_clean'
- filter: Clean navigation markup & remove surrounding 'div', default false.

'ipress_nav_css_attr'
- filter: Remove Injected classes, ID's and Page ID's from Navigation li items, default false.

class-page.php
-------------------
Initialize theme page tag & excerpt support.

'ipress_page_excerpt'
- filter: Page excerpt support, default false.

'ipress_page_tags'
- filter: Page tags support, default false.

'ipress_page_tags_query', false
- filter: Add page tags to query, default false.

'ipress_search_types'
- filter: Add post-types to WordPress front search, default [].

class-query.php
-----------------
Initialise and manipulate the post main query.

'ipress_query_post_type_archives'
filter - Customize query for post-type taxonomy terms - default [].

'ipress_query_exclude_category'
- filter - Exclude categories from display - default Uncategorised ['-1'].

'ipress_query_search_include'
- filter - Include post-types in search query - default [].

class-rewrites.php
-------------------
Initialize theme rewrites and query_vars.

'ipress_query_vars'
- filter: Add new query vars, default [].

class-schema.php
-----------------
Initialise Schema Microdata for selected html tags and elements.

'ipress_schema_head'
- filter: Set schema microdata for 'head' tag.

'ipress_schema_body'
- filter: Set schema microdata for 'body' tag.

'ipress_schema_site-header'
- filter: Set schema microdata for 'header' tag.

'ipress_schema_site-title'
- filter: Set schema microdata for 'site-title' element.

'ipress_schema_site-description'
- filter: Set schema microdata for 'site-descripton' element.

'ipress_schema_breadcrumb'
- filter: Set schema microdata for site breadcrumbs element.

'ipress_schema_breadcrumb-item'
- filter: Set schema microdata for site breadcrumbs list item element.

'ipress_schema_breadcrumb-link'
- filter: Set schema microdata for site breadcrumbs list item link element.

'ipress_schema_breadcrumb-text'
- filter: Set schema microdata for site breadcrumbs list item text element.

'ipress_schema_search-form'
- filter: Set schema microdata for site search 'form' tag.

'ipress_schema_search-form-meta'
- filter: Set schema microdata for site search form meta element.

'ipress_schema_search-form-input'
- filter: Set schema microdata for site search form 'input' tag.

'ipress_schema_nav-item'
- filter: Set schema microdata for site navigation 'nav' tag.

'ipress_schema_article'
- filter: Set schema microdata for 'article' tag.

'ipress_schema_article-title'
- filter: Set schema microdata for article title element.

'ipress_schema_article-image'
- filter: Set schema microdata for article img tag.

'ipress_schema_widget-image'
- filter: Set schema microdata for widget image element.

'ipress_schema_article-author'
- filter: Set schema microdata for article author element.

'ipress_schema_article-author-link'
- filter: Set schema microdata for article author link element.

'ipress_schema_article-author-name'
- filter: Set schema microdata for article author name attr element.

'ipress_schema_article-time'
- filter: Set schema microdata for article author 'time' tag.

'ipress_schema_article-modified-time'
- filter: Set schema microdata for article author 'time' tag with modified date.
 
'ipress_schema_article-content'
- filter: Set schema microdata for article content element.

'ipress_schema_comment'
- filter: Set schema microdata for article comment element.

'ipress_schema_sidebar'
- filter: Set schema microdata for sidebar 'aside' tag.

'ipress_schema_site-footer'
- filter: Set schema microdata for 'footer' tag.

'ipress_schema_disable'
- filter: Selected elements to remove from the schema microdata, default [].
- Requires that the Schema microdata is active.

'ipress_schema_{$element}'_
- filter: Update element schema data if required.

class-sidebars.php
-------------------
Initialize theme sidebars and widget areas.

'ipress_sidebar_defaults'
- filter: Override default sidebar wrappers: before & after widget, before & after title.

'ipress_sidebar_{sidebar-id}_defaults'
- filter: Dynamic sidebar defaults - takes sidebar defaults and sidebar ID.

'ipress_default_sidebars'
- filter: Default sidebars: default [ primary...].

'ipress_footer_widget_areas'
- filter: Default footer widget area number - default 3.

'ipress_custom_sidebars'
- filter: Register custom sidebars: default [].

class-theme.php
-------------------
Initialize core theme settings.

'ipress_content_width'
- filter: Content width: default 840.

'ipress_feed_links_support'
- filter: Add 'feed-link' theme support, default true.

'ipress_post_thumbnails_support'
- filter: Add 'post thumbnails' theme support, default true.

'ipress_post_thumbnails_post_types'
- filter: Add post-type to thumbnail support.
- Requires post thumbnail support to be active.

'ipress_post_thumbnail_size'
- filter: Set thumbnail default size: width, height, crop, default [].
- Requires post thumbnail support to be active.

'ipress_image_size_default'
- filter: Core image sizes overrides, default [].
- Requires post thumbnail support to be active.

'ipress_add_image_size'
- filter: Add custom image sizes, default [].
- Requires post thumbnail support to be active.

'ipress_big_image_size
- filter: Turn off 'big image' theme support, default true.
- Requires post thumbnail support to be active.

'ipress_menus_support'
- filter: Add nav manus theme support, default true.

'ipress_nav_menu_default'
- filter: Set default nav menu, default [ primary ].
- Requires nav menus support to be active.

'ipress_nav_menus'
- filter: Register custom navigation menu locations, default [].
- Requires nav menus support to be active.

'ipress_html5'
- filter: Enable support for HTML5 markup, default [x6].

'ipress_post_formats'
- filter: Register post-formats support, default false [].

'ipress_theme_support'
- filter: Register additional theme support, default false [].

'ipress_remove_theme_support'
- filter: Remove registered theme support, default false [].

'ipress_title_tag'
- filter: Add title-tag support, default true.

'ipress_document_title_separator'
- filter: document title separator, default '-'.
- requires: title-tag support.

'ipress_home_doctitle_append'
- filter: append site description to title on homepage, default true.
- requires: title-tag support.

'ipress_doctitle_separator'
- filter: title separator, default ''.
- requires: title-tag support.

'ipress_append_site_name'
- filter: append site name to inner pages, default true.
- requires: title-tag support.

'ipress_resource_hints
- filter: Modify & add custom resource hints, default [] 

class-widgets.php
-------------------
Initialisation and register theme widgets.

'ipress_widgets'
- filter: custom widgets, default [].

class-woocommerce.php
---------------------
Woocommerce settings and custom features.

'ipress_wc_active'
- filter: Turn on/off cart & checkout functionality. Default true. Set to false to bypass cart, checkout & account, e.g. affiliate site.

'ipress_wc_product_gallery'
- filter: Add woocommerce gallery support (zoom, lightbox, slider) - default true.

'ipress_wc_product_loop'
- filter: Display all products on single page - default false.

'ipress_wc_disable_js_css'
- filter: Disable css & js on non Woocommerce pages - default false.

'ipress_wc_disable_layout'
- filter: Disable layout css
- requires 'ipress_woocommerce_disable_js_css to not be true.

'ipress_wc_disable_css'
- filter: List of registered theme / plugin styles to dequeue - default [ 'wc-block-style', 'wc-bundle-style', 'wc-composite-css' ].
- requires 'ipress_woocommerce_disable_js_css to not be true.

'ipress_wc_disable_cart'
- filter: Disable cart js, default true.
- requires 'ipress_woocommerce_disable_js_css to not be true.

'ipress_wc_disable_js'
- filter: List of registered theme / plugin scripts to dequeue - default [].
- requires 'ipress_woocommerce_disable_js_css to not be true.

'ip_wc_disable_select2'
- filter: Disable the bundled select2 js functionality for Woocommerce select boxes, default false.

'ipress_wc_header_cart'
- filter: Turn on/off the header cart ajax functionality default true/on.

'ipress_related_products_args'
- filter: Set the default related product args for posts and columns, default 3x3.

config.php
-----------

'ipress_scripts'
- filter: Register Scripts, Styles & Fonts: Scripts, default []. See inline documentation for more details.

'ipress_styles'
- filter: Register Scripts, Styles & Fonts: Styles, default []. See inline documentation for more details.

'ipress_fonts'
- filter: Register Scripts, Styles & Fonts: Fonts, default []. See inline documentation for more details.

'ipress_custom_post_types'
- filter: Register Custom Post Types, default [].

'ipress_taxonomies'
- filter: Register taxonomies, default [].

'ipress_nav_menus'
- filter: Register custom menus, default [].

'ipress_add_image_size'
- filter: Register custom image sizes, default [].

'ipress_default_sidebars'
- filter: Register custom sidebars, default [].

'ipress_widgets'
- filter: Register custom widget areas, default [].

template-functions.php
-----------------------

'ipress_breadcrumbs'
- filter: Turn on/off default breadcrumbs on inner non-WC pages. Default off/false.

'ipress_breadcrumbs_custom_template'
- filter: Set a default breadcrumb template, default empty.
- Requires 'ipress_breadcrumbs' to be on/true.

'ipress_breadcrumbs_template'
- filter: Tweak final requested breadcrumb template, default string
- Requires 'ipress_breadcrumbs' to be on/true.

