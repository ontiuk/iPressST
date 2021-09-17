iPress ST - WordPress Theme Framework 
=======================================

=== iPress Child Theme ===
Contributors: tifosi
Requires at least: 5.3
Tested up to: 5.8
Requires PHP: 7.2
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

iPressST is a Standalone Theme framework based on the iPress Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton themes such as underscores, bones, and html5blank, as well as the latest default WordPress themes, 
this uses best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Structured hierarchy template structure with hooks: actions & filters.
- Highly configurable class-based functionality hooking into core WordPress functionality.
- Simple default theme that can be easily replaced with your own via child theme.
- Plugin integration: WooCommerce & Advanced Custom Fields
- Lots of helpful stuff: helper functions, shortcodes, menus, extensions etc.

Note: this was intended primarily a development version for personal & client e-commerce projects. 
It contains a very basic css structure. This can be readily replaced, all or in part, by structured framework such as Bootstrap. 

== Installation ==

1. Upload the iPress Standalone Theme folder via FTP to your wp-content/themes/ directory.
2. Go to your WordPress dashboard and select Appearance > Themes.
4. Select and activate the iPress Standalone Theme.

== User Manual ==

I'll be updating this asap with details of available filters.

== Widget Areas ==

* Primary Sidebar 	- This is the primary sidebar.
* Secondary Sidebar - This is the secondary sidebar.
* Header Sidebar 	- This is the widgeted area for the top right of the header.

== Support ==

Please visit the github page: https://github.com/ontiuk.

== Folder Structure ==

Out of the box it works as a standard theme with a very basic template. 
Uses a template restructure to move primary files to the route directory.
See https://core.trac.wordpress.org/ticket/13239 for potential/hopeful changes on template structure.

== Other Stuff ==

iPress consists of 3 primary themes:
iPressPT	- iPress Parent Theme. Not to be used on it's own. Designed to work with an iPressCT child theme.
iPressCT	- iPress Child Theme. Requires iPressPT. Child themes can be configured and styled as required.
iPressST	- iPress Standalone Theme. Integrates iPressPT & iPressCT. Used for standalone theme development.

Older deprecated but still functional themes:
iPress RD 
iPress RD2

Upcoming:
iPressNG	- iPress Angular Theme Framework. Custom theme for use with the Angular Framework with particular reference to the WP REST API.
iPressRX	- iPress React Theme Framework. Custom theme for use with the React Framework with particular reference to the WP REST API.
iPress Extensions - Additional modular framework functionality 

== Copyright ==

iPress WordPress Child Theme is distributed under the terms of the GNU GPL.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Structure: Folders & Files ==

