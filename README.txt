iPress ST - WordPress Theme Framework 
=======================================

=== iPress Child Theme ===
Contributors: tifosi
Requires at least: 5.3
Tested up to: 6.2
Requires PHP: 8.1
Requires WC: 7.0
Stable tag: 2.8.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

iPressST is a Standalone Theme framework based on the iPress Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton themes such as underscores, bones, and html5blank, as well as the latest default WordPress themes, this uses best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Structured hierarchy template structure with hooks: actions & filters.
- Highly configurable class-based functionality hooking into core WordPress functionality.
- Simple default theme that can be easily replaced with your own via child theme.
- Plugin integration: WooCommerce & Advanced Custom Fields
- Lots of helpful stuff: helper functions, shortcodes, menus, extensions etc.

Note: this was intended primarily a development version for personal & client e-commerce projects. 

It contains a basic but functional CSS structure which is based on the normalise.css global reset and a selection of element and component styles and using SCSS. This can be readily replaced, all or in part, by structured framework such as Bootstrap or Tailwind.

== Installation ==

1. Upload the iPress Standalone Theme folder via FTP to your wp-content/themes/ directory.
2. Go to your WordPress dashboard and select Appearance > Themes.
4. Select and activate the iPress Standalone Theme.

To change the theme name and/or create a unique identifier for development purposes modify settings in the bootstrap.php includes file.

IPRESS_THEME_NAME': default 'iPress'
IPRESS_TEXT_DOMAIN': default 'ipress'
IPRESS_THEME_NAMESPACE': default 'ipress'

The theme is translation ready. Default language files can be found in the /languages directory. Currently it's not possible to change the textdomain identifier to a global variable or PHP define.

The default 'ipress' textdomain identifier is present in many of the theme .php files particularly in the template files and includes directory files.

With some editors it's possible to globally modify these. To manually edit them use your favourite code editor and search & replace the 'ipress' values.

For a granular search and replace option each of the textdomain references are placed in the dedicated translation function wrappers:

__() _e() _x() _nx()

== User Manual ==

I'll be updating this asap with details of available filters.

== Widget Areas ==

Primary Sidebar - This is the main sidebar used in sidebars of 2 column pages and footer of some single column pages.

== Support ==

Please visit the github page: https://github.com/ontiuk.

== Other Stuff ==

iPress consists of 3 primary themes:
iPressPT - iPress Parent Theme. Designed to work with an iPressCT child theme.
iPressCT - iPress Child Theme. Requires iPressPT. Child themes can be configured and styled as required.
iPressST - iPress Standalone Theme. Integrates iPressPT & iPressCT. Used for standalone theme development.

ToDo
iPressRX - iPress React Theme Framework. Custom theme for use with the React Framework with particular reference to the WP REST API.
iPress Extensions - Additional modular framework functionality 

== Copyright ==

iPress WordPress Standalone Theme is distributed under the terms of the GNU GPL.

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
| 			|-/scss
| 				|-various dummy folders and example woocommerce.scss
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

'ipress_after_config'
- Action: Initialise functionality after loading config file.

'ipress_scripts'
- Filter: (Add) Register Scripts, Styles & Fonts: Scripts. See inline documentation for more details.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-scripts.php.

'ipress_styles'
- Filter: (Add) Register Scripts, Styles & Fonts: Styles. See inline documentation for more details.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-styles.php.

'ipress_fonts'
- Filter: (Add) Register Scripts, Styles & Fonts: Fonts. See inline documentation for more details.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-styles.php.

'ipress_post_types'
- Filter: (Add) Register Custom Post Types.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-custom.php.

'ipress_taxonomies'
- Filter: (Add) Register taxonomies.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-custom.php.

'ipress_nav_menus'
- Filter: (Add) Register custom menus.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-theme.php.

'ipress_add_image_size'
- Filter: (Add) Register custom image sizes.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-theme.php.

'ipress_media_images'
- Filter: (Add) Register media image options.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-theme.php.

'ipress_post_thumbnails_post_types'
- Filter: (Add) Register post-type post-thumbnail support.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-theme.php.

'ipress_default_sidebars'
- Filter: (Add) Register default theme sidebars.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-sidebars.php.

