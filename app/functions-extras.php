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

use function Backdrop\Fonts\enqueue;

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
 * Enqueues specific theme fonts.
 *
 * This function enqueues the specified fonts for use in the theme.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
add_action( 'wp_enqueue_scripts', function() {

	// Enqueue Fonts
	enqueue( 'all' );
} );