/
|-404.php
|-archive.php
|-attachment.php
|-author.php
|-category.php
|-CHANGELOG.md
|-comments.php
|-date.php
|-footer.php
|-front-page.php
|-functions.php
|-header.php
|-home.php
|-index.php
|-page.php
|-privacy-policy.php
|-README.md
|-screenshot.jpg
|-search.php
|-searchform.php
|-sidebar.php
|-sidebar-header.php
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
|-template-home.php
|-/assets
| 	|-/css
|		|-editor.css & various sample css files
|		|-/woocommerce
|			|-woocommerce.css
|			|-woocommerce.min.css
| 	|-/fonts
| 	|-/images
| 		|-various folders and example images
| 	|-/js
|		|-customize.js
|		|-customize-controls.js
|		|-customize-preview.js
|		|-theme.js
|		|-theme.min.js
| 		|-/lib
| 	|-/scss
| 		|-various dummy folders and example style.scss
|-/inc
|	|-blocks.php
|	|-bootstrap.php
| 	|-config.php
| 	|-customizer.php
| 	|-functions.php
| 	|-template-functions.php
| 	|-template-hooks.php
| 	|-/admin
| 	|-/blocks
| 	|-/classes
| 		|-class-acf.php
| 		|-class-admin.php
| 		|-class-ajax.php
| 		|-class-api.php
| 		|-class-compat.php
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
| 		|-class-sidebars.php
| 		|-class-template.php
| 		|-class-theme.php
| 		|-class-user.php
| 		|-class-widgets.php
| 	|-/controls
| 		|-class-arbitrary.php
| 		|-class-checkbox-multiple.php
| 		|-class-seperator.php
| 	|-/functions
|		|-acf.php
|		|-content.php
|		|-image.php
|		|-navigation.php
|		|-pagination.php
|		|-product.php
|		|-template.php
|		|-user.php
| 	|-/lib
|		|-/acf
|		|-acf-config.php
| 	|-/widgets
| 	|-/woocommerce
|		|-class-adjacent-products.php
|		|-class-customizer.php
|		|-class-woocommerce.php
|		|-functions.php
|		|-template-functions.php
|		|-template-hooks.php
|-/languages
| 		|-various language based .po/.mo files
|-/templates
| 	|-account.php
| 	|-archive.php
| 	|-attachment.php
| 	|-cart.php
| 	|-checkout.php
| 	|-content.php
| 	|-content-home.php
| 	|-content-page.php
| 	|-content-privacy.php
| 	|-content-search.php
| 	|-content-single.php
| 	|-home.php
| 	|-index.php
| 	|-search.php
| 	|-/front
| 		|-hero.php
| 	|-/global
| 		|-404.php
| 		|-404-product.php
| 		|-content.php
| 		|-content-none.php
| 		|-loader.php
| 		|-paginate.php
| 		|-pagination.php
| 		|-post-image.php
| 		|-post-thumbnail.php
| 		|-scroll-top.php
| 		|-skip-links.php
| 		|-/breadcrumbs
| 			|-archive.php
| 			|-archive-cpt.php (dummy CPT file)
| 			|-author.php
| 			|-category.php
| 			|-date.php
| 			|-home.php
| 			|-page.php
| 			|-search.php
| 			|-single.php
| 			|-tag.php
| 			|-taxonomy.php
| 		|-/footer
| 			|-footer-widgets.php
| 			|-site-credits.php
| 		|-/header
| 			|-container.php
| 			|-container-close.php
| 			|-site-branding.php
| 			|-site-navigation.php
| 	|-/layout
| 	|-/loop
| 		|-content.php
| 		|-excerpt.php
| 		|-footer.php
| 		|-header.php
| 		|-meta.php
| 		|-sticky.php
| 		|-thumbnail.php
| 	|-/page
| 		|-attachment.php
| 		|-content.php
| 		|-edit-link.php
| 		|-header.php
| 		|-image.php
| 	|-/single
| 		|-content.php
| 		|-edit-link.php
| 		|-footer.php
| 		|-header.php
| 		|-image.php
| 		|-meta.php
| 	|-/widget
|-/woocommerce
| 	|-header-cart-content.php
| 	|-header-cart-link.php
| 	|-product-search.php
| 	|-single-product.php
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
| 		|-pagination.php
| 		|-/add-to-cart
| 		|-/tabs

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
|	|- templates/global/content-none.php
|- privacy-policy.php
|	|- templates/content-privacy.php
|	|- templates/global/content-none.php
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
|	|- templates/global/content-none.php
|- template-cart.php
|	|- templates/cart.php
|	|- templates/global/content-none.php
|- template-checkout.php
|	|- templates/checkout.php
|	|- templates/global/content-none.php
|- template-home.php
|	|- templates/content-home.php

## Hooks & Classes

404.php
actions: 
	ipress_before_main_content
		ipress_404_before 
		ipress_404_after 
	ipress_after_main_content	
main class: error-page

archive.php ( author.php / date.php / category.php / tag.php / taxonomy.php )
actions: 
	ipress_before_main_content
	ipress_archive_before
		ipress_loop_before
			ipress_article_before
				ipress_loop
					ipress_loop_header_before
					ipress_loop_header_after
					ipress_loop_content_before
					ipress_loop_content
					ipress_loop_content_after
					ipress_loop_footer_before
					ipress_loop_footer
					ipress_loop_footer_after
			ipress_article_after
		ipress_loop_after
	ipress_archive_after
	ipress_sidebar
	ipress_after_main_content	
main class: archive-page ( author-page, data-page, category-page, tag-page, taconomy-page )

attachment.php
actions: 
	ipress_before_main_content
	ipress_page_before
		ipress_attachment_before
		ipress_attachment
		ipress_attachment_after
	ipress_page_after
	ipress_after_main_content	
main class: attachment-page

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
main class: front-page

home.php
actions:
	ipress_before_main_content
	ipress_archive_before
		ipress_loop_before 
			ipress_article_before
				ipress_loop
					ipress_loop_header_before
					ipress_loop_header_after
					ipress_loop_content_before
					ipress_loop_content
					ipress_loop_content_after
					ipress_loop_footer_before
					ipress_loop_footer
					ipress_loop_footer_after
			ipress_article_after
		ipress_loop_after
	ipress_archive_after
	ipress_sidebar
	ipress_after_main_content	
main class: home-page

index.php
actions:
	ipress_before_main_content
	ipress_archive_before
		ipress_loop_before 
			ipress_article_before
				ipress_loop, ipress_loop_xxx ( allowed post-formats )
					ipress_loop_header_before
					ipress_loop_header_after
					ipress_loop_content_before
					ipress_loop_content
					ipress_loop_content_after
					ipress_loop_footer_before
					ipress_loop_footer
					ipress_loop_footer_after
			ipress_article_after
		ipress_loop_after
	ipress_archive_after
	ipress_sidebar
	ipress_after_main_content	
main class: index-page

page.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_article_before
			ipress_page
				ipress_page_header_before
				ipress_page_content_before
				ipress_page_content_after
		ipress_article_after
	ipress_page_after
	ipress_sidebar
	ipress_after_main_content	
main class: content-page

