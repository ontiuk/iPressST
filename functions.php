<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Theme functions file. Bootstraps the theme functionality.
 * 
 * @package     iPress\Functions
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */

// Access restriction
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

//----------------------------------------------
//	Theme Bootstrapping 
//----------------------------------------------
require_once 'inc/bootstrap.php'; 

//end
