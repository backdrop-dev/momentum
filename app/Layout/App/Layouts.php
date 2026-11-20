<?php
/**
 * Layouts Collection.
 *
 * Houses the collection of layouts in a single array-object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Layout\App;

use Momentum\Tools\Collection;

/**
 * Layouts class.
 *
 * @since  0.0.1
 * @access public
 */
class Layouts extends Collection {

	/**
	 * Adds a new layout to the collection.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @param  array   $value
	 * @return void
	 */
	public function add( $name, $value ) {

		parent::add( $name, $value instanceof Layout ? $value : new Layout( $name, $value )
		);
	}

	/**
	 * Returns an array of the choices for the customizer control.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	public function customizeChoices() {
		$choices = [];

		foreach ( $this->all() as $layout ) {
			$choices[ $layout->name() ] = [
				'label' => $layout->label(),
				'url'   => $layout->url(),
			];
		}

		return $choices;
	}
}