'ipress_sidebar_defaults'
- Filter: (Add) Register sidebar defaults for wrapping widget & title.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-sidebars.php.

'ipress_footer_sidebars'
- Filter: (Add) Generate footer sidebars.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-sidebars.php.

'ipress_widgets'
- Filter: (Add) Register custom widget areas.
- Default: []
- Return: []
- Uses: filter in parent theme inc/classes/class-ipr-widgets.php.

'ipress_comments_clean'
- Filter: Remove comments functionality.
- Default: true
- Return: boolean

'ipress_disable_emojicons'
- Filter: Remove emoticon functionality.
- Default: true
- Return: boolean

'ipress_body_class'
- Filter: Modify body classes.
- Default: $classes
- Return: []

'ipress_custom_hero'
- Filter: (Add) Enable or disable front page hero section, use '__return_false'to disable
- Default: true
- Return: boolean
- Uses: filter in parent theme inc/classes/class-ipr-hero.php.

ipress_wc_active'
- Filter: (Add) Is the WooCommerce Cart Active, turn on by default
- Default: true
- Return: boolean
- Uses: filter in parent theme inc/woocommerce/class-ipr-woocommerce.php.

'ipress_wc_header_cart_dropdown'
- Filter: (Add) Display the header cart as a dropdown
- Default: true
- Return: boolean
- Uses: filter in parent theme inc/woocommerce/class-ipr-woocommerce.php.

ipress_login_page'
- Filter: (Add) Redirect login page to my account, for non-admins
- Default: '';
- Return: string
- Uses: filter in parent theme inc/classes/class-ipr-redirect.php.

ipress_logout_page'
- Filter: (Add) Redirect logout page to my account, for non-admins
- Default: '';
- Return: string
- Uses: filter in parent theme inc/classes/class-ipr-redirect.php.

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

'ipress_nav_list_mid_size'
- Filter: Mid size for the nav list args
- Default: 1
- Return: integer

'ipress_homepage_image_inline'
- Filter: Display the homepage image, inline
- Default: false
- Return: boolean

acf.php
--------------

'ipress_acf_field_social'
- Filter: Filterable output for ACF social media field
- Default: []
- Return: []

image.php
---------------

'ipress_post_image_args'
- Filter: Image retrieval function default args
- Default: []
- Return: []
- Function: ipress_post_image()

'ipress_pre_post_image'
- Filter: Short-circuit image generation function
- Default: false
- Return: boolean
- Function: ipress_post_image()

pagination.php
---------------

'ipress_next_nav_link'
- Filter: Previous Next Context for ipress_get_prev_next_posts_nav() function
- Default: '&larr; Older'
- Return: string
- Function: 'ipress_get_prev_next_posts_nav'

'ipress_prev_nav_link'
- Filter: Previous Next Context for ipress_get_prev_next_posts_nav() function
- Default: 'Newer &rarr;'
- Return: string
- Function: 'ipress_get_prev_next_posts_nav'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_prev_next_posts_nav() output <section>
- Default: ''
- Return: string
- Function: 'ipress_get_prev_next_posts_nav'

'ipress_post_navigation_args'
- Filter: Set post navigation arguments for ipress_get_prev_next_post_nav() function
- Default: []
- Return: []
- Function: 'ipress_get_prev_next_post_nav'

'ipress_post_navigation_term'
- Filter: Set 'in_same_term' value for post navigation arguments
- Default: '';
- Return: string

'ipress_post_navigation_class'
- Filter: Wrapper class for ipress_get_prev_next_post_nav() output
- Default: ''
- Return: string
- Function: 'ipress_get_prev_next_post_nav'

'ipress_post_navigation_args'
- Filter: Set post navigation arguments for ipress_get_post_navigation() function
- Default: []
- Return: []
- Function: 'ipress_get_post_navigation'

'ipress_post_navigation_term'
- Filter: Set 'in_same_term' value for post navigation arguments
- Default: '';
- Return: string
- Function: 'ipress_get_post_navigation'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_post_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_post_navigation'

'ipress_loop_navigation_args'
- Filter: Set post navigation arguments for ipress_get_loop_navigation() function
- Default: []
- Return: []
- Function: 'ipress_get_loop_navigation'

