<?php

// Check that code was called from ClassicPress with uninstallation constant declared.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Hard-coded rather than referencing the plugin's constants: ClassicPress
// calls uninstall.php standalone, without loading the main plugin file
// first, so those constants are never defined here. This is the literal
// option name the plugin has always stored its settings under (see
// SETTINGS_OPTION_NAME in the main plugin file) - unchanged by the 2.0.0
// rewrite, even though the array shape stored under it got smaller (the
// 'style-text'/'style-arrow' keys were dropped, see PRD.md s7).
$option_name = 'azrcrv-b';

/**
 * Delete the plugin's own option for the current site.
 *
 * This plugin has no database table and no cron event, so there is nothing
 * else to clean up.
 */
function azrcrv_b_uninstall_cleanup( $option_name ) {
	delete_option( $option_name );
}

// Remove from single site.
if ( ! is_multisite() ) {

	azrcrv_b_uninstall_cleanup( $option_name );

	// Remove from every site on a multisite network.
} else {
	global $wpdb;

	$site_ids         = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_site_id = get_current_blog_id();

	foreach ( $site_ids as $site_id ) {
		switch_to_blog( $site_id );

		azrcrv_b_uninstall_cleanup( $option_name );
	}

	switch_to_blog( $original_site_id );
}
