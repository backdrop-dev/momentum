<?php
/**
 * Default theme setup.
 *
 * This is where all the add_theme_support(); will happen.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum;

use function Backdrop\is_classicpress;

/**
 * Set up theme support.  This is where calls to `add_theme_support()` happen.
 *
 * @since  0.0.1
 * @access public
 * @return void
 */
add_action( 'after_setup_theme', function() {

	// Sets the theme content width.
	$GLOBALS['content_width'] = 640;

	// Automatically add the `<title>` tag.
	add_theme_support( 'title-tag' );

	// Automatically add feed links to `<head>`.
	add_theme_support( 'automatic-feed-links' );

	// Adds featured image support.
	add_theme_support( 'post-thumbnails' );

	if ( ! is_classicpress() ) {
		// Outputs HTML5 markup for core features.
		add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ] );
	}

	// Load theme translations.
	load_theme_textdomain( 'generosity', get_parent_theme_file_path( 'public/lang' ) );
} );