'ipress_post_navigation_term'
- Filter: Set 'in_same_term' value for post navigation arguments
- Default: '';
- Return: string
- Function: 'ipress_get_loop_navigation'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_pagination() output
- Default: ''
- Return: string
- Function: 'ipress_get_loop_navigation'

'ipress_paginate_links_args'
- Filter: Set post navigation arguments for ipress_get_pagination() function
- Default: []
- Return: []
- Function: 'ipress_get_pagination'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_posts_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_posts_navigation'

'prev_posts_link_attributes'
- Filter: Set class for ipress_get_posts_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_posts_navigation'

'next_posts_link_attributes'
- Filter: Set class for ipress_get_posts_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_posts_navigation'


settings.php
---------------

'ipress_option_defaults'
- Filter: Filterable output for default theme options
- Default: []
- Return: []

'ipress_color_option_defaults'
- Filter: Filterable output for default theme color options
- Default: []
- Return: []

'ipress_default_color_palette'
- Filter: Filterable output for default theme color palette
- Default: []
- Return: []

template.php
--------------

'ipress_get_attr_output'
- Filter: Filterable output for ipress_get_attr()
- Default: '';
- Return: string

'ipress_parse_attr'
- Filter: Filterable output for ipress_parse_attr()
- Default: []
- Return: []

'ipress_{$context}_class'
- Filter: Filterable output for ipress_get_context_classes()
- Default: []
- Return: []

'ipress_header_class'
- Filter: Filterable classlist for ipress_get_header_class()
- Default: []
- Return: []

'ipress_header_style'
- Filter: Filterable output ipress_get_header_style()
- Default: []
- Return: []

'ipress_homepage_image_inline'
- Filter: Use inline image on homepage? ipress_homepage_style()
- Default: true
- Return: boolean

'ipress_homepage_style'
- Filter: Filterable output ipress_homepage_style()
- Default: []
- Return: []

'ipress_header_image_class'
- Filter: Set header image class/es ipress_get_header_image()
- Default: [ 'header-image' ]
- Return: []

'ipress_site_description_args'
- Filter: Filterable site logo & title arguments
- Default: []
- Return: []

'ipress_post_date_prefix'
- Filter: Prefix for post date, ipress_post_date()
- Default: 'Posted On'
- Return: String

'ipress_post_datetime_updated_only'
- Filter: Show all of time string or just updated? ipress_post_date()
- Default: false
- Return: boolean

'ipress_post_date_html'
- Filter: Allowed html tags for this functionality, ipress_post_date()
- Default: []
- Return: []

'ipress_post_author_link'
- Filter: Display author link? ipress_post_author()
- Default: false
- Return: boolean

'ipress_post_author_meta'
- Filter: Post author meta data, 'ipress_post_author()
- Default: ''
- Return: string

'ipress_post_author_html'
- Filter: Allowed html tags for this functionality, ipress_post_author
- Default: []
- Return: []

'ipress_cat_term_separator',
- Filter: Set category list seperator, ipress_post_categories()
- Default: ', '
- Return: string

'ipress_cat_list_prefix',
- Filter: Set category list prefix, ipress_post_categories()
- Default: 'Posted In'
- Return: string

'ipress_tag_term_separator',
- Filter: Set tag list seperator, ipress_post_tags()
- Default: ', '
- Return: string

'ipress_tag_list_prefix',
- Filter: Set tag list prefix, ipress_post_tags()
- Default: 'Tagged In'
- Return: string

'ipress_comments_link_prefix',
- Filter: Set comments list prefix, ipress_post_comments_links()
- Default: 'Comments'
- Return: string

class-ipr-acf.php
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

class-ipr-attr.php
-----------------
Theme HTML attributes functionality.

'ipress_parse_attr'
- Filter: Parse attributes by context
- Default: []
- Return: []

class-ipr-css.php
-----------------
Generate dynamic CSS styles.

'ipress_css_non_zero'
- Filter: List of non-zero css properties.
- Default: [ 'font-size', 'opacity' ]
- Return: []

class-ipr-customizer.php
---------------------
Initialize theme WordPress theme customizer features.

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

