<?php
/*
	settings tab - lets the admin control where and how breadcrumbs are
	shown. As of 2.0.0 this no longer includes CSS fields - breadcrumb
	appearance comes from assets/css/style.css (see PRD.md s7/s8); use your
	theme/child theme to override it.
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

$settings = get_settings();
?>

<p><?php esc_html_e( 'Breadcrumbs allows the display of breadcrumbs before and after the title and content.', 'azrcrv-b' ); ?></p>

<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

	<input type="hidden" name="action" value="<?php echo esc_attr( PLUGIN_UNDERSCORE ); ?>_save_settings" />
	<?php wp_nonce_field( PLUGIN_HYPHEN . '-save-settings', PLUGIN_HYPHEN . '-nonce' ); ?>

	<table class="form-table azrcrv-b-settings" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><?php esc_html_e( 'Show on homepage', 'azrcrv-b' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php esc_html_e( 'Show on Homepage', 'azrcrv-b' ); ?></span></legend>
						<label for="show-on-homepage"><input name="show-on-homepage" type="checkbox" id="show-on-homepage" value="1" <?php checked( 1, (int) $settings['show-on-homepage'] ); ?> /></label>
					</fieldset>
					<p class="description"><?php esc_html_e( 'Shows breadcrumbs on the homepage.', 'azrcrv-b' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Add homepage', 'azrcrv-b' ); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php esc_html_e( 'Add Homepage', 'azrcrv-b' ); ?></span></legend>
						<label for="add-homepage"><input name="add-homepage" type="checkbox" id="add-homepage" value="1" <?php checked( 1, (int) $settings['add-homepage'] ); ?> /></label>
					</fieldset>
					<p class="description"><?php esc_html_e( 'Adds homepage to the breadcrumb trail.', 'azrcrv-b' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="page-before"><?php esc_html_e( 'Breadcrumbs Before Content', 'azrcrv-b' ); ?></label></th>
				<td>
					<select name="page-before" id="page-before">
						<option value="none" <?php selected( 'none', $settings['page-before'] ); ?>><?php esc_html_e( 'None', 'azrcrv-b' ); ?></option>
						<option value="text" <?php selected( 'text', $settings['page-before'] ); ?>><?php esc_html_e( 'Text', 'azrcrv-b' ); ?></option>
						<option value="arrow" <?php selected( 'arrow', $settings['page-before'] ); ?>><?php esc_html_e( 'Arrow', 'azrcrv-b' ); ?></option>
					</select>
					<p class="description"><?php esc_html_e( 'Shows breadcrumbs before the content of a post, page or other public post type.', 'azrcrv-b' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="page-after"><?php esc_html_e( 'Breadcrumbs After Content', 'azrcrv-b' ); ?></label></th>
				<td>
					<select name="page-after" id="page-after">
						<option value="none" <?php selected( 'none', $settings['page-after'] ); ?>><?php esc_html_e( 'None', 'azrcrv-b' ); ?></option>
						<option value="text" <?php selected( 'text', $settings['page-after'] ); ?>><?php esc_html_e( 'Text', 'azrcrv-b' ); ?></option>
						<option value="arrow" <?php selected( 'arrow', $settings['page-after'] ); ?>><?php esc_html_e( 'Arrow', 'azrcrv-b' ); ?></option>
					</select>
					<p class="description"><?php esc_html_e( 'Shows breadcrumbs after the content of a post, page or other public post type.', 'azrcrv-b' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="breadcrumb-separator"><?php esc_html_e( 'Text Breadcrumbs Separator', 'azrcrv-b' ); ?></label></th>
				<td>
					<input type="text" name="breadcrumb-separator" value="<?php echo esc_attr( stripslashes( $settings['breadcrumb-separator'] ) ); ?>" id="breadcrumb-separator" class="regular-text" />
					<p class="description">
						<?php
						printf(
							/* translators: %1$s and %2$s: example separator characters. */
							esc_html__( 'Character(s) to show between text breadcrumbs (for example %1$s or %2$s).', 'azrcrv-b' ),
							'<strong>&amp;raquo;</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, developer-controlled markup.
							'<strong>::</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, developer-controlled markup.
						);
						?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<?php submit_button( __( 'Save Settings', 'azrcrv-b' ) ); ?>
</form>
