<?php
/**
 * Custom Headers Collection.
 *
 * Houses the collection of custom headers in a single array-object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\CustomHeader\App;

use Momentum\Tools\Collection;

/**
 * CustomHeaders class.
 *
 * @since  0.0.1
 * @access public
 */
class CustomHeaders extends Collection {

	/**
	 * Adds a new custom header to the collection.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $id
	 * @param  array   $value
	 * @return void
	 */
	public function add( $id, $value ) {
		parent::add( $id, $value instanceof CustomHeader ? $value : new CustomHeader( $id, $value ) );
	}
}
