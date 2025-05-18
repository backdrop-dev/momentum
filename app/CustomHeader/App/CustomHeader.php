<?php
/**
 * Custom Header.
 *
 * Creates a header object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\CustomHeader\App;

use JsonSerializable;

/**
 * CustomHeader class.
 *
 * @since  0.0.1
 * @access public
 */
class CustomHeader implements JsonSerializable {

	/**
	 * Header ID.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $id;

	/**
	 * Header Name.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $name;

	/**
	 * Header URL.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $url;

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
			'id'   => $this->id(),
			'name' => $this->name(),
			'url'  => $this->url()
		];
	}

	/**
	 * Returns the header ID.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * Returns the header name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Returns the header URL.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function url() {
		return $this->url;
	}
}
