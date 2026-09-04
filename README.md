# [Breadcrumbs](https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/)
![Plugin Banner](/assets/images/banner-1544x500.png)

Allows breadcrumbs to be placed before and after the content.

## Description

Allows breadcrumbs to be placed before and after the content on a post, page or other public post type.

The `getbreadcrumbs()` function can be added to a theme template to position the breadcrumbs elsewhere on the page such as before the post heading; the `[getbreadcrumbs]` shortcode can also be used to place breadcrumbs.

Function usage, to avoid errors if the plugin is not active is:
```
if (function_exists('getbreadcrumbs')){
	echo getbreadcrumbs('arrow');
}
```

Shortcode usage is `[getbreadcrumbs=arrow]` or `[getbreadcrumbs=text]` to choose between arrow and text breadcrumbs.

The plugin supports both text based and arrow breadcrumbs; to customise their appearance, target the `azrcrv-b-` classes from your theme or child theme's own stylesheet.

Backward compatibility for those migrating from WordPress to ClassicPress has been maintained by retaining the `azc_b_getbreadcrumbs()` function.

This plugin is multisite compatible; each site will need settings to be configured in the admin dashboard.

## Installation

* Download the latest release of the plugin from [GitHub](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/latest/).
* Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
* Activate the plugin.
* Configure relevant settings via the configuration page in the admin control panel (azurecurve menu).

## Frequently Asked Questions

### Can I translate this plugin?
Yes, the .pot file is in the plugin's assets/languages folder; if you do translate this plugin, please send the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).

### Is this plugin compatible with both WordPress and ClassicPress?
This plugin is developed for ClassicPress, but will likely work on WordPress.

### I customised the breadcrumbs' appearance using the Settings tab before updating - where did it go?
As of version 2.0.0, breadcrumb appearance is provided by a standard stylesheet rather than CSS stored in the database and edited from Settings. Add your own CSS rules targeting the `azrcrv-b-` classes from your theme or child theme instead - see the Instructions tab for details.

## Changelog

### [Version 2.0.0](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v2.0.0)

