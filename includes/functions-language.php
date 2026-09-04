<?php
/*
	language functions
*/

/**
 * Declare the Namespace.
 */
namespace azurecurve\Breadcrumbs;

/**
 * Prevent direct access.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Load plugin translations.
 */
function load_languages() {
	load_plugin_textdomain( 'azrcrv-b', false, dirname( plugin_basename( PLUGIN_FILE ) ) . '/assets/languages/' );
}
