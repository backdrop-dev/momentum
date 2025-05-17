<?php
/**
 * Menus Collection.
 *
 * Houses the collection of menus in a single array-object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Menu\App;

use Momentum\Tools\Collection;

/**
 * Menus class.
 *
 * @since  0.0.1
 * @access public
 */
class Menus extends Collection {

	/**
	 * Adds a new menu to the collection.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $id
	 * @param  array   $value
	 * @return void
	 */
	public function add( $id, $value ) {
		parent::add( $id, $value instanceof Menu ? $value : new Menu( $id, $value ) );
	}
}
