<?php
/*
	activation / deactivation functions
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
 * Plugin activation. This plugin has no database table and no cron - the
 * settings option (see functions-settings.php) is created lazily on first
 * read via wp_parse_args() against the built-in defaults, so there is
 * nothing to set up here beyond what register_activation_hook() already
 * triggers indirectly (e.g. populate_azurecurve_menu(), registered
 * separately in azurecurve-menu-populate.php). Kept as a real function
 * (rather than skipping the activation hook entirely) so future setup
 * steps have somewhere to go without a structural change - this was
 * previously missing entirely from the pre-2.0.0 plugin.
 */
function activate_plugin() {
	// Nothing to do yet.
}

/**
 * Plugin deactivation. Deliberately does NOT delete the settings option -
 * deactivating a plugin should not lose the admin's configuration; that only
 * happens on uninstall (see uninstall.php).
 */
function deactivate_plugin() {
	// Nothing to do yet.
}
