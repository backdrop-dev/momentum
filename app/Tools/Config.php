<?php
/**
 * Config Class.
 *
 * A simple class for grabbing and returning a configuration file from `/config`.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Tools;

/**
 * Config class.
 *
 * @since  0.0.1
 * @access public
 */
class Config {

	/**
	 * Includes and returns a given PHP config file. The file must return
	 * an array.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @return array
	 */
	public static function get( $name ) {

		$file = static::path( "{$name}.php" );

		return ( array ) apply_filters( "momentum/config/{$name}/", file_exists( $file ) ? include( $file ) : [] );
	}

	/**
	 * Returns the config path or file path if set.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $file
	 * @return string
	 */
	public static function path( $file = '' ) {

		$file = trim( $file, '/' );

		return get_theme_file_path( $file ? "config/{$file}" : 'config' );
	}
}