privacy-policy.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_privacy_before
			ipress_privacy
			ipress_page_header_before
			ipress_page_content_before
			ipress_page_content_after
		ipress_privacy_after
	ipress_page_after
	ipress_sidebar
	ipress_after_main_content	
main class: privacy-page

search.php
actions:
	ipress_before_main_content
	ipress_search_before
		ipress_loop_before
			ipress_article_before
				ipress_loop, ipress_loop_xxx ( allowed post-formats )
					ipress_loop_header_before
					ipress_loop_header_after
					ipress_loop_content_before
					ipress_loop_content
					ipress_loop_content_after
					ipress_loop_footer_before
					ipress_loop_footer
					ipress_loop_footer_after
			ipress_article_after
		ipress_loop_after
	ipress_search_after
	ipress_sidebar
	ipress_after_main_content	
main class: search-page

single.php
actions:
	ipress_before_main_content
	ipress_single_before
		ipress_article_before
			ipress_single_top
			ipress_single
			ipress_single_bottom
		ipress_article_after
	ipress_single_after
	ipress_sidebar
	ipress_after_main_content	
main class: single-page

template-account.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_account_before
			ipress_account
		ipress_account_after
	ipress_page_after, 
	ipress_after_main_content	
main class: account-page

template-cart.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_cart_before
			ipress_cart
		ipress_cart_after
	ipress_page_after
	ipress_after_main_content	
main class: cart-page

template-checkout.php
actions:
	ipress_before_main_content
	ipress_page_before
		ipress_checkout_before
			ipress_checkout
		ipress_checkout_after
	ipress_page_after 
	ipress_after_main_content	
main class: checkout-page

template-home.php
actions:
	ipress_before_main_content
	ipress_homepage
	ipress_homepage_after 
	ipress_after_main_content	
main class: front-page

## Custom Hooks - Actions & Filters

bootstrap.php
----------------

'ipress_bootstrap'
Action: Initialise pre-bootstrap functionality in child theme.

'ipress_init'
Action: Initialise functionality before loading files & after defining constants.

'ipress_config'
Action: Initialise functionality before loading config file.

config.php
-----------

'ipress_scripts'
- Filter: Register Scripts, Styles & Fonts: Scripts. See inline documentation for more details.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-scripts.php.

'ipress_styles'
- Filter: Register Scripts, Styles & Fonts: Styles. See inline documentation for more details.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-styles.php.

'ipress_fonts'
- Filter: Register Scripts, Styles & Fonts: Fonts. See inline documentation for more details.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-styles.php.

'ipress_custom_post_types'
- Filter: Register Custom Post Types.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-custom.php.

'ipress_taxonomies'
- Filter: Register taxonomies.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-custom.php.

'ipress_nav_menus'
- Filter: Register custom menus.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-theme.php.

'ipress_add_image_size'
- Filter: Register custom image sizes.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-theme.php.

'ipress_default_sidebars'
- Filter: Register custom sidebars.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-sidebars.php.

'ipress_custom_sidebars'
- Filter: Register custom sidebars, including for WooCommerce custom templates.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-sidebars.php.

'ipress_widgets'
- Filter: Register custom widget areas.
- Default: []
- Return: []
- Uses: filter in parent theme classes/class-widgets.php.

template-functions.php
-----------------------

'ipress_breadcrumbs'
- Filter: Enable default breadcrumbs on inner non-WC pages.
- Default: boolean, false (off)
- Return: boolean

'ipress_breadcrumbs_custom_template'
- Filter: Set a default breadcrumb template. Requires 'ipress_breadcrumbs' to be enabled (true).
- Default: ''
- Return: string

'ipress_breadcrumbs_template'
- Filter: Tweak final requested breadcrumb template. Requires 'ipress_breadcrumbs' to be enabled (true).
- Default: string
- Return: string

class-acf.php
----------------
Advanced Custom Fields Theme Options Page. See class docs for example.
- Requires ACF Pro 5.x to be active and enabled.

'ipress_acf_title'
- Filter: Set theme options page title, or turn off.
- Default: IPRESS_CHILD_THEME_NAME, defined in bootstrap.php
- Return: string

ipress_acf_capability'
- Filter: Options page capability. Uses WP capability options, see Codex.
- Default: 'manage_options'.
- Return: string

'ipress_acf_pages'
- Filter: Options page sub-pages.
- Default: []
- Return: []

'ipress_acf_disable_frontend'
- Filter: Disable ACF on the front-end & reduce loading.
- Default: boolean, false
- Return: boolean

class-compat.php
------------------
Initialise and set up theme compatibility functionality.

'ipress_theme_php'
- Filter: Set minimum PHP requirements.
- Default: IPRESS_THEME_PHP defined in bootstrap.php.

'ipress_theme_wp'
- Filter: Set minimum WP requirements.
- Default: IPRESS_THEME_WP defined in bootstrap.php.

