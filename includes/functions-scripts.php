<?php
/*
	admin and public script/style enqueue functions.

	As of 2.0.0, breadcrumb appearance (previously two admin-editable CSS
	textareas stored in the database and injected via wp_add_inline_style())
	is a static, versioned stylesheet - assets/css/style.css - enqueued
	unconditionally on the front end, same as any other plugin stylesheet.
	See PRD.md s7/s9. Sites that customise breadcrumb appearance now do so
	from their theme/child theme, not from this plugin's Settings tab.
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
 * Enqueue the public-facing breadcrumbs stylesheet.
 *
 * Fixes a bug in the pre-2.0.0 plugin, whose wp_enqueue_style() call had no
 * version argument at all, so browsers/proxies had no cache-busting signal
 * across plugin updates.
 */
function enqueue_public_assets() {
	wp_enqueue_style(
		PLUGIN_HYPHEN,
		plugins_url( 'assets/css/style.css', PLUGIN_FILE ),
		array(),
		PLUGIN_VERSION
	);
}

/**
 * Enqueue admin CSS/JS, only on this plugin's own admin page or the shared
 * azurecurve cross-plugin menu page (both of which can render the
 * azrcrv-ui-tabs component and the plugin-index grid).
 */
function enqueue_admin_assets( $hook ) {

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only page identifier, not a state-changing action.
	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

	if ( PLUGIN_HYPHEN !== $page && 'azrcrv-plugin-menu' !== $page ) {
		return;
	}

	wp_enqueue_style(
		PLUGIN_HYPHEN . '-admin-standard',
		plugins_url( 'assets/css/admin-standard.css', PLUGIN_FILE ),
		array(),
		PLUGIN_VERSION
	);

	wp_enqueue_style(
		PLUGIN_HYPHEN . '-admin-pluginmenu',
		plugins_url( 'assets/css/admin-pluginmenu.css', PLUGIN_FILE ),
		array(),
		PLUGIN_VERSION
	);

	wp_enqueue_style(
		PLUGIN_HYPHEN . '-admin',
		plugins_url( 'assets/css/admin.css', PLUGIN_FILE ),
		array( PLUGIN_HYPHEN . '-admin-standard' ),
		PLUGIN_VERSION
	);

	wp_enqueue_script(
		PLUGIN_HYPHEN . '-admin-standard',
		plugins_url( 'assets/js/admin-standard.js', PLUGIN_FILE ),
		array(),
		PLUGIN_VERSION,
		true
	);

	wp_enqueue_script(
		PLUGIN_HYPHEN . '-admin',
		plugins_url( 'assets/js/admin.js', PLUGIN_FILE ),
		array( PLUGIN_HYPHEN . '-admin-standard' ),
		PLUGIN_VERSION,
		true
	);
}
