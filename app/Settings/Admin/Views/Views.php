<?php
/**
 * Views Collection.
 *
 * Houses the collection of views in a single array-object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Settings\Admin\Views;

use Backdrop\Tools\Collection;

/**
 * Views class.
 *
 * @since  0.0.1
 * @access public
 */
class Views extends Collection {

	/**
	 * Adds a new view to the collection.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @param  array   $value
	 * @return void
	 */
	public function add( $name, $value ) {

		$view = is_string( $value ) ? new $value() : $value;

		parent::add( $name, $view );
	}
}
