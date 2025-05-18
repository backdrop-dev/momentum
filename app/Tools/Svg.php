<?php
/**
 * SVG class.
 *
 * A simple class for returning or outputting an SVG file.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Tools;

class Svg {

	/**
	 * Returns the SVG file contents.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $group
	 * @param  string  $name
	 * @return string
	 */
	public static function render( $group, $name ) {
		$svg = file_get_contents( static::path( $group, "{$name}.svg" ) );

		return apply_filters( "generosity/svg/{$group}/{$name}", $svg ?: '' );
	}

	/**
	 * Displays the SVG.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $group
	 * @param  string  $name
	 * @return void
	 */
	public static function display( $group, $name ) {
		echo static::render( $group, $name ); //phpcs:ignore
	}

	/**
	 * Returns the path to the SVG folder or file if set.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $group
	 * @param  string  $file
	 * @return string
	 */
	public static function path( $group, $file = '' ) {
		$group = trim( $group, '/' );
		$file  = trim( $file, '/' );

		return get_theme_file_path( "public/svg/{$group}/{$file}" );
	}
}
