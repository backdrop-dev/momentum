<?php
/**
 * Sidebar.
 *
 * Creates a sidebar object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Sidebar\App;

use JsonSerializable;

/**
 * Sidebar class.
 *
 * @since  0.0.1
 * @access public
 */
class Sidebar implements JsonSerializable {

	/**
	 * Sidebar ID.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $id;

	/**
	 * Sidebar Name.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $name;

	/**
	 * Sidebar Description.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $description;

	/**
	 * Set up the object properties.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $id
	 * @param  array   $options
	 * @return void
	 */
	public function __construct( $id, array $options = [] ) {

		foreach ( array_keys( get_object_vars( $this ) ) as $key )
		{
			if ( isset( $options[ $key ] ) ) {
				$this->$key = $options[ $key ];
			}
		}

		$this->id = $id;
	}

	/**
	 * Returns a JSON-ready array of only the properties we'll need for use
	 * in the customize-preview JS.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {

		return [
			'id'          => $this->id(),
			'name'        => $this->name(),
			'description' => $this->description()
		];
	}

	/**
	 * Returns the sidebar ID.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * Returns the sidebar name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function name() {

		return apply_filters(
			"generosity/sidebar/{$this->id}/name",
			$this->name ?: $this->id(),
			$this
		);
	}

	/**
	 * Returns the sidebar description.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function description() {
		return $this->description;
	}
}
