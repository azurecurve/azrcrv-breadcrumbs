<?php
/*
	settings functions - the breadcrumbs settings are stored as a single
	option, shaped as:

	array(
		'add-homepage'         => 1,
		'show-on-homepage'     => 0,
		'page-before'          => 'arrow',
		'page-after'           => 'arrow',
		'breadcrumb-separator' => '&raquo;',
	)

	As of 2.0.0, this option no longer has 'style-text'/'style-arrow' keys -
	breadcrumb appearance is now a static stylesheet (see
	assets/css/style.css and functions-scripts.php) rather than
	admin-editable CSS stored in the database. See PRD.md s7.
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
 * Render the admin page (Settings/Instructions/Other Plugins, in tabs).
 */
function display_admin_page() {

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'azrcrv-b' ) );
	}

	echo '<div class="wrap ' . esc_attr( PLUGIN_HYPHEN ) . '-wrap">';
	echo '<h1>';
		echo '<a href="' . esc_url_raw( DEVELOPER_RAW_LINK ) . esc_attr( PLUGIN_SHORT_SLUG ) . '/"><img src="' . esc_url_raw( plugins_url( 'assets/images/logo.svg', PLUGIN_FILE ) ) . '" style="padding-right: 6px; height: 20px; width: 20px;" alt="' . esc_attr( DEVELOPER_NAME ) . '" /></a>';
		echo esc_html( get_admin_page_title() );
	echo '</h1>';

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only status flag, not a state-changing action.
	if ( isset( $_GET[ PLUGIN_HYPHEN . '-message' ] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$message_key = sanitize_key( wp_unslash( $_GET[ PLUGIN_HYPHEN . '-message' ] ) );
		render_admin_notice( $message_key );
	}

	require_once __DIR__ . '/tabs-output.php';

	echo '</div>';
}

/**
 * Show a dismissible admin notice for a given message key, set via a
 * redirect query arg after a save action.
 */
function render_admin_notice( $message_key ) {

	$messages = array(
		'settings-saved' => array( 'success', __( 'Settings saved.', 'azrcrv-b' ) ),
		'invalid-nonce'  => array( 'error', __( 'Security check failed - please try again.', 'azrcrv-b' ) ),
	);

	if ( ! isset( $messages[ $message_key ] ) ) {
		return;
	}

	list( $type, $text ) = $messages[ $message_key ];
	$css_class            = 'success' === $type ? 'notice-success' : 'notice-error';

	echo '<div class="notice ' . esc_attr( $css_class ) . ' is-dismissible"><p>' . esc_html( $text ) . '</p></div>';
}

/**
 * Build a redirect URL back to the admin page with a status message.
 */
function redirect_with_message( $message_key, $extra_args = array() ) {
	$args = array_merge(
		array(
			'page'                      => PLUGIN_HYPHEN,
			PLUGIN_HYPHEN . '-message' => $message_key,
		),
		$extra_args
	);
	wp_safe_redirect( add_query_arg( $args, admin_url( 'admin.php' ) ) );
	exit;
}

/**
 * The plugin's built-in default values - unchanged from the pre-2.0.0
 * plugin (aside from dropping 'style-text'/'style-arrow', see file header),
 * so upgrading keeps the same default behaviour.
 */
function get_builtin_settings() {
	return array(
		'add-homepage'         => 1,
		'show-on-homepage'     => 0,
		'page-before'          => 'arrow',
		'page-after'           => 'arrow',
		'breadcrumb-separator' => '&raquo;',
	);
}

/**
 * Get the saved settings, merged over the built-in defaults so every key is
 * always present even for a fresh install.
 *
 * Note: sites upgrading from a pre-2.0.0 install will still have
 * 'style-text'/'style-arrow' keys sitting in the stored option until the
 * next time settings are saved (save_settings() only ever writes the
 * current, smaller shape) - they're simply ignored from 2.0.0 onwards.
 */
function get_settings() {
	$stored = get_option( SETTINGS_OPTION_NAME, array() );

	if ( ! is_array( $stored ) ) {
		$stored = array();
	}

	return wp_parse_args( $stored, get_builtin_settings() );
}

/**
 * Persist the settings.
 */
function save_settings( $settings ) {
	update_option( SETTINGS_OPTION_NAME, $settings );
}

/**
 * Build a sanitized settings array from a submitted settings form ($_POST).
 */
function sanitize_settings_from_post( $post_data ) {

	$settings = array();

	$settings['show-on-homepage'] = isset( $post_data['show-on-homepage'] ) ? 1 : 0;
	$settings['add-homepage']     = isset( $post_data['add-homepage'] ) ? 1 : 0;

	$allowed_page_options = array( 'none', 'text', 'arrow' );

	$settings['page-before'] = 'none';
	if ( isset( $post_data['page-before'] ) && in_array( $post_data['page-before'], $allowed_page_options, true ) ) {
		$settings['page-before'] = sanitize_text_field( $post_data['page-before'] );
	}

	$settings['page-after'] = 'none';
	if ( isset( $post_data['page-after'] ) && in_array( $post_data['page-after'], $allowed_page_options, true ) ) {
		$settings['page-after'] = sanitize_text_field( $post_data['page-after'] );
	}

	$settings['breadcrumb-separator'] = '';
	if ( isset( $post_data['breadcrumb-separator'] ) ) {
		$settings['breadcrumb-separator'] = sanitize_text_field( $post_data['breadcrumb-separator'] );
	}

	return $settings;
}

/**
 * Handle the "Save Settings" form on the Settings tab.
 */
function handle_save_settings() {

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permissions to perform this action.', 'azrcrv-b' ) );
	}

	if ( ! isset( $_POST[ PLUGIN_HYPHEN . '-nonce' ] ) || ! check_admin_referer( PLUGIN_HYPHEN . '-save-settings', PLUGIN_HYPHEN . '-nonce' ) ) {
		redirect_with_message( 'invalid-nonce' );
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- nonce already verified above.
	$settings = sanitize_settings_from_post( wp_unslash( $_POST ) );

	save_settings( $settings );

	redirect_with_message( 'settings-saved' );
}
add_action( 'admin_post_' . PLUGIN_UNDERSCORE . '_save_settings', __NAMESPACE__ . '\\handle_save_settings' );
