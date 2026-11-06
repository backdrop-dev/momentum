<?php
/**
 * Default theme scripts functions
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum;
use function Momentum\Vite\asset;

/**
 * Enqueue Scripts and Styles
 *
 * @since  0.0.1
 * @access public
 * @return void
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 * @link   https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 */
add_action( 'wp_enqueue_scripts', function() {

	// Assets are enqueued by their source path. `Momentum\Vite\asset()` looks them up in Vite's
	// manifest.json, which maps them to the built files, whose names change with their contents.

	// The theme's own styles, loaded after Chassis (the `chassis` handle) so they can build on it.
	// The page structure, the menu and the design settings in `chassis.json` come from Chassis.
	wp_enqueue_style( 'momentum-screen', asset( 'resources/scss/screen.scss' ), wp_style_is( 'chassis', 'registered' ) ? [ 'chassis' ] : [], null );

	// The theme's own scripts. Chassis's script already runs the menu.
	wp_enqueue_script( 'momentum-app', asset( 'resources/js/app.js' ), [], null, true );

	// Loads ClassicPress' comment-reply script where appropriate.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );
