<?php
/**
 * Default extras template
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum;

/**
 * Changes the theme template path to the `public/views` folder.
 *
 * @since  0.0.1
 * @access public
 * @return string
 */
add_filter( 'backdrop/template/path', function() {
	return 'public/views';
} );

/**
 * Enqueues theme fonts.
 *
 * No fonts are enqueued by default: Chassis uses a system font stack, so
 * the bundled fonts would only add a stylesheet nobody uses. When the
 * theme sets a font in `chassis.json`, enqueue just that font here with
 * `Backdrop\Fonts\enqueue( 'font-slug' )`.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
add_action( 'wp_enqueue_scripts', function() {
	// No fonts to enqueue until the theme sets one in `chassis.json`.
} );