class-custom.php 
------------------
Initialize theme specific custom post-types and taxonomies. In general custompost-types and taxonomies should be created
using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the
theme and integral to it's functionality so they can be more tightly linked to the theme itself.

'ipress_post_types'
- Filter: Set the custom post types.
- Default: []
- Return: [] of post type names
- Config driven post-type generation, see separate docs / config.php for parameters.

'ipress_taxonomies'
- Filter: Set the taxonomies.
- Default: []
- Return: [] of taxonomy names
- Config driven taxonomy generation, see separate docs / config.php for parameters.

'ipress_post_type_reserved'
- Filter: Reserved custom post type names.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_post_type_valid_args'
- Filter: Reserved list of arguments that can be passed to 'register_post_type'.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_{$post-type}_prefix'
- Filter: Generate a prefix for a custom post-type a-z, hyphen, underscore.
- Default: ''
- Return: string

'ipress_{$post-type}_labels'
- Filter: Post type labels per post type name.
- Default: [], built-in list defined in WP codex, with singular & plural post type name
- Return: []

'ipress_{$post-type}_supports'
- Filter: Post type supports per post type name.
- Default: [ 'title','editor','thumbnail' ]
- Return: []

'ipress_taxonomy_reserved'
- Filter: Reserved taxonomy names.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_taxonomy_valid_args'
- Filter: Reserved list of arguments that can be passed to 'register_taxonomy'.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_{$taxonomy}_labels
- Filter: Taxonomy labels per texonomy name.
- Default: [], built-in list defined in WP codex and with singular & plural taxonomy name
- Return: []

'ipress_post_type_messages'
- Filter: Set post type helper messages callback.
- Default: []
- Return []

'ipress_{$screen->id}_help
- Filter: Set contextual help tabs.
- Default: []
- Return: []

class-customizer.php
---------------------
Initialize theme WordPress theme customizer features.

'ipress_custom_logo';
- Filter: Enable custom_logo theme support. Hooked into after_theme_setup action.
- Default: boolean, true
- Return: boolean

'ipress_custom_logo_args'
- Filter: Default args for add_theme_support( 'custom_logo' ).
- Default [ 'width', 'height', 'flex-width', 'flex-height' ]
- Return []

'ipress_custom_header'
- Filter: Enable custom header theme support. Hooked into after_theme_setup action.
- Default: boolean, false
- Return: boolean

'ipress_custom_header_default_image'
- Filter: Set the default header image, default header.png. Requires custom header theme support.
- Default: string, header.png
- Return: string, url

'ipress_custom_header_args'
- Filter: Default args for add_theme_support( 'custom-header' ). Requires custom header theme support.
- Default: [ 'default-image', 'header-text', 'width', 'height', 'flex-width', 'flex-height' ]
- Return: []

'ipress_custom_header_uploads'
- Filter: Enable custom header uploads. Requires custom headers to be enabled. Hooked into after_theme_setup.
- Default: boolean, false
- Return: boolean

'ipress_default_headers';
- Filter: Register default headers. Requires custom header theme support.
- Default: boolean, false
- Return: boolean 

'ipress_default_header_args'
- Filter: Default args for register_default_headers.
- Default []
- Return: []

'ipress_custom_background'
- Filter: Enable theme support for custom backgrounds. Hooked into after_theme_setup action.
- Default: boolean, false
- Return: boolean

'ipress_custom_background_default_image'
- Filter: Set the default custom background image. Requires custom background to be enabled.
- Default: ''
- Return: string, url

'ipress_custom_background_default_color'
- Filter: Set the default custom background. Requires custom background to be enabled.
- Default: #ffffff
- Return: string, hex

'ipress_custom_background_args'
- Filter: Default args for add_theme_support( 'custom-background' ). Requires custom background theme support.
- Default: []
- Return: []

'ipress_custom_selective_refresh'
- Filter: Enable theme support for 'selective_refresh' for widgets.
- Default: boolean, true
- Return boolean

'ipress_customize_header_partials'
- Filter: Enable dynamic refresh for header partials.
- Default: boolean, true
- Return boolean.

'ipress_custom_js'
- Filter: Enable /disable additional JavaScript customizer fields.
- Default: boolean, false (off)
- Return: boolean
- Hook: 'customize_register'

'ipress_custom_hero'
- Filter: Enable / disable additional Custom Hero section customizer fields.
- Default: boolean, true (on)
- Return: boolean
- Hook: 'customize_register'

'ipress_setup_customizer'
- Action: Additional customizer theme settings. Hooked into after_theme_setup.

'ipress_customize_register'
- Action: Additional customizer settings. Uses the current WP Customizer instance. Hooked into customize_register.

'ipress_customize_register_js'
- Action: Additional customizer javascript settings. Uses the current WP Customizer instance. 
- Hook: 'customize_register'

'ipress_customize_register_theme'
- Action: Additional customizer theme settings. Uses the current WP Customizer instance. 
- Hook: 'customize_register'

