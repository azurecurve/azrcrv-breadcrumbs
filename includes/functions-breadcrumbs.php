<?php
/*
	breadcrumb generation/display functions, and the [getbreadcrumbs]
	shortcode. This is the namespaced core that both the shortcode and the
	global getbreadcrumbs()/azc_b_getbreadcrumbs() theme-API wrappers (see
	azrcrv-breadcrumbs.php) call into.
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
 * Shortcode to return breadcrumbs.
 *
 * Supports both the shorthand form used in this plugin's docs,
 * [getbreadcrumbs=arrow], and the standard named-attribute form,
 * [getbreadcrumbs type="arrow"] - the shorthand form is parsed into $atts
 * as a single numerically-indexed, unnamed value by ClassicPress/WordPress'
 * shortcode parser.
 *
 * @since 1.0.0
 */
function shortcode_get_breadcrumbs( $atts, $content = null ) {

	$type = 'text';

	if ( ! empty( $atts ) ) {
		if ( isset( $atts['type'] ) ) {
			// Named-attribute form: [getbreadcrumbs type="arrow"].
			$type = $atts['type'];
		} else {
			// Shorthand form: [getbreadcrumbs=arrow]. There is no space
			// between the tag name and the "=", so ClassicPress/WordPress'
			// shortcode_parse_atts() has nothing to treat as an attribute
			// name before it - the whole "=arrow" is parsed as a single
			// unnamed value, equals sign and all (confirmed against core's
			// actual parser, not just assumed). The leading "=" must be
			// stripped here, same as the pre-2.0.0 plugin did via
			// substr($attribs, 1).
			$type = ltrim( (string) reset( $atts ), '=' );
		}
	}

	$type = trim( str_replace( array( '"', "'" ), '', $type ) );

	return generate_breadcrumbs( get_the_ID(), $type );
}

/**
 * Theme-facing entry point used by the global getbreadcrumbs()/
 * azc_b_getbreadcrumbs() wrapper functions - resolves "the current post" the
 * same way the shortcode does.
 *
 * @since 2.0.0
 */
function generate_breadcrumbs_for_current_post( $type = 'text' ) {
	return generate_breadcrumbs( get_the_ID(), $type );
}

/**
 * Output breadcrumbs before content.
 *
 * As of 2.0.0 this renders for any public, singular post type (Posts, Pages
 * and custom post types), not just Pages - see PRD.md s4.3.
 *
 * @since 1.0.0
 */
function display_breadcrumbs_before_content( $content ) {
	$options = get_settings();

	if ( 'none' !== $options['page-before'] ) {
		return maybe_generate_content_breadcrumbs( get_the_ID(), $options['page-before'] ) . $content;
	}

	return $content;
}

/**
 * Output breadcrumbs after content.
 *
 * @since 1.0.0
 */
function display_breadcrumbs_after_content( $content ) {
	$options = get_settings();

	if ( 'none' !== $options['page-after'] ) {
		return $content . maybe_generate_content_breadcrumbs( get_the_ID(), $options['page-after'] );
	}

	return $content;
}

/**
 * Whether "before/after content" breadcrumbs should render for the given
 * post ID - i.e. we're rendering the main content of a singular, public
 * post type, inside the main loop.
 *
 * Fixes a bug in the pre-2.0.0 plugin, which called in_the_loop($id) -
 * in_the_loop() takes no parameters, so the $id argument was always
 * silently ignored - and only ever checked is_page($id), meaning Posts and
 * every other post type never got before/after-content breadcrumbs at all,
 * only the shortcode/function worked there.
 *
 * @since 2.0.0
 */
function should_display_content_breadcrumbs( $id ) {

	if ( ! in_the_loop() ) {
		return false;
	}

	if ( ! is_singular() ) {
		return false;
	}

	$post_type = get_post_type( $id );

	if ( ! $post_type ) {
		return false;
	}

	$post_type_object = get_post_type_object( $post_type );

	return ( $post_type_object && ! empty( $post_type_object->public ) );
}

/**
 * Generate breadcrumbs for use before/after content, gated by
 * should_display_content_breadcrumbs().
 *
 * @since 1.0.0
 */
function maybe_generate_content_breadcrumbs( $id, $type ) {

	$breadcrumbs = '';

	if ( should_display_content_breadcrumbs( $id ) ) {
		$breadcrumbs = generate_breadcrumbs( $id, $type );
	}

	return $breadcrumbs;
}

/**
 * Generate breadcrumbs.
 *
 * @since 1.0.0
 */
