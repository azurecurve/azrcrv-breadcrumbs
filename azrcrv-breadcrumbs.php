<?php
/**
 * ------------------------------------------------------------------------------
 * Plugin Name:		Breadcrumbs
 * Description:		Create breadcrumbs trail for posts, pages and other post types.
 * Version:			2.0.0
 * Requires CP:		1.0
 * Requires PHP:	8.2
 * Author:			azurecurve
 * Author URI:		https://development.azurecurve.co.uk/classicpress-plugins/
 * Plugin URI:		https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/
 * Donate link:		https://development.azurecurve.co.uk/support-development/
 * Text Domain:		azrcrv-b
 * Domain Path:		/assets/languages
 * License:			GPLv2 or later
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.html
 * ------------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.html.
 * ------------------------------------------------------------------------------
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
 * Define constants.
 */
const DEVELOPER_SHORTNAME = 'azurecurve';
const DEVELOPER_NAME      = DEVELOPER_SHORTNAME . ' | Development';
const DEVELOPER_RAW_LINK  = 'https://development.azurecurve.co.uk/classicpress-plugins/';
const DEVELOPER_LINK      = '<a href="' . DEVELOPER_RAW_LINK . '">' . DEVELOPER_NAME . '</a>';

const PLUGIN_NAME       = 'Breadcrumbs';
const PLUGIN_SHORT_SLUG = 'breadcrumbs';
const PLUGIN_SLUG       = 'azrcrv-' . PLUGIN_SHORT_SLUG;
const PLUGIN_HYPHEN     = 'azrcrv-b';
const PLUGIN_UNDERSCORE = 'azrcrv_b';
const PLUGIN_FILE       = __FILE__;
const PLUGIN_VERSION    = '2.0.0';

// Option name under which the breadcrumbs settings are stored (see
// includes/functions-settings.php). Left as the same literal value
// ('azrcrv-b') used by the pre-2.0.0 plugin so upgrading keeps existing
// settings without any migration step - the only change is that, from
// 2.0.0 onwards, the 'style-text'/'style-arrow' keys are no longer read or
// written (see PRD.md s7): breadcrumb appearance now comes from
// assets/css/style.css instead of admin-editable CSS.
const SETTINGS_OPTION_NAME = PLUGIN_HYPHEN;

/**
 * Load the remote update client, which integrates with azurecurve's own
 * Update Manager server so this plugin updates the same way as the rest of
 * the azurecurve plugin family.
 *
 * NOTE: per the upgrade PRD, this file is left completely untouched - it
 * already self-registers via UpdateClient::get_instance() under this same
 * namespace at the bottom of the file, exactly as it did before this
 * upgrade.
 */
require_once dirname( PLUGIN_FILE ) . '/libraries/updateclient/UpdateClient.class.php';

/**
 * Load activation/deactivation functions.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-activation.php';

/**
 * Load settings functions.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-settings.php';

/**
 * Load breadcrumb generation/display functions, and the shortcode.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-breadcrumbs.php';

/**
 * Load admin menu functions.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-menu.php';

/**
 * Load custom plugin icon/banner path functions, used by Update Manager.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-plugin-images.php';

/**
 * Load the shared azurecurve cross-plugin menu: populates this plugin's
 * entry into the shared directory of azurecurve plugins, and (if not
 * already added by another azurecurve plugin on this site) registers the
 * shared top-level "azurecurve" admin menu page that lists them all.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/azurecurve-menu-populate.php';
require_once dirname( PLUGIN_FILE ) . '/includes/azurecurve-menu-display.php';

/**
 * Load admin/public script/style enqueue functions.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-scripts.php';

/**
 * Load language functions.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/functions-language.php';

/**
 * Load setup of activation/deactivation hooks, actions and filters. This is
 * required last, since it references functions declared in the files above.
 */
require_once dirname( PLUGIN_FILE ) . '/includes/setup.php';

/**
 * ------------------------------------------------------------------------------
 * Theme-facing public API.
 * ------------------------------------------------------------------------------
 * These two functions are deliberately declared in the GLOBAL namespace, not
 * inside azurecurve\Breadcrumbs above - they are called directly from theme
 * template files (e.g. `if (function_exists('getbreadcrumbs')){ echo
 * getbreadcrumbs('arrow'); }`), so namespacing them would silently break
 * every theme integration relying on that documented contract. Both are
 * thin wrappers around the namespaced generate_breadcrumbs_for_current_post().
 * See PRD.md s6.
 * ------------------------------------------------------------------------------
 */

if ( ! function_exists( 'getbreadcrumbs' ) ) {
	/**
	 * Theme-facing function to return breadcrumbs for the current post/page.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type 'arrow' or 'text'.
	 * @return string Breadcrumbs HTML.
	 */
	function getbreadcrumbs( $type = 'text' ) {
		return \azurecurve\Breadcrumbs\generate_breadcrumbs_for_current_post( $type );
	}
}

if ( ! function_exists( 'azc_b_getbreadcrumbs' ) ) {
	/**
	 * Old function name, kept for backward compatibility for those migrating
	 * from WordPress to ClassicPress.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type 'arrow' or 'text'.
	 * @return string Breadcrumbs HTML.
	 */
	function azc_b_getbreadcrumbs( $type = 'text' ) {
		return \azurecurve\Breadcrumbs\generate_breadcrumbs_for_current_post( $type );
	}
}
