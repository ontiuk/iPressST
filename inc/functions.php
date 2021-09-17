<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality.
 *
 * @package iPress\Functions
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Load functions hooking into core WordPress functionality
include_once IPRESS_INCLUDES_DIR . '/functions/content.php';
include_once IPRESS_INCLUDES_DIR . '/functions/image.php';
include_once IPRESS_INCLUDES_DIR . '/functions/pagination.php';
include_once IPRESS_INCLUDES_DIR . '/functions/navigation.php';
include_once IPRESS_INCLUDES_DIR . '/functions/user.php';

// Load template functions
include_once IPRESS_INCLUDES_DIR . '/functions/template.php';

// Load WooCommerce functions
include_once IPRESS_INCLUDES_DIR . '/functions/product.php';

// Load Advanced Custom Fields functions
include_once IPRESS_INCLUDES_DIR . '/functions/acf.php';