'ipress_custom_logo_args'
- Filter: Default args for add_theme_support( 'custom_logo' ). Requires custom logo theme support.
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

'ipress_customize_register_control_type'
- Filter: Register external customizer control types for dynamic JS access
- Default: []
- Return: []

'ipress_customize_register_section_type'
- Filter: Register external customizer section types
- Default: []
- Return: []

'ipress_custom_js'
- Filter: Enable /disable additional JavaScript customizer fields.
- Default: boolean, false (off)
- Return: boolean
- Hook: 'customize_register'

class-ipr-hero.php
------------------
Theme front-page Hero features.

'ipress_custom_hero'
- Filter: Is the custom hero section active
- Default: true / on
- Return: boolean

'ipress_hero_css_cache'
- Filter: Are we using caching?
- Default: false
- Return: boolean

'ipress_hero_css'
- Filter: Filterable CSS output
- Default: ''
- Return: string

'ipress_hero_image_class'
- Filter: Set hero image class, default none
- Default: []
- Return: []

class-ipr-images.php
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

class-ipr-init.php
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

class-ipr-kirki.php
-------------------
Kirki custom functionality

'ipress_kirki_version'
- Filter: Check version, deprecated for v4+
- Default: 4
- Return: integer

'ipress_kirki_config_id'
- Filter: Filterable config ID
- Default: 'ipress_kirki_ID'
- Return: integer

class-ipr-load-fonts.php
------------------------

'ipress_fonts'
- Filter: Retrieve theme fonts, if used
- Default: []
- Return: []

'ip_font_display'
- Filter: Filterable per font option to display if not set
- Default: browser define (auto)
- Return: boolean

'ipress_font_resource_hint_type'
- Filter: Make sure we're using the right type, default preconnect
- Default: 'preconnect'
- Return: string

'ipress_font_resource_hints'
- Filter: Filterable list of urls
- Default: []
- Return: []

class-ipr-load-scripts.php
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

'ipress_header_js'
- Filter: Get option & format in <script></script> tag if set
- Default: ''
- Return: string
- Hook: 'wp_head'

'ipress_footer_js'
- Filter: Get option & format in <script></script> tag if set
- Default: ''
- Return: string
- Hook: 'wp_footer'

'ipress_header_admin_js'
- Filter: Get option & format in <script></script> tag if set
- Default: '' 
- Return: string 
- Hook: 'admin_head'

'ipress_footer_admin_js'
- Filter: Get option & format in <script></script> tag if set
- Default ''
- Return: string
- Hook: 'admin_footer'

class-ipr-load-styles.php
-----------------------
Initialize theme and plugin styles and fonts.

'ipress_styles'
- Filter: Initialise main styles via config file. Set up scripts list in config.php file, example provided.
- Default: []
- Return: []
- Hook: init

'ipress_styles_core'
- Filter: Initialise core styles
- Default: []
- Return: []

'ipress_header_styles'
- Filter: Get option & format in <styles></styles> tag if set
- Default: ''
- Return: string
- Hook: 'wp_head'

'ipress_header_admin_styles'
- Filter: Get option & format in <styles></styles> tag if set
- Default: ''
- Return: string
- Hook: 'admin_head'

class-ipr-login.php
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

class-ipr-multisite.php
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

