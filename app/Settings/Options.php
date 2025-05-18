<?php
/**
 * Options Helper.
 *
 * This is an options helper class for quickly getting theme options.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Settings;

/**
 * Options class.
 *
 * @since  0.0.1
 * @access public
 */
class Options {

	/**
	 * Gets a theme option by name. If name is omitted, returns all options.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @return mixed
	 */
	public static function get( $name = '' ) {

		$defaults = static::defaults();
		$settings = wp_parse_args( get_option( 'momentum_settings', $defaults ), $defaults );

		if ( ! $name ) {
			return $settings;
		}

		return isset( $settings[ $name ] ) ? $settings[ $name ] : null;
	}

	/**
	 * Returns an array of all default options.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	public static function defaults() {

		return apply_filters( 'momentum/settings/options/defaults', [
			// 1.0.0
			'disable_emoji'        => true,
			'disable_toolbar'      => false,
			'disable_wp_embed'     => false,
			'error_page'           => 0
		] );
	}
}
