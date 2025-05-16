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

use Closure;
use Backdrop\App;

use function Backdrop\Theme\mod;

/**
 * Theme mod class.
 *
 * @since  0.0.1
 * @access public
 */
class Mod {

	/**
	 * Returns a theme mod value.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $default
	 * @return mixed
	 */
	public static function get( $name, $default = '' ) {

		$fallback = static::fallback( $name );

		return mod( $name, ! $default && ! is_null( $fallback ) ? $fallback : $default );
	}

	/**
	 * Returns a default theme mod.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $name
	 * @return mixed
	 */
	public static function fallback( $name ) {

		$mods = App::resolve( 'momentum/mods' );

		if ( isset( $mods[ $name ] ) ) {

			return $mods[ $name ] instanceof Closure ? $mods[ $name ]->__invoke() : $mods[ $name ];
		}

		return null;
	}
}
