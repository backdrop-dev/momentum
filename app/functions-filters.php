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