'ipress_customize_register_hero'
- Action: Additional customizer hero section settings. Uses the current WP Customizer instance. 
- Hook: 'customize_register'

class-images.php
-----------------
Initialize theme custom images & core images functionality.

'ipress_media_images'
- Filter: Image size media editor add custom image sizes. Should match custom images from add_images_size.
- Default: [ 'image-in-post', 'full' ]
- Return: []
- Hook: 'image_size_names_choose'

'ipress_media_images_sizes'
- Filter: Remove default image sizes.
- Default: sizes [], 'thumbnail', 'medium', 'medium_large', 'large'
- Return: []
- Hook: 'intermediate_image_sizes_advanced'

'ipress_upload_mimes'
- Filter: Add / Remove Mime type support for file uploads.
- Default: [ 'svg' => 'mime/type' ], add SVG support
- Return: []
- Hook: 'upload_mimes'

'ipress_custom_mimes_restricted'
- Filter: Set mime types that are restricted to admin only upload
- Default: []
- Return: []
- Hook: 'upload_mimes'

'ipress_custom_gravatar'
- Filter: (Gr)Avatar support. Add as [ 'name' => '', 'path' => '' ].
- Default: []
- Return: []
- Hook: 'avatar_defaults'

class-init.php
-------------------
Initialisation theme header fuctionality with core WordPress features.

'ipress_editor_styles'
- Filter: Enable / disable editor styles.
- Default: boolean, true
- Return: boolean

