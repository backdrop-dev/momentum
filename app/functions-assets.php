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
	// Skipped while the built file is empty, so the page doesn't download nothing.
	$screen = asset( 'resources/scss/screen.scss' );

	if ( has_content( $screen ) ) {
		wp_enqueue_style( 'momentum-screen', $screen, wp_style_is( 'chassis', 'registered' ) ? [ 'chassis' ] : [], null );
	}

	// The theme's own scripts.
	// Chassis's script already runs the menu. Skipped while empty, like the stylesheet.
	$app = asset( 'resources/js/app.js' );

	if ( has_content( $app ) ) {
		wp_enqueue_script( 'momentum-app', $app, [], null, true );
	}

	// Loads ClassicPress' comment-reply script where appropriate.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
} );

/**
 * Whether a built file in the theme has anything in it. Momentum's own stylesheet and script
 * start empty, since Chassis does the work, and load once something is added to them.
 *
 * @since  1.0.0
 * @access public
 * @param  string $url The file's URL, from `Momentum\Vite\asset()`.
 * @return bool
 */
function has_content( string $url ): bool {

	$path = str_replace( trailingslashit( get_template_directory_uri() ), trailingslashit( get_template_directory() ), strtok( $url, '?' ) );

	return is_file( $path ) && '' !== trim( (string) file_get_contents( $path ) );
}
