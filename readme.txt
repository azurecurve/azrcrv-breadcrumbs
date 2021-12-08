=== Breadcrumbs ===

Description:	Allows breadcrumbs to be placed before and after the content on a post, page or other post type.
Version:		1.3.3
Tags:			breadcrumbs
Author:			azurecurve
Author URI:		https://development.azurecurve.co.uk/
Plugin URI:		https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/
Download link:	https://github.com/azurecurve/azrcrv-breadcrumbs/releases/download/v1.3.3/azrcrv-breadcrumbs.zip
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

The `getbreadcrumbs()` function can be added to a theme template to position the breadcrumbs elsewhere on the page such as before the post heading; the `[getbreadcrumbs]` shortcode can also be used to place breadcrumbs.

Function usage, to avoid errors if the plugin is not active is: 
```
if (function_exists(azrcrv_getbreadcrumbs)){
	echo azrcrv_getbreadcrumbs('arrow');
}
```

Shortcode usage is `[getbreadcrumbs=arrow]` or `[getbreadcrumbs=text]` to choose between arrow and text breadcrumbs.

The plugin supports both text based and arrow breadcrumbs; styles maintainable via the admin console.

Backward compatibility for those migrating from WordPress to ClassicPress has been maintained by retaining the `azc_b_getbreadcrumbs()` function..

This plugin is multisite compatible; each site will need settings to be configured in the admin dashboard.

== Installation ==

# Installation Instructions

 * Download the latest release of the plugin from [GitHub](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/latest/).
 * Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
 * Activate the plugin.
 * Configure relevant settings via the configuration page in the admin control panel (azurecurve menu).

== Frequently Asked Questions ==

# Frequently Asked Questions

### Can I translate this plugin?
Yes, the .pot file is in the plugins languages folder; if you do translate this plugin, please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).

### Is this plugin compatible with both WordPress and ClassicPress?
This plugin is developed for ClassicPress, but will likely work on WordPress.

== Changelog ==

# Changelog

### [Version 1.3.3](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.3)
 * Update azurecurve menu.
 * Update readme files.

### [Version 1.3.2](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.2)
 * Update azurecurve menu and logo.
 
### [Version 1.3.1](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.1)
 * Fix problem with load of plugin icon and banner.

### [Version 1.3.0](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.0)
 * Fix plugin action link to use admin_url() function.
 * Rewrite option handling so defaults not stored in database on plugin initialisation.
 * Add plugin icon and banner.
 * Update azurecurve plugin menu.

### [Version 1.2.5](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.2.5)
 * Fix bug with undefined post object in archive.

### [Version 1.2.4](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.2.4)
 * Rewrite default option creation function to resolve several bugs.
 * Fix bug with plugin menu.
 * Update plugin menu css.
 
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

**azurecurve** was one of the first plugin developers to start developing for Classicpress; all plugins are available from [azurecurve Development](https://development.azurecurve.co.uk/) and are integrated with the [Update Manager plugin](https://directory.classicpress.net/plugins/update-manager) for fully integrated, no hassle, updates.

Some of the other plugins available from **azurecurve** are:
 * Add Open Graph Tags - [details](https://development.azurecurve.co.uk/classicpress-plugins/add-open-graph-tags/) / [download](https://github.com/azurecurve/azrcrv-add-open-graph-tags/releases/latest/)
 * Add Twitter Cards - [details](https://development.azurecurve.co.uk/classicpress-plugins/add-twitter-cards/) / [download](https://github.com/azurecurve/azrcrv-add-twitter-cards/releases/latest/)
 * Contact Forms - [details](https://development.azurecurve.co.uk/classicpress-plugins/contact-forms/) / [download](https://github.com/azurecurve/azrcrv-contact-forms/releases/latest/)
 * Display After Post Content - [details](https://development.azurecurve.co.uk/classicpress-plugins/display-after-post-content/) / [download](https://github.com/azurecurve/azrcrv-display-after-post-content/releases/latest/)
 * Events - [details](https://development.azurecurve.co.uk/classicpress-plugins/events/) / [download](https://github.com/azurecurve/azrcrv-events/releases/latest/)
 * Flags - [details](https://development.azurecurve.co.uk/classicpress-plugins/flags/) / [download](https://github.com/azurecurve/azrcrv-flags/releases/latest/)
 * Get GitHub File - [details](https://development.azurecurve.co.uk/classicpress-plugins/get-github-file/) / [download](https://github.com/azurecurve/azrcrv-get-github-file/releases/latest/)
 * Icons - [details](https://development.azurecurve.co.uk/classicpress-plugins/icons/) / [download](https://github.com/azurecurve/azrcrv-icons/releases/latest/)
 * Loop Injection - [details](https://development.azurecurve.co.uk/classicpress-plugins/loop-injection/) / [download](https://github.com/azurecurve/azrcrv-loop-injection/releases/latest/)
 * Series Index - [details](https://development.azurecurve.co.uk/classicpress-plugins/series-index/) / [download](https://github.com/azurecurve/azrcrv-series-index/releases/latest/)
