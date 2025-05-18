<?php
/**
 * Layout.
 *
 * Creates a layout object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Layout\App;

use JsonSerializable;

/**
 * Layout class.
 *
 * @since  0.0.1
 * @access public
 */
class Layout implements JsonSerializable {

	/**
	 * Setting name.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $name;

	/**
	 * Setting label.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $label;

	/**
	 * Setting url.
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
	 * @param  string  $name
	 * @param  array   $options
	 * @return void
	 */
	public function __construct( $name, array $options = [] ) {

		foreach ( array_keys( get_object_vars( $this ) ) as $key )
		{
			if ( isset( $options[ $key ] ) ) {
				$this->$key = $options[ $key ];
			}
		}

		$this->name = $name;
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
			'name' => $this->name()
		];
	}

	/**
	 * Returns the choice name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Returns the choice label.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function label() {

		return apply_filters(
			"generosity/layout/{$this->name}/label",
			$this->label ?: $this->name(),
			$this
		);
	}

	/**
	 * Returns the choice url.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function url() {
		return $this->url;
	}
}
