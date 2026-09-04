<?php
/*
	setup - registration of activation/deactivation hooks, actions and
	filters. The admin_post_azrcrv_b_save_settings handler is registered
	directly in functions-settings.php, alongside the functions it calls.
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

// Activation / deactivation.
register_activation_hook( PLUGIN_FILE, __NAMESPACE__ . '\\activate_plugin' );
register_deactivation_hook( PLUGIN_FILE, __NAMESPACE__ . '\\deactivate_plugin' );

// Admin menu.
add_action( 'admin_menu', __NAMESPACE__ . '\\create_admin_menu' );
add_filter( 'plugin_action_links_' . plugin_basename( PLUGIN_FILE ), __NAMESPACE__ . '\\add_plugin_action_link', 10, 2 );

// Update Manager: tell it where to find this plugin's own icon/banner
// images (assets/images) rather than falling back to a generic default.
$plugin_slug_for_um = plugin_basename( trim( PLUGIN_FILE ) );
add_filter( 'codepotent_update_manager_' . $plugin_slug_for_um . '_image_path', __NAMESPACE__ . '\\custom_image_path' );
add_filter( 'codepotent_update_manager_' . $plugin_slug_for_um . '_image_url', __NAMESPACE__ . '\\custom_image_url' );

// Public and admin assets.
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_public_assets' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_admin_assets' );

// Shortcodes - all three case variants, matching the pre-2.0.0 plugin.
add_shortcode( 'getbreadcrumbs', __NAMESPACE__ . '\\shortcode_get_breadcrumbs' );
add_shortcode( 'GetBreadcrumbs', __NAMESPACE__ . '\\shortcode_get_breadcrumbs' );
add_shortcode( 'GETBREADCRUMBS', __NAMESPACE__ . '\\shortcode_get_breadcrumbs' );

// Content breadcrumbs.
add_filter( 'the_content', __NAMESPACE__ . '\\display_breadcrumbs_before_content' );
add_filter( 'the_content', __NAMESPACE__ . '\\display_breadcrumbs_after_content' );

// Language.
add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_languages' );