* Rebuilt to match the current azurecurve plugin architecture (namespaced code, settings/menu split across includes files, tabbed admin UI matching the rest of the azurecurve plugin family).
* BREAKING: removed the "Style for text breadcrumbs" / "Style for arrow breadcrumbs" textareas from Settings - breadcrumb appearance is now provided by a standard stylesheet (assets/css/style.css) instead of admin-editable CSS stored in the database. Any previous customisation made via those fields will no longer be applied; use your theme/child theme's own CSS instead.
* Extended "breadcrumbs before/after content" to Posts and other public post types - previously this only ever worked on Pages, due to an `is_page()` check; the shortcode and theme function were unaffected and always worked everywhere.
* Fixed a bug where the archive-breadcrumb-in-the-loop code path used `$post->post-type` instead of `$post->post_type`, which is invalid PHP and fatal on PHP 8.
* Fixed the shared "azurecurve" cross-plugin admin menu being rebuilt (and written to the database) on every single admin page load; it's now only populated on plugin activation/upgrade.
* Fixed several strings using the wrong text domain (`azc_b` instead of the plugin's own), which silently failed to translate.
* Fixed `esc_html_e()` being used on dynamic (non-translatable) page-title text instead of `echo esc_html()`.
* Fixed the `[getbreadcrumbs=type]` shortcode-attribute parser being a fragile, undocumented hack; it now explicitly supports both `[getbreadcrumbs=arrow]` and `[getbreadcrumbs type="arrow"]`.
* Fixed the `getbreadcrumbs()`/`azc_b_getbreadcrumbs()` theme functions echoing their output internally instead of returning it, which didn't match their own documented `echo getbreadcrumbs('arrow');` usage.
* Fixed a possible infinite loop if a post/page's parent chain is ever circular, by adding a maximum recursion depth.
* Fixed the enqueued stylesheet having no version string, so browsers had no cache-busting signal across plugin updates.
* Replaced the hard-coded plugin-index tile list with a standard, auto-generated Other Plugins tab.
* Added an Instructions tab.
* Added proper activation/deactivation hooks, consistent with the rest of the azurecurve plugin family.
* BREAKING: minimum PHP requirement raised to 8.2.
* BREAKING: text domain renamed from `breadcrumbs` to `azrcrv-b`, and the languages folder moved from `/languages` to `/assets/languages`; existing translation (.po/.mo) files must be re-supplied under the new domain/location.
* Update readme.md and remove readme.txt (not required for ClassicPress).
* Update azurecurve menu.

### [Version 1.3.7](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.7)

* Update plugin header for compatibility with ClasssicPress v2.

### [Version 1.3.6](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.6)

* Update plugin header and readme for compatibility with ClassicPress Directory v2.
* Update Update Manager to version 2.5.0.

### [Version 1.3.5](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.5)

* Update readme file for compatibility with ClassicPress Directory.

### [Version 1.3.4](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/tag/v1.3.4)

* Update readme files.
* Update language template.
* Fix bug with azurecurve menu.

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

## Other Notes

### About azurecurve

**azurecurve** was one of the first plugin developers to start developing for ClassicPress; all plugins are available from [azurecurve Development](https://development.azurecurve.co.uk/) and are integrated with the [Update Manager plugin](https://directory.classicpress.net/plugins/update-manager) for fully integrated, no hassle, updates.

The plugins available from **azurecurve** are:

* Add Open Graph Tags - [details](https://development.azurecurve.co.uk/classicpress-plugins/add-open-graph-tags/) / [download](https://github.com/azurecurve/azrcrv-add-open-graph-tags/releases/latest/)
* Add Twitter Cards - [details](https://development.azurecurve.co.uk/classicpress-plugins/add-twitter-cards/) / [download](https://github.com/azurecurve/azrcrv-add-twitter-cards/releases/latest/)
* Avatars - [details](https://development.azurecurve.co.uk/classicpress-plugins/avatars/) / [download](https://github.com/azurecurve/azrcrv-avatars/releases/latest/)
* BBCode - [details](https://development.azurecurve.co.uk/classicpress-plugins/bbcode/) / [download](https://github.com/azurecurve/azrcrv-bbcode/releases/latest/)
* Breadcrumbs - [details](https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/) / [download](https://github.com/azurecurve/azrcrv-breadcrumbs/releases/latest/)
* Broken Links - [details](https://development.azurecurve.co.uk/classicpress-plugins/broken-links/) / [download](https://github.com/azurecurve/azrcrv-broken-links/releases/latest/)
* Call-out Boxes - [details](https://development.azurecurve.co.uk/classicpress-plugins/call-out-boxes/) / [download](https://github.com/azurecurve/azrcrv-call-out-boxes/releases/latest/)
* Chroma - [details](https://development.azurecurve.co.uk/classicpress-plugins/chroma/) / [download](https://github.com/azurecurve/azrcrv-chroma/releases/latest/)
* Code - [details](https://development.azurecurve.co.uk/classicpress-plugins/code/) / [download](https://github.com/azurecurve/azrcrv-code/releases/latest/)
* Comment Validator - [details](https://development.azurecurve.co.uk/classicpress-plugins/comment-validator/) / [download](https://github.com/azurecurve/azrcrv-comment-validator/releases/latest/)
* Conditional Links - [details](https://development.azurecurve.co.uk/classicpress-plugins/conditional-links/) / [download](https://github.com/azurecurve/azrcrv-conditional-links/releases/latest/)
* Contact Forms - [details](https://development.azurecurve.co.uk/classicpress-plugins/contact-forms/) / [download](https://github.com/azurecurve/azrcrv-contact-forms/releases/latest/)
* Disable FLoC - [details](https://development.azurecurve.co.uk/classicpress-plugins/disable-floc/) / [download](https://github.com/azurecurve/azrcrv-disable-floc/releases/latest/)
* Display After Post Content - [details](https://development.azurecurve.co.uk/classicpress-plugins/display-after-post-content/) / [download](https://github.com/azurecurve/azrcrv-display-after-post-content/releases/latest/)
* Estimated Read Time - [details](https://development.azurecurve.co.uk/classicpress-plugins/estimated-read-time/) / [download](https://github.com/azurecurve/azrcrv-estimated-read-time/releases/latest/)
* Events - [details](https://development.azurecurve.co.uk/classicpress-plugins/events/) / [download](https://github.com/azurecurve/azrcrv-events/releases/latest/)
* Feed to Post - [details](https://development.azurecurve.co.uk/classicpress-plugins/feed-to-post/) / [download](https://github.com/azurecurve/azrcrv-feed-to-post/releases/latest/)
* Filtered Categories - [details](https://development.azurecurve.co.uk/classicpress-plugins/filtered-categories/) / [download](https://github.com/azurecurve/azrcrv-filtered-categories/releases/latest/)
* Flags - [details](https://development.azurecurve.co.uk/classicpress-plugins/flags/) / [download](https://github.com/azurecurve/azrcrv-flags/releases/latest/)
* Floating Featured Image - [details](https://development.azurecurve.co.uk/classicpress-plugins/floating-featured-image/) / [download](https://github.com/azurecurve/azrcrv-floating-featured-image/releases/latest/)
* Get GitHub File - [details](https://development.azurecurve.co.uk/classicpress-plugins/get-github-file/) / [download](https://github.com/azurecurve/azrcrv-get-github-file/releases/latest/)
* Icons - [details](https://development.azurecurve.co.uk/classicpress-plugins/icons/) / [download](https://github.com/azurecurve/azrcrv-icons/releases/latest/)
* Image Optimiser - [details](https://development.azurecurve.co.uk/classicpress-plugins/image-optimiser/) / [download](https://github.com/azurecurve/azrcrv-image-optimiser/releases/latest/)
* Images - [details](https://development.azurecurve.co.uk/classicpress-plugins/images/) / [download](https://github.com/azurecurve/azrcrv-images/releases/latest/)
* Insult Generator - [details](https://development.azurecurve.co.uk/classicpress-plugins/insult-generator/) / [download](https://github.com/azurecurve/azrcrv-insult-generator/releases/latest/)
* Load Admin CSS - [details](https://development.azurecurve.co.uk/classicpress-plugins/load-admin-css/) / [download](https://github.com/azurecurve/azrcrv-load-admin-css/releases/latest/)
* Loop Injection - [details](https://development.azurecurve.co.uk/classicpress-plugins/loop-injection/) / [download](https://github.com/azurecurve/azrcrv-loop-injection/releases/latest/)
* Lorem Ipsum Generator - [details](https://development.azurecurve.co.uk/classicpress-plugins/lorem-ipsum-generator/) / [download](https://github.com/azurecurve/azrcrv-lorem-ipsum-generator/releases/latest/)
* Maintenance Mode - [details](https://development.azurecurve.co.uk/classicpress-plugins/maintenance-mode/) / [download](https://github.com/azurecurve/azrcrv-maintenance-mode/releases/latest/)
* Markdown - [details](https://development.azurecurve.co.uk/classicpress-plugins/markdown/) / [download](https://github.com/azurecurve/azrcrv-markdown/releases/latest/)
* Nearby - [details](https://development.azurecurve.co.uk/classicpress-plugins/nearby/) / [download](https://github.com/azurecurve/azrcrv-nearby/releases/latest/)
* Page Index - [details](https://development.azurecurve.co.uk/classicpress-plugins/page-index/) / [download](https://github.com/azurecurve/azrcrv-page-index/releases/latest/)
* Post Archive - [details](https://development.azurecurve.co.uk/classicpress-plugins/post-archive/) / [download](https://github.com/azurecurve/azrcrv-post-archive/releases/latest/)
* Quiz Engine - [details](https://development.azurecurve.co.uk/classicpress-plugins/quiz-engine/) / [download](https://github.com/azurecurve/azrcrv-quiz-engine/releases/latest/)
* Read GitHub File - [details](https://development.azurecurve.co.uk/classicpress-plugins/read-github-file/) / [download](https://github.com/azurecurve/azrcrv-read-github-file/releases/latest/)
* Redirect - [details](https://development.azurecurve.co.uk/classicpress-plugins/redirect/) / [download](https://github.com/azurecurve/azrcrv-redirect/releases/latest/)
* Remove Revisions - [details](https://development.azurecurve.co.uk/classicpress-plugins/remove-revisions/) / [download](https://github.com/azurecurve/azrcrv-remove-revisions/releases/latest/)
* RSS Feed - [details](https://development.azurecurve.co.uk/classicpress-plugins/rss-feed/) / [download](https://github.com/azurecurve/azrcrv-rss-feed/releases/latest/)
* RSS Suffix - [details](https://development.azurecurve.co.uk/classicpress-plugins/rss-suffix/) / [download](https://github.com/azurecurve/azrcrv-rss-suffix/releases/latest/)
* Series Index - [details](https://development.azurecurve.co.uk/classicpress-plugins/series-index/) / [download](https://github.com/azurecurve/azrcrv-series-index/releases/latest/)
* Shortcodes in Comments - [details](https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-comments/) / [download](https://github.com/azurecurve/azrcrv-shortcodes-in-comments/releases/latest/)
* Shortcodes in Widgets - [details](https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-widgets/) / [download](https://github.com/azurecurve/azrcrv-shortcodes-in-widgets/releases/latest/)
* SMTP - [details](https://development.azurecurve.co.uk/classicpress-plugins/smtp/) / [download](https://github.com/azurecurve/azrcrv-smtp/releases/latest/)
* Snippets - [details](https://development.azurecurve.co.uk/classicpress-plugins/snippets/) / [download](https://github.com/azurecurve/azrcrv-snippets/releases/latest/)
* String Inspector - [details](https://development.azurecurve.co.uk/classicpress-plugins/string-inspector/) / [download](https://github.com/azurecurve/azrcrv-string-inspector/releases/latest/)
* Strong Password Generator - [details](https://development.azurecurve.co.uk/classicpress-plugins/strong-password-generator/) / [download](https://github.com/azurecurve/azrcrv-strong-password-generator/releases/latest/)
* Tag Cloud - [details](https://development.azurecurve.co.uk/classicpress-plugins/tag-cloud/) / [download](https://github.com/azurecurve/azrcrv-tag-cloud/releases/latest/)
* Taxonomy Index - [details](https://development.azurecurve.co.uk/classicpress-plugins/taxonomy-index/) / [download](https://github.com/azurecurve/azrcrv-taxonomy-index/releases/latest/)
* Taxonomy Order - [details](https://development.azurecurve.co.uk/classicpress-plugins/taxonomy-order/) / [download](https://github.com/azurecurve/azrcrv-taxonomy-order/releases/latest/)
* Theme Switcher - [details](https://development.azurecurve.co.uk/classicpress-plugins/theme-switcher/) / [download](https://github.com/azurecurve/azrcrv-theme-switcher/releases/latest/)
* Timelines - [details](https://development.azurecurve.co.uk/classicpress-plugins/timelines) / [download](https://github.com/azurecurve/azrcrv-timelines/releases/latest/)
* Toggle Show/Hide - [details](https://development.azurecurve.co.uk/classicpress-plugins/toggle-showhide/) / [download](https://github.com/azurecurve/azrcrv-toggle-showhide/releases/latest/)
* Update Admin Menu - [details](https://development.azurecurve.co.uk/classicpress-plugins/update-admin-menu/) / [download](https://github.com/azurecurve/azrcrv-update-admin-menu/releases/latest/)
* URL Shortener - [details](https://development.azurecurve.co.uk/classicpress-plugins/url-shortener/) / [download](https://github.com/azurecurve/azrcrv-url-shortener/releases/latest/)
* Username Protection - [details](https://development.azurecurve.co.uk/classicpress-plugins/username-protection/) / [download](https://github.com/azurecurve/azrcrv-username-protection/releases/latest/)
* View Counter - [details](https://development.azurecurve.co.uk/classicpress-plugins/view-counter/) / [download](https://github.com/azurecurve/azrcrv-view-counter/releases/latest/)
* Widget Announcements - [details](https://development.azurecurve.co.uk/classicpress-plugins/widget-announcements/) / [download](https://github.com/azurecurve/azrcrv-widget-announcements/releases/latest/)
