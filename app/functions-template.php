<?php
/**
 * Template tags.
 *
 * This file holds template tags for the theme. Template tags are PHP functions
 * meant for use within theme templates.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentums
 */

namespace Momentum;

/**
 * Returns the metadata separator.
 *
 * @since  0.0.1
 * @access public
 * @param  string  $sep  String to separate metadata.
 * @return string
 */
function sep( $sep = '' ) {

	return apply_filters(
		'momentum/sep',
		sprintf(
			' <span class="entry__sep">%s</span> ',
			$sep ?: esc_html_x( '&middot;', 'meta separator', 'momentum' )
		)
	);
}

/**
 * Returns the global layout from Customize -> Theme: Content -> Layout:
 * `left-sidebar`, `right-sidebar` or `no-sidebar`.
 *
 * @since  0.0.1
 * @access public
 * @return string
 */
function layout() {

	$layout = Tools\Mod::get( 'theme_content_layout' );

	return apply_filters(
		'momentum/layout',
		in_array( $layout, [ 'left-sidebar', 'right-sidebar', 'no-sidebar' ], true ) ? $layout : Tools\Mod::fallback( 'theme_content_layout' )
	);
}

/**
 * Whether the content shows the primary sidebar: not with the No Sidebar layout, or when the
 * sidebar has no widgets.
 *
 * @since  0.0.1
 * @access public
 * @return bool
 */
function has_sidebar() {

	return 'no-sidebar' !== layout() && is_active_sidebar( 'primary' );
}

/**
 * Returns the classes for the content area: Chassis's `app-content` and `container`, with
 * `app-content--sidebar-left` or `--sidebar-right` when there is a sidebar.
 *
 * @since  0.0.1
 * @access public
 * @return string
 */
function content_class() {

	$classes = [ 'app-content', 'container' ];

	if ( has_sidebar() ) {
		$classes[] = 'left-sidebar' === layout() ? 'app-content--sidebar-left' : 'app-content--sidebar-right';
	}

	return implode( ' ', apply_filters( 'momentum/content/class', $classes ) );
}

/**
 * Displays the primary sidebar next to the content when the layout has one.
 *
 * In the customizer preview it's also printed, hidden, with the No Sidebar layout, so the
 * Layout setting can show and hide it without reloading the preview.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
function display_sidebar() {

	$preview = is_customize_preview() && is_active_sidebar( 'primary' );

	if ( has_sidebar() || $preview ) {
		\Backdrop\View\display( 'sidebar', 'primary', [
			'location' => 'primary',
			'hidden'   => ! has_sidebar(),
		] );
	}
}
