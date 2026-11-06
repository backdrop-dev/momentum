<?php
/**
 * Theme filters and actions.
 *
 * Adds and defines custom filters and actions the theme adds to core WordPress.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum;

use Momentum\Template\ErrorPage;

/**
 * Filters the excerpt more link.
 *
 * @since  0.0.1
 * @access public
 * @return string
 */
add_filter( 'excerpt_more', function() {

	return sprintf(
		'&thinsp;&hellip;&thinsp;<a href="%s" class="entry-more-link">%s</a>',
		esc_url( get_permalink() ),
		sprintf(
			// Translators: %s is the post title for screen readers.
			esc_html__( 'Continue reading&nbsp;%s&nbsp;&rarr;', 'momentum' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		)
	);
} );

/**
 * Adds error data for the 404 content template. Passes in the `ErrorPage` object
 * as the `$error` variable.
 *
 * @since  0.0.1
 * @access public
 * @param  Backdrop\Tools\Collection  $data
 * @return Backdrop\Tools\Collection
 */
add_filter( 'backdrop/view/content/data', function( $data ) {

	if ( is_404() ) {
		$data->add( 'error', new ErrorPage() );
	}

	return $data;

} );

/**
 * Shows social menu links as icons, with the title kept for screen readers.
 *
 * Looks in `public/svg/social-icons/` for an icon named after the link's site
 * (github.com -> github), then after its title. A link with no matching icon keeps its
 * title as text.
 *
 * @since  0.0.1
 * @access public
 * @param  array    $items The menu items.
 * @param  stdClass $args  The menu arguments.
 * @return array
 */
add_filter( 'wp_nav_menu_objects', function( $items, $args ) {

	if ( 'social' !== $args->theme_location ) {
		return $items;
	}

	foreach ( $items as $item ) {

		$host  = preg_replace( '/^www\./', '', (string) wp_parse_url( $item->url, PHP_URL_HOST ) );
		$names = array_filter( [ strtok( $host, '.' ), sanitize_title( $item->title ) ] );

		foreach ( $names as $name ) {
			$icon = get_parent_theme_file_path( "public/svg/social-icons/{$name}.svg" );

			if ( file_exists( $icon ) ) {
				$item->title = file_get_contents( $icon ) . '<span class="screen-reader-text">' . esc_html( $item->title ) . '</span>'; // phpcs:ignore
				break;
			}
		}
	}

	return $items;
}, 10, 2 );
