<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme functions & functionality. Load custom customizer controls.
 *
 * @package iPress\Customize
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// Customizer: custom controls
require_once IPRESS_CONTROLS_DIR . '/class-ipr-checkbox-multiple-control.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require_once IPRESS_CONTROLS_DIR . '/class-ipr-separator-control.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require_once IPRESS_CONTROLS_DIR . '/class-ipr-arbitrary-control.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
