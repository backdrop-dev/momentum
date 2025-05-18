<?php
/**
 * Image Sizes Collection.
 *
 * Houses the collection of image sizes in a single array-object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Image\Size;

use Momentum\Tools\Collection;

/**
 * Image sizes class.
 *
 * @since  0.0.1
 * @access public
 */
class Sizes extends Collection {

	/**
	 * Adds a new image size to the collection.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @param  array   $value
	 * @return void
	 */
	public function add( $name, $value ) {
		parent::add( $name, new Size( $name, $value ) );
	}

	public function customizeChoices( $sizes = [] ) {

		$choices = [];

		foreach ( $this->all() as $size ) {

			if ( $sizes && ! in_array( $size->name(), $sizes ) ) {
				continue;
			}

			$choices[ $size->name() ] = $size->label();
		}

		return $choices;
	}
}