'ipress_current_blog_users_args'
- Filter: Set get_users function args
- Default: [ 'blog_id, 'orderby', 'fields', 'number' ]
- Return: []

'ipress_multisite_sites'
- Filter: Set up list of sites from blobs list.
- Default: [], generics sites list
- Return: []

class-ipr-navigation.php
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

class-ipr-page.php
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

class-ipr-post-type.php 
-----------------------
Initialize theme specific custom post-types and taxonomies. In general custom post-types and taxonomies should be created using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the theme and integral to it's functionality so they can be more tightly linked to the theme itself.

'ipress_post_types'
- Filter: Set the custom post types.
- Default: []
- Return: [] of post type names
- Config driven post-type generation, see separate docs / config.php for parameters.

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

'ipress_post_type_messages'
- Filter: Set post type helper messages callback.
- Default: []
- Return []

'ipress_{$screen->id}_help
- Filter: Set contextual help tabs.
- Default: []
- Return: []

class-ipr-query.php
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

class-ipr-sidebars.php
-------------------
Initialize theme sidebars and widget areas.

'ipress_sidebar_defaults'
- Filter: Override default sidebar wrappers: before & after widget, before & after title.
- Default: [ 'before_widget', 'after_widget', 'before_title', 'after_title', 'class' ]	
- Return: []

'ipress_before_widget_title'
- Filter: Set before title for current sidebar
- Default: '<h4 class="widget-title">'
- Return: string

'ipress_after_widget_title'
- Filter: Set after title for current sidebar
- Default: '</h4>'
- Return: string

'ipress_sidebar_{sidebar-id}_defaults'
- Filter: Dynamic sidebar defaults - takes sidebar defaults and sidebar ID.
- Default: [ 'primary', 'header' ]
- Return: []

'ipress_default_sidebars'
- Filter: Creates default sidebars.
- Default: [ primary, header ]
- Return: []

'ipress_custom_sidebars'
- Filter: Register custom sidebars.
- Default: []
- Return: []

'ipress_footer_sidebar_rows'
- filter: Default footer sidebar row number.
- Default: 1
- Return: integer

'ipress_footer_sidebar_areas'
- Filter: Default footer sidebar area number.
- Default: 3
- Return: integer

class-ipr-taxonomy.php 
------------------
Initialize theme specific custom post-types and taxonomies. In general custompost-types and taxonomies should be created using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the theme and integral to it's functionality so they can be more tightly linked to the theme itself.

'ipress_taxonomies'
- Filter: Set the taxonomies.
- Default: []
- Return: [] of taxonomy names
- Config driven taxonomy generation, see separate docs / config.php for parameters.

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

class-ipr-theme.php
-------------------
Initialize core theme settings.

'ipress_setup'
- Action: Trigger additional setup functionality
- Hook: 'after_theme_setup'

'ipress_content_width'
- Filter: Set default content width for image manipulation, px.
- Default: 980
- Return: integer
- Hook: 'after_setup_theme'

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
- Default: [ 'automatic-feed-links', 'align-wide', 'responsive-embeds', 'wp-block-styles' ]
- Return: []

'ipress_remove_theme_support'
- Filter: Unregister additional theme support.
- Default: []
- Return: []

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

class-ipr-widgets.php
-------------------
Initialisation and register theme widgets.

'ipress_widgets'
- Filter: custom widgets
- Default: []
- Return: []
- Hook: 'widgets_init'

woocommerce/class-ipr-woocommerce.php
-----------------------------------------
WooCommerce settings and custom features.

'ipress_wc_init'
- Action: Called during WooCommerce setup. Add additional WooCommerce setup actions/filters.

'ipress_wc_setup'
- Action: Called during WooCommerce setup. Add additional WooCommerce setup actions.
- Hook: 'after_theme_setup'

'ipress_wc_custom_styles'
- Action: Called after initialising custom WooCommerce styles.
- Hook: 'wp_enqueue_scripts'

'ipress_wc_custom_scripts'
- Action: Called after initialising custom WooCommerce styles.
- Hook: 'wp_enqueue_scripts'

'ipress_wc_active'
- Filter: Turn on/off core cart functionality, true for active cart
- Default: true, (active)
- Return: boolean

'ipress_wc_args'
- Filter: Construct WooCommerce defanult arguments for WooCommerce Theme Support
- Default: [ 'single_image_width', 'thumbnail_image_width', 'product_grid[]' ]
- Return: []
- Hook: 'after_theme_setup'

'ipress_wc_product_gallery'
- Filter: Enable / disable woocommerce gallery support (zoom, lightbox, slider)
- Default: boolean, true (on)
- Return: boolean
- Hook: 'after_theme_setup'

'ipress_wc_register_taxonomy_menus'
- Filter: Register product attribute taxonomies to the menus API
- Default: []
- Return: []
- Hook: 'after_theme_setup'

'ipress_wc_background_image_regeneration'
- Filter: Turn on/off automatic thumbnail regeneration on theme change
- Default: true ( active )
- Return: boolean
- Hook: 'woocommerce_background_image_regeneration'

'ipress_wc_body_classes'
- Filter: Load additional classes to body tag when WooCommerce is active.
- Default: [ 'woocommerce-active' ]
- Return: [], classes list
- Hook: 'body_classes'

'ipress_wc_product_loop'
- Filter: Display all products on single page. Disable pagination in product archive listing. Should only be used when a small number of products.
- Default: boolean, false
- Return: boolean
- Hook: 'pre_get_posts'

'ipress_wc_add_to_cart_text'
- Filter: Change default add to cart text depending on context
- Default: ''
- Return: string
- Hook: woocommerce_product_add_to_cart_text

'ipress_wc_breadcrumb_default_args'
- Filter: Change default breadcrumbs display args
- Default: []
- Return: []
- Hook: 'woocommerce_breadcrumb_defaults'

'ipress_wc_disable_css'
- Filter: Disable loading of WooCommerce CSS from custom plugins on front-end non-WC pages when active.
- Default: boolean, false
- Return: boolean
- Hook: wp_enqueue_scripts

'ipress_wc_disable_wc_css'
- Filter: Disable loading of WooCommerce CSS for all non-WC pages.
- Default: boolean, false
- Return: boolean
- Hook: wp_enqueue_scripts

'ipress_wc_disable_core_css'
- Filter: Disable loading of core WooCommerce CSS files.
- Default: []
- Return: []
- Hook: wp_enqueue_scripts

'ipress_wc_plugin_styles'
- Filter: List of CSS style handles to disable loading. Requires 'ipress_wc_disable_css' to be enabled.
- Default [ 'wc-block-vendors-style', 'wc-block-style', 'wp-block-library', 'wc-bundle-style', 'wc-composite-css' ]
- Return: []

'ipress_wc_core_fonts'
- Filter: Load core WooCommerce fonts. Useful when WooCommerce css loading is disabled via woocommerce_enqueue_styles.
- Default: boolean, false (off)
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_wc_custom_styles'
- Filter: Define location for custom css files loading
- Default: true, all pages
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_wc_custom_styles_dependency'
- Filter: Default loading dependency
- Default: [ 'woocommerce-general' ]
- Return: []
- Hook: 'wp_enqueue_scripts'

'ipress_wc_disable_js'
- Filter: Disable loading of WooCommerce JS on front-end non-WC pages when active.
- Default: boolean, false (off), WooCommerce JS loaded on all pages
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_wc_plugin_scripts'
- Filter: List of custom plugin scripts to dequeue. Requires 'ipress_wc_disable_js' to be enabled.
- Default: []
- Return: []
- Hook: wp_enqueue_scripts

'ipress_wc_disable_cart_js'
- Filter: Disable loading of WooCommerce Cart/Checkout JS on front-end non-WC pages. Requires 'ipress_wc_disable_js' to be enabled.
- Default: boolean, true (on)
- Return: boolean
- Hook: wp_enqueue_scripts

'ipress_wc_disable_select2'
- Filter: Disable Select2 JS on front-end if enabled.
- Default: boolean, false (off)
- Return: boolean
- Hook: wp_enqueue_styles

'ipress_wc_generator'
- Filter: Dequeue WC head generator styles
- Default: false
- Return: boolean
- Hook: wp_enqueue_styles

'ipress_wc_custom_scripts'
- Filter: Define location for custom js files loading
- Default: true, all pages
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_wc_custom_scripts_dependency'
- Filter: Default loading dependency
- Default: []
- Return: []

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

'ipress_wc_catalog_random_ordering'
- Filter: Add custom pandom ordering to product archives
- Default: false
- Return: boolean

'ipress_related_products_args'
- Filter: Default related products to display. 
- Default: [ 1 row, 3 columns]
- Return: []
- Hook: 'woocommerce_output_related_products_args'

'ipress_upsell_products_args'
- Filter: Default upsell products to display. 
- Default: [ 1 row, 2 columns]
- Return: []
- Hook: 'woocommerce_upsell_display_args''

- 'ipress_wc_active_redirect'
- Filter: Redirect for Cart, Checkout & Account pages when cart inactive
- Default: home_url
- Return: none

'ipress_default_checkout_country'
- Filter: Fix the checkout country value
- Default: GB
- Return: string

'ipress_default_checkout_state'
- Filter: Fix the checkout state value
- Default: ''
- Return: string

woocommerce/class-ipr-adjacent-products.php
-----------------------------------------
WooCommerce adjacent products functionality.

'ipress_woocommerce_adjacent_query_args'
- Filter: Modify args for wc_get_products.
- Default: [ 'limit', 'visibility', 'exclude', 'orderby', 'status' ]
- Return: []

woocommerce/class-ipr-customizer.php
-----------------------------------------
WooCommerce specific customizer settings

'ipress_single_product_pagination'
- Filter: Enable / disable the 'ipress_product_pagination' setting.
- Default: boolean, true (on)
- Return: boolean

woocommerce/functions.php
-------------------------

'ipress_wc_pages_list'
- Filter: Set up filterable WooCommerce virtual page list
- Default: []
- Return: []
- Function: ipress_wc_pages()

'ipress_product_archive'
- Filter: Filterable posts list
- Default: []
- Return: []
- Function ipress_wc_get_archive()

woocommerce/template-functions.php
-----------------------------------

'ipress_wc_header_cart'
- Filter: Is the header cart active?
- Default: true
- Return: boolean

'ipress_wc_header_cart_dropdown'
- Filter: Is the header cart dropdown active? If not then use slider
- Default: false
- Return: boolean

'ipress_product_categories_args'
- Filter: Product Categories shortcode args.
- Default: [ limit', 'columns', 'child_categories', 'orderby', 'title' ]
- Return: []

'ipress_product_categories_shortcode_args'
- Filter: Default args to pass to product_categories shortcode.
- Default: [ 'number', 'columns', 'orderby', 'parent' ]
- Return: []

'ipress_before_product_categories'
- Action: Before product category html

'ipress_after_product_categories_title'
- Action: After product category title

'ipress_after_product_categories'
- Action: After product category html

'ipress_recent_products_args'
- Filter: Recent Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'title' ]
- Return: []

'ipress_recent_products_shortcode_args'
- Filter: Default args to pass to recent_product shortcode.
- Default: [ 'orderby', 'order', 'per_page', 'columns' ]
- Return: []

'ipress_before_recent_products'
- Action: Before recent products html

'ipress_after_recent_products_title'
- Action: After recent products title

'ipress_after_recent_products'
- Action: After recent products html

'ipress_featured_products_args'
- Filter: Recent Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'visibility', 'title' ]
- Return: []

