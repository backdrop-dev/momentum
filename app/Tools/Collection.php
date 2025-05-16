<?php
/**
 * Collection Class.
 *
 * An extension of the Hybrid Core `Collection` class that implements the
 * `JsonSerializable` interface.  Note that this class will be removed in the
 * future if/when this gets added to the framework.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Tools;

use JsonSerializable;
use Backdrop\Tools\Collection as CollectionBase;

/**
 * Collection class.
 *
 * @since  0.0.1
 * @access public
 */
class Collection extends CollectionBase implements JsonSerializable {

	/**
	 * Returns a JSON-ready array of data.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {

		return array_map( function( $value ) {

			if ( $value instanceof JsonSerializable ) {
				return $value->jsonSerialize();
			}

			return $value;

		}, $this->all() );
	}
}