function generate_breadcrumbs( $id, $type ) {

	$id = get_the_id_for_breadcrumbs( $id );

	$options = get_settings();

	$breadcrumbs = '';

	if ( ( 1 === (int) $options['show-on-homepage'] && is_front_page( $id ) ) || ! is_front_page( $id ) ) {

		if ( 'arrow' === esc_html( stripslashes( $type ) ) ) {
			$type               = 'arrow';
			$breadcrumbseparator = '';
		} else {
			$type               = 'text';
			$breadcrumbseparator = ' ' . $options['breadcrumb-separator'] . ' ';
		}

		$title = '';
		$post  = get_post( $id );
		if ( isset( $post ) ) {
			$title = $post->post_title;
		}
		$pageurl = trailingslashit( get_site_url() );

		if ( 1 === (int) $options['add-homepage'] && is_front_page() ) {
			$title = get_bloginfo( 'name' );
		} else {
			$breadcrumbs .= '<a href="' . esc_url( $pageurl ) . '" class="azrcrv-b-' . esc_attr( $type ) . 'breadcrumbs">' . esc_html( get_bloginfo( 'name' ) ) . '</a>' . $breadcrumbseparator;
		}

		if ( is_category() ) {
			$title   = get_cat_name( $id );
			$parents = get_category_parents( $id, false, ',' );
			$parents = explode( ',', $parents );

			foreach ( $parents as $parent ) {
				if ( strlen( $parent ) > 0 && $parent !== $title ) {
					$category_id   = get_cat_ID( $parent );
					$category_link = get_category_link( $category_id );
					$breadcrumbs  .= '<a href="' . esc_url( $category_link ) . '" class="azrcrv-b-' . esc_attr( $type ) . 'breadcrumbs">' . esc_html( $parent ) . '</a>' . $breadcrumbseparator;
				}
			}
		} elseif ( is_archive() && ! in_the_loop() ) {
			$title = get_the_archive_title( '', false );
		} elseif ( is_archive() && in_the_loop() ) {
			$archive_title = get_the_archive_title( '', false );
			// Fixed in 2.0.0: was `$post->post-type` (invalid PHP - parsed
			// as `$post->post` minus the undefined constant `type`, fatal
			// on PHP 8) instead of `$post->post_type`. See PRD.md s4.2.1.
			$archive_link = get_post_type_archive_link( $post->post_type );
			$breadcrumbs  .= '<a href="' . esc_url( $archive_link ) . '" class="azrcrv-b-' . esc_attr( $type ) . 'breadcrumbs">' . esc_html( $archive_title ) . '</a>' . $breadcrumbseparator;
		} else {
			$parents = array();
			$parents = get_breadcrumb_parents( $id, $parents );

			foreach ( array_reverse( $parents ) as $value ) {
				$breadcrumbs .= '<a href="' . esc_url( get_the_permalink( $value['parentid'] ) ) . '" class="azrcrv-b-' . esc_attr( $type ) . 'breadcrumbs">' . esc_html( $value['title'] ) . '</a>' . $breadcrumbseparator;
			}
		}

		if ( 'arrow' === $type ) {
			$breadcrumbs .= '<span class="azrcrv-b-arrowbreadcrumbs">' . esc_html( $title ) . '</span>';
		} else {
			$breadcrumbs .= esc_html( $title );
		}

		$breadcrumbs = "<div class='azrcrv-b-arrowbreadcrumbscontainer'><div class='azrcrv-b-" . esc_attr( $type ) . "breadcrumbs'>" . $breadcrumbs . '</div></div>';
	}

	return $breadcrumbs;
}

/**
 * Get all parents of a post/page, walking up wp_get_post_parent_id().
 *
 * Fixed in 2.0.0: added a maximum-depth guard so a broken/circular parent
 * chain (e.g. from direct DB manipulation, or a bug in another plugin)
 * cannot cause infinite recursion. See PRD.md s4.2.8.
 *
 * @since 1.0.0
 */
function get_breadcrumb_parents( $id, $array, $depth = 0 ) {

	$max_depth = 50;

	if ( $depth >= $max_depth ) {
		return $array;
	}

	$parentid = wp_get_post_parent_id( $id );

	if ( $parentid ) {
		$post    = get_post( $parentid );
		$array[] = array(
			'parentid' => $parentid,
			'title'    => $post->post_title,
			'name'     => $post->post_name,
		);
		$array   = get_breadcrumb_parents( $parentid, $array, $depth + 1 );
	}

	return $array;
}

/**
 * Get id, or the queried object's id if not in the loop.
 *
 * @since 1.1.0
 */
function get_the_id_for_breadcrumbs( $id ) {
	if ( in_the_loop() ) {
		$post_id = $id;
	} else {
		$queried_id = get_queried_object_id();
		$post_id    = 0 === $queried_id ? PHP_INT_MAX : $queried_id;
	}
	return $post_id;
}