'ipress_featured_products_shortcode_args'
- Filter: Default args to pass to featured_product shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order', 'visibility' ]
- Return: []

'ipress_before_featured_products'
- Action: Before featured products html

'ipress_after_featured_products_title'
- Action: After featured products title

'ipress_after_featured_products'
- Action: After featured products html

'ipress_popular_products_args'
- Filter: Popular Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'title' ]
- Return: []

'ipress_popular_products_shortcode_args'
- Filter: Default args to pass to popular_products shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order' ]
- Return: []

'ipress_before_popular_products'
- Action: Before popular products html

'ipress_after_popular_products_title'
- Action: After popular products title

'ipress_after_popular_products'
- Action: After popular products html

'ipress_on_sale_products_args'
- Filter: On sale Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'on_sale', 'title' ]
- Return: []

'ipress_on_sale_products_shortcode_args'
- Filter: Default args to pass to on_sale_products shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order', 'on_sale' ]
- Return: []

'ipress_before_on_sale_products'
- Action: Before on sale products html

'ipress_after_on_sale_products_title'
- Action: After on sale products title

'ipress_after_on_sale_products'
- Action: After on sale products html

'ipress_best_selling_products_args'
- Filter: Best selling Products shortcode args.
- Default: [ 'limit', 'columns', 'orderby', 'order', 'title' ]
- Return: []

'ipress_best_selling_products_shortcode_args'
- Filter: Default args to pass to best_selling_products shortcode.
- Default: [ 'per_page', 'columns', 'orderby', 'order' ]
- Return: []

'ipress_before_best_selling_products'
- Action: Before best selling products html

'ipress_after_best_selling_products_title'
- Action: After best selling products title

'ipress_after_best_selling_products'
- Action: After best selling products html