'ipress_editor_font_sizes'
- Filter: Set editor font sizes.
- Default: [ 'small', 'normal, 'medium', 'large', 'big' ]
- Return: []

'ipress_load_fonts'
- Filter: Load custom fonts for editor.
- Default: []
- Return: []

'ipress_fonts_url'
- Filter: Initialise the default custom font base URL.
- Default: string, 'https://fonts.googleapis.com/css'
- Return: string, url

'ipress_fonts_subset'
- Filter: Initialise the font subset if fonts are available.
- Default: string, 'latin,latin-ext'
- Return: string

'ipress_startup'
- Action: Additional customizer hero section settings. Uses the current WP Customizer instance. 
- Hook: 'customize_register'

'ipress_header_clean'
- Filter: Activate the WP header clean up functionality.
- Default: boolean, false
- Return: boolean
- Hook: 'init'

'ipress_header_links'
- Filter: Remove feed, rsd, manifest & shortlink links. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_index'
- Filter: Remove noindex & rel link actions. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean
	
'ipress_header_generator'
- Filter: Disable XHTML generator. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_version'
- Filter: Remove Versioning from scripts. Requires 'ipress_header_clean' to be true. 
- Default: boolean, false
- Return: boolean

'ipress_header_css'
- Filter: Clean CSS tags - from enqueued stylesheet. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_comments'
- Filter: Remove inline Recent Comment Styles from wp_head(). Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_canonical'
- Filter: Disable canonical references. Requires 'ipress_header_clean' to be true.
- Default boolean, false
- Return: boolean

'ipress_header_login'
- Filter: Show less info to users on failed login for security. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_login_info'
- Filter: Generate custom text for login error. 
- Default '<strong>ERROR</strong>: Stop guessing!'
- Return: string

'ipress_disable_emojicons' 
- Filter: Disable theme emojicon support.
- Default: boolean, true
- Return: boolean
- Hook: 'init'

class-layout.php
-------------------
Initialize theme layout features with core WordPress functionality.

'ipress_breadcrumbs'
- Filter: add breadcrumbs body class if breadcrumbs active.
- Default: boolean, false
- Return: boolean

'ipress_body_class'
- Filter: modify body class attributes.
- Default: [], class list
- Return: []

'ipress_read_more_link'
- Filter: read more link.
- Default: false
- Return: bool|string

'ipress_embed_video'
- Filter: embed video html.
- Default: string, html
- Return: string

class-load-scripts.php
-----------------------
Initialize theme and plugin scripts.

'ipress_scripts'
- Filter: Initialise scripts via config file. Set up scripts list in config.php file, example provided.
- Default: []
- Return: []
- Hook: 'init'

'ipress_scripts_core'
- Filter: Set core scripts for enqueueing.
- Default: []
- Return: []
- Hook: 'wp_enqueue_scripts'

'ipress_comment_reply'
- Filter: Turn comments on/off.
- Default: boolean, false
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_scripts_local'
- Filter: Set local scripts for enqueing via inline script.
- Default: []
- Return: []
- Hook: 'wp_enqueue_scripts'

'ipress_header_scripts'
- Filter: Apply header scripts. Loads Theme mod - 'ipress_header_js'. Must have <script></script> wrapper.
- Default: ''
- Return: string
- Hook: 'wp_head'

'ipress_footer_scripts'
- Filter: Apply footer scripts - default ''. Loads Theme mod - 'ipress_footer_js'. Must have <script></script> wrapper.
- Default: ''
- Return: string
- Hook: 'wp_footer'

'ipress_header_admin_scripts'
- Filter: Apply header admin scripts. Loads Theme mod - 'ipress_header_admin_js'. Must have <script></script> wrapper.
- Default: '' 
- Return: string 
- Hook: 'admin_head'

'ipress_footer_admin_scripts'
- Filter: Apply footer admin scripts. Loads Theme mod - 'ipress_footer_admin_js'. Must have <script></script> wrapper.
- Default ''
- Return: string
- Hook: 'admin_footer'

class-load-styles.php
-----------------------
Initialize theme and plugin styles and fonts.

'ipress_styles'
- Filter: Initialise main styles via config file. Set up scripts list in config.php file, example provided.
- Default: []
- Return: []
- Hook: init

'ipress_fonts'
- Filter: Load google API fonts from external source e.g. googleapi.
- Default: []
- Return: []
- Hook: 'wp_enqueue_scripts'

'ipress_fonts_url'
- Filter: Set fonts url when loading external fonts.
- Default: string, 'https://fonts.googleapis.com/css'
- Return: string

'ipress_fonts_subset'
- Filter: Set font family subset when loading external fonts.
- Default: string, 'latin, latin-ext'
- Return: string

'ipress_fonts_media'
- Filter: Set font family media type when loading external fonts.
- Default: string, 'all'
- Return: string, 'all|screen|print|handheld'

'ipress_header_styles'
- Filter: Apply inline header styles.
- Default: ''
- Return: string
- Hook: 'wp_head'

'ipress_header_admin_styles'
- Filter: Apply inline header admin styles - default ''. Loads Theme Mod - 'ipress_header_admin_styles'. 
- Default: ''
- Return: string
- Hook: 'admin_head'

class-login.php
-------------------
Initialisation login page custom features and redirects

'ipress_login_page'
- Filter: Redirect the default login page.
- Default: boolean, false, uses WP login page
- Return: string

ipress_login_failed_page'
- Filter: Custom login failed redirect.
- Default: boolean, false, uses WP login page.
- Return: string

ipress_login_verify_page'
- Filter: Custom login verify redirect.
- Default: boolean, false, uses WP login page.
- Return: string

ipress_login_logout_page'
- Filter: Custom login logout redirect.
- Default: boolean, false, uses WP login page.
- Return: string

class-multisite.php
-------------------
Initialize MultiSite features if theme is multisite enabled.

'ipress_multisite_blogs'
- Filter: Set up list of blogs by user.
- Default: [], generic blogs list for user ID
- Return: []

'ipress_multisite_description'
- Filter: Set up blog description by blog ID.
- Default: ''
- Return: string

'ipress_multisite_sites'
- Filter: Set up list of sites from blobs list.
- Default: [], generics sites list
- Return: []

class-navigation.php
-------------------
Initialisation theme navigation features.

'ipress_nav_clean'
- Filter: Clean navigation markup & remove surrounding 'div'.
- Default: boolean, false
- Return: boolean
- Hook: 'wp_nav_menu_args'

'ipress_nav_css_attr'
- Filter: Remove Injected classes, ID's and Page ID's from Navigation li items.
- Default: boolean, false
- Return: bool

'ipress_navigation_markup_template'
- Filter: Custom navigation markup template.
- Default: string
- Return: string
- Hook: 'navigation_markup_template'

class-page.php
-------------------
Initialize theme page tag & excerpt support.

'ipress_page_excerpt'
- Filter: Page excerpt support.
- Default: boolean, false
- Return: boolean
- Hook: 'init'

'ipress_page_tags'
- Filter: Page tags support.
- Default: boolean, false
- Return: boolean
- Hook: 'init'

'ipress_page_tags_query'
- Filter: Add page tags to query.
- Default: boolean, false
- Return: bool
- Hook: 'pre_get_posts'

'ipress_search_post_types'
- Filter: Add post-types to WordPress front search.
- Default: []
- Return: []
- Hook: 'pre_get_posts'

class-query.php
-----------------
Initialise and manipulate the post main query.

'ipress_query_post_type_archives'
- Filter: List of post-types this query is associated with.
- Default: []
- Return: []
- Hook: 'pre_get_posts'

'ipress_query_exclude_category'
- Filter - Exclude categories from display.
- Default: ['-1'], ( Uncategorised )
- Return: []
- Hook: 'pre_get_posts'

'ipress_query_search_include'
- Filter - Include post-types in search query.
- Default: []
- Return: []
- Hook: 'pre_get_posts'

class-rewrites.php
-------------------
Initialize theme rewrites and query_vars.

'ipress_query_vars'
- Filter: Add new query vars.
- Default: []
- Return: []
- Hook: 'query_vars'

class-sidebars.php
-------------------
Initialize theme sidebars and widget areas.

'ipress_sidebar_defaults'
- Filter: Override default sidebar wrappers: before & after widget, before & after title.
- Default: [ 'before_widget', 'after_widget', 'before_title', 'after_title', 'class' ]		
- Return: []

'ipress_sidebar_{sidebar-id}_defaults'
- Filter: Dynamic sidebar defaults - takes sidebar defaults and sidebar ID.
- Default: [ 'primary', 'header' ]
- Return: []

'ipress_default_sidebars'
- Filter: Creates default sidebars.
- Default: [ primary, header ]
- Return: []

'ipress_footer_widget_rows'
- filter: Default footer widget row number.
- Default: 1
- Return: integer

'ipress_footer_widget_areas'
- Filter: Default footer widget area number.
- Default: 3
- Return: integer

'ipress_custom_sidebars'
- Filter: Register custom sidebars.
- Default: []
- Return: []

class-theme.php
-------------------
Initialize core theme settings.

'ipress_content_width'
- Filter: Set default content width for image manipulation, px.
- Default: 980
- Return: integer
- Hook: 'after_setup_theme'

'ipress_auto_feed_links_support'
- Filter: Add 'automatic-feed-link' theme support.
- Default: boolean, true
- Return: boolean

'ipress_post_thumbnails_support'
- Filter: Add 'post thumbnails' theme support.
- Default: true
- Return: bool

'ipress_post_thumbnails_post_types'
- Filter: Add post-type to thumbnail support. Requires 'post thumbnails' support to be active.
- Default: []
- Return: []

'ipress_post_thumbnail_size'
- Filter: Set thumbnail default size: width, height, crop. Requires 'post thumbnail' support to be active.
- Default: []
- Return: []

'ipress_image_size_default'
- Filter: Core image sizes overrides. Requires post thumbnail support to be active.
- Default: []
- Return: []

'ipress_add_image_size'
- Filter: Add custom image sizes. Requires post thumbnail support to be active.
- Default: []
- Return: []

'ipress_big_image_size
- Filter: Enable / disable 'big image' theme support. Requires post thumbnail support to be active.
- Default: boolean, true
- Return: boolean

'ipress_menus_support'
- Filter: Add nav manus theme support.
- Default: boolean, true
- Return: boolean

'ipress_nav_menu_default'
- Filter: Set default nav menu. Requires nav menus support to be active.
- Default: [ primary ]
- Return: []

'ipress_nav_menus'
- Filter: Register custom navigation menu locations. Requires nav menus support to be active.
- Default: []
- Return: []

'ipress_html5'
- Filter: Enable support for HTML5 markup.
- Default: [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style', 'widgets' ]
- Return: []

'ipress_post_formats'
- Filter: Register post-formats support. Options: 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'.
- Default: []
- Return: []

'ipress_theme_support'
- Filter: Register additional theme support.
- Default: [ 'align-wide', 'responsive-embeds', 'wp-block-styles' ]
- Return: []

'ipress_title_tag'
- Filter: Add title-tag support.
- Default: true
- Return: bool

'ipress_custom_title_tag'
- Filter: Enable custom title-tag functionality.
- Default: boolean, false
- Return: boolean

'ipress_document_title_separator'
- Filter: document title separator. Requires: title-tag support.
- Default: '-'
- Return: string

'ipress_home_doctitle_append'
- Filter: append site description to title on homepage. Requires: title-tag support.
- Default: boolean, true
- Return: string

'ipress_doctitle_separator'
- Filter: title separator. Requires: title-tag support.
- Default: ''
- Return: string

'ipress_append_site_name'
- Filter: append site name to inner pages. Requires: title-tag support.
- Default: boolean, true
- Return: boolean

'ipress_resource_hints'
- Filter:  Add preconnect for Google Fonts.
- Default: []
- Return: []

class-widgets.php
-------------------
Initialisation and register theme widgets.

'ipress_widgets'
- Filter: custom widgets
- Default: []
- Return: []
- Hook: 'widgets_init'

woocommerce/class-adjacent-products.php
-----------------------------------------
WooCommerce adjacent products functionality.

'ipress_woocommerce_adjacent_query_args'
- Filter: Modify args for wc_get_products.
- Default: [ 'limit', 'visibility', 'exclude', 'orderby', 'status' ]
- Return: []

woocommerce/class-customizer.php
-----------------------------------------
WooCommerce specific customizer settings

'ipress_single_product_pagination'
- Filter: Enable / disable the 'ipress_product_pagination' setting.
- Default: boolean, true (on)
- Return: boolean

woocommerce/class-woocommerce.php
-----------------------------------------
WooCommerce settings and custom features.

'ipress_wc_args'
- Filter: Construct WooCommerce default arguments for WooCommerce Theme Support.
- Default: [ 'single_image_width', 'thumbnail_image_width', 'product_grid[]' ]
- Return: []
- Hook: 'after_theme_setup'

'ipress_wc_product_gallery'
- Filter: Enable / disable woocommerce gallery support (zoom, lightbox, slider).
- Default: boolean, true (on)
- Return: boolean

'ipress_wc_core_fonts'
- Filter: Load core WooCommerce fonts. Useful when WooCommerce css loading is disabled via woocommerce_enqueue_styles.
- Default: boolean, false (off)
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_wc_body_classes'
- Filter: Load additional classes to body tag when WooCommerce is active.
- Default: [ 'woocommerce-active' ]
- Return: [], classes
- Hook: 'body_classes'

'ipress_wc_product_loop'
- Filter: Display all products on single page. Disable pagination in product archive listing. Should only be used when a small number of products.
- Default: boolean, false
- Return: boolean
- Hook: 'pre_get_posts'

'ipress_wc_disable_core_css'
- Filter: Disable loading of WooCommerce CSS on front-end non-WC pages when active.
- Default: false, WooCommerce styles loaded on all pages
- Return: boolean

'ipress_wc_disable_css'
- Filter: Disable loading of WooCommerce CSS from custom plugins on front-end non-WC pages when active.
- Default: boolean, false
- Return: boolean
- Hook: wp_enqueue_scripts

'ipress_wc_plugin_styles'
- Filter: List of CSS style handles to disable loading. Requires 'ipress_wc_disable_css' to be enabled.
- Default [ 'wc-block-vendors-style', 'wc-block-style', 'wp-block-library', 'wc-bundle-style', 'wc-composite-css' ]
- Return: []

'ipress_wc_disable_js'
- Filter: Disable loading of WooCommerce JS on front-end non-WC pages when active.
- Default: boolean, false (off), WooCommerce JS loaded on all pages
- Return: boolean

'ipress_wc_disable_cart'
- Filter: Disable loading of WooCommerce Cart/Checkout JS on front-end non-WC pages. Requires 'ipress_wc_disable_js' to be enabled.
- Default: boolean, true (on)
- Return: boolean

'ipress_wc_plugin_scripts'
- Filter: List of custom plugin scripts to dequeue. Requires 'ipress_wc_disable_js' to be enabled.
- Default: []
- Return: []
- Hook: wp_enqueue_scripts

'ip_wc_disable_select2'
- Filter: Disable Select2 JS on front-end if enabled.
- Default: boolean, false (off)
- Return: boolean
- Hook: wp_enqueue_styles

'ipress_wc_breadcrumb_default_args'
- Filter: Default args for WooCommerce header breadcrumb structure.
- Default: [], args
- Return: []
- Hook: 'woocommerce_breadcrumb_defaults'

'ipress_wc_header_cart'
- Filter: Enable / disable header cart fragment for header link & content templates.
- Default: boolean, true (on)
- Return: boolean
- Hook: woocommerce_add_to_cart_fragments

'ipress_product_thumbnail_columns'
- Filter: Default column number for WooCommerce product archive list.
- Default: 4
- Return: integer
- Hook: 'wooCommerce_product_thumbnails_columns'

'ipress_related_products_args'
- Filter: Default related products to display. 
- Default: [ 1 row, 3 columns]
- Return: []
- Hook: 'wooCommerce_output_related_products_args'

'ipress_wc_setup'
- Action: Called during WooCommerce setup. Add additional WooCommerce setup actions.
- Hook: 'after_theme_setup'

'ipress_wc_scripts'
- Action: Called after initialising custom WooCommerce styles.
- Hook: 'wp_enqueue_scripts'

woocommerce/template-functions.php
-----------------------------------

'ipress_product_categories_args'
- Filter: Product Categories shortcode args.
- Default: [ limit', 'columns', 'child_categories', 'orderby', 'title' ]
- Return: []

'ipress_product_categories_shortcode_args'
- Filter: Default args to pass to product_categories shortcode.
- Default: [ 'number', 'columns', 'orderby', 'parent' ]
- Return: []

'ipress_recent_products'
- Filter: Recent Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'title' ]
- Return: []

'ipress_recent_products_shortcode_args'
- Filter: Default args to pass to recent_product shortcode.
- Default: [ 'orderby', 'order', 'per_page', 'columns' ]
- Return: []

'ipress_featured_products_args'
- Filter: Recent Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'visibility', 'title' ]
- Return: []

'ipress_featured_products_shortcode_args'
- Filter: Default args to pass to featured_product shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order', 'visibility' ]
- Return: []

'ipress_popular_products_args'
- Filter: Popular Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'title' ]
- Return: []

'ipress_popular_products_shortcode_args'
- Filter: Default args to pass to popular_products shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order' ]
- Return: []

'ipress_on_sale_products_args'
- Filter: On sale Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'on_sale', 'title' ]
- Return: []

'ipress_on_sale_products_shortcode_args'
- Filter: Default args to pass to on_sale_products shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order', 'on_sale' ]
- Return: []

'ipress_best_selling_products_args'
- Filter: Best selling Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'title' ]
- Return: []

'ipress_best_selling_products_shortcode_args'
- Filter: Default args to pass to best_selling_products shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order' ]
- Return: []

