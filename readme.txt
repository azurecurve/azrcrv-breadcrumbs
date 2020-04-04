=== Breadcrumbs ===

Description:	Allows breadcrumbs to be placed before and after the content on a post, page or other post type.
Version:		1.2.3
Tags:			breadcrumbs
Author:			azurecurve
Author URI:		https://development.azurecurve.co.uk/
Plugin URI:		https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/
Download link:	https://github.com/azurecurve/azrcrv-breadcrumbs/releases/download/v1.2.3/azrcrv-breadcrumbs.zip
Donate link:	https://development.azurecurve.co.uk/support-development/
Requires PHP:	5.6
Requires:		1.0.0
Tested:			4.9.99
Text Domain:	breadcrumbs
Domain Path:	/languages
License: 		GPLv2 or later
License URI: 	http://www.gnu.org/licenses/gpl-2.0.html

Allows breadcrumbs to be placed before and after the content on a post, page or other post type.

== Description ==

# Description

Allows breadcrumbs to be placed before and after the content on a post, page or other post type.

The **getbreadcrumbs()** function can be added to a theme template to position the breadcrumbs elsewhere on the page such as before the post heading; the **[getbreadcrumbs]** shortcode can also be used to place breadcrumbs.

Function usage, to avoid errors if the plugin is not active is: **if (function_exists(azrcrv_getbreadcrumbs)){ echo azrcrv_getbreadcrumbs('arrow'); }**

Shortcode usage is **[getbreadcrumbs=arrow]** or **[getbreadcrumbs=text]** to choose between arrow and text breadcrumbs.

The plugin supports both text based and arrow breadcrumbs; styles maintainable via the admin console.

Backward compatibility for those migrating from WordPress to ClassicPress has been maintained by retaining the **azc_b_getbreadcrumbs()** function..

This plugin is multisite compatible; each site will need settings to be configured in the admin dashboard.

== Installation ==

# Installation Instructions

 * Download the plugin from [GitHub](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/latest/).
 * Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
 * Activate the plugin.
 * Configure relevant settings via the configuration page in the admin control panel (azurecurve menu).

== Frequently Asked Questions ==

# Frequently Asked Questions

### Can I translate this plugin?
Yes, the .pot fie is in the plugins languages folder and can also be downloaded from the plugin page on https://development.azurecurve.co.uk; if you do translate this plugin, please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).

### Is this plugin compatible with both WordPress and ClassicPress?
This plugin is developed for ClassicPress, but will likely work on WordPress.

== Changelog ==

# Changelog
### [Version 1.2.3](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.2.3)
 * Upgrade azurecurve plugin to store available plugins in options.
 
### [Version 1.2.2](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.2.2)
 * Update Update Manager class to v2.0.0.
 * Update action link.
 * Update azurecurve menu icon with compressed image.

### [Version 1.2.1](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.2.1)
 * Fix bug with incorrect language load text domain.

### [Version 1.2.0](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.2.0)
 * Add integration with Update Manager for automatic updates.
 * Fix issue with display of azurecurve menu.
 * Change settings page heading.
 * Add load_plugin_textdomain to handle translations.

### [Version 1.1.1](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.1.0)
 * Fix bug with display of breadcrumbs on post archives.
 
### [Version 1.1.0](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.1.0)
 * Add functionality to allow breadcrumbs on post archives.
 * Correct issue with localized strings on admin page.

### [Version 1.0.1](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.0.1)
 * Update azurecurve menu for easier maintenance.
 * Move require of azurecurve menu below security check.

### [Version 1.0.0](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.0.0)
 * Initial release for ClassicPress forked from azurecurve Breadcrumbs WordPress Plugin.

== Other Notes ==

# About azurecurve

**azurecurve** was one of the first plugin developers to start developing for Classicpress; all plugins are available from [azurecurve Development](https://development.azurecurve.co.uk/) and are integrated with the [Update Manager plugin](https://codepotent.com/classicpress/plugins/update-manager/) by [CodePotent](https://codepotent.com/) for fully integrated, no hassle, updates.

Some of the top plugins available from **azurecurve** are:
* [Add Twitter Cards](https://development.azurecurve.co.uk/classicpress-plugins/add-twitter-cards/)
* [Breadcrumbs](https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/)
* [Series Index](https://development.azurecurve.co.uk/classicpress-plugins/series-index/)
* [To Twitter](https://development.azurecurve.co.uk/classicpress-plugins/to-twitter/)
* [Theme Switches](https://development.azurecurve.co.uk/classicpress-plugins/theme-switcher/)
* [Toggle Show/Hide](https://development.azurecurve.co.uk/classicpress-plugins/toggle-showhide/)