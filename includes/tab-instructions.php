<?php
/*
	instructions tab
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
?>

<h2><?php esc_html_e( 'Instructions', 'azrcrv-b' ); ?></h2>

<p><?php esc_html_e( 'This plugin creates a breadcrumb trail for posts, pages and other public post types, in either a plain-text or arrow style.', 'azrcrv-b' ); ?></p>

<ol>
	<li><?php esc_html_e( 'Open the Settings tab to choose whether breadcrumbs appear before and/or after the content, whether the homepage is included in the trail, and the separator used for text-style breadcrumbs.', 'azrcrv-b' ); ?></li>
	<li><?php esc_html_e( 'To place breadcrumbs anywhere else on the page, use the shortcode or theme function described below.', 'azrcrv-b' ); ?></li>
</ol>

<h3><?php esc_html_e( 'Shortcode', 'azrcrv-b' ); ?></h3>
<p>
	<?php
	printf(
		/* translators: %1$s and %2$s: example shortcode usage. */
		esc_html__( '%1$s or %2$s can be added anywhere to place breadcrumbs in the desired location.', 'azrcrv-b' ),
		'<strong>[getbreadcrumbs=arrow]</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, developer-controlled markup.
		'<strong>[getbreadcrumbs=text]</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, developer-controlled markup.
	);
	?>
</p>

<h3><?php esc_html_e( 'Theme function', 'azrcrv-b' ); ?></h3>
<p>
	<?php esc_html_e( "This function can be added to a theme template to position the breadcrumbs elsewhere on the page, such as before the post heading. The exists check prevents errors if the plugin is deactivated:", 'azrcrv-b' ); ?>
</p>
<pre><code>if ( function_exists( 'getbreadcrumbs' ) ) {
	echo getbreadcrumbs( 'arrow' );
}</code></pre>
<p>
	<?php esc_html_e( 'Backward compatibility for those migrating from WordPress to ClassicPress is maintained by also providing an azc_b_getbreadcrumbs() function, which behaves identically.', 'azrcrv-b' ); ?>
</p>

<h3><?php esc_html_e( 'Styling', 'azrcrv-b' ); ?></h3>
<p>
	<?php esc_html_e( 'Breadcrumb appearance is provided by this plugin\'s stylesheet. To customise it, add your own CSS rules targeting the azrcrv-b- classes from your theme or child theme - this is no longer configured from the Settings tab.', 'azrcrv-b' ); ?>
</p>
