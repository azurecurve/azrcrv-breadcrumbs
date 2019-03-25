=== Breadcrumbs ===
Contributors: azurecurve
Tags: breadcrumbs
Plugin URI: https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/
Donate link: https://development.azurecurve.co.uk/support-development/
Requires at least: 1.0.0
Tested up to: 1.0.0
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows breadcrumbs to be placed before and after the content on a page.

== Description ==
Allows breadcrumbs to be placed before and after the content on a page.

The getbreadcrumbs() function can be added to a theme template to position the breadcrumbs elsewhere on the page such as before the post heading; the [getbreadcrumbs] shortcode can also be used to place breadcrumbs.

Function usage, to avoid errors if the plugin is not active is: if (function_exists(azrcrv_getbreadcrumbs)){ echo azrcrv_getbreadcrumbs('arrow'); }

Shortcode usage is [getbreadcrumbs=arrow] or [getbreadcrumbs=text] to choose between arrow and text breadcrumbs.

The plugin supports both text based and arrow breadcrumbs; styles maintainable via the admin console.

azc_b_getbreadcrumbs function maintained for backward compatibility.

== Installation ==
To install the Breadcrumbs plugin:
* Download the plugin from <a href='https://github.com/azurecurve/azrcrv-breadcrumbs/'>GitHub</a>.
* Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
* Activate the plugin.
* Enable relevant settings via the configuration page in the admin control panel (azurecurve menu).

== Changelog ==
Changes and feature additions for the Breadcrumbs plugin:
= 1.0.0 =
* First version for ClassicPress forked from azurecurve Breadcrumbs WordPress Plugin and converted to OOP.

== Frequently Asked Questions ==
= Can I translate this plugin? =
* Yes, the .pot fie is in the plugins languages folder and can also be downloaded from the plugin page on https://development.azurecurve.co.uk/; if you do translate this plugin, please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).
Changes and feature additions for the Icons plugin:
= 1.0.0 =
* First version for ClassicPress forked from azurecurve RSS Suffix WordPress Plugin.

== Frequently Asked Questions ==
= Can I translate this plugin? =
* Yes, the .pot fie is in the plugin's languages folder and can also be downloaded from the plugin page on https://development.azurecurve.co.uk; if you do translate this plugin please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).
= Is this plugin compatible with both WordPress and ClassicPress? =
* This plugin is developed for ClassicPress, but will likely work on WordPress.