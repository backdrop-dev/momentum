<?php
/**
 * Image Size.
 *
 * Creates an image size object.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Image\Size;

use JsonSerializable;

/**
 * Image size class.
 *
 * @since  0.0.1
 * @access public
 */
class Size implements JsonSerializable {

	/**
	 * Image size name.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $name;

	/**
	 * Image size label.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    string
	 */
	protected $label;

	/**
	 * Image size width.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    int
	 */
	protected $width = 150;

	/**
	 * Image size height.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    int
	 */
	protected $height = 150;

	/**
	 * Whether to crop the image to exact width and height.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    bool
	 */
	protected $crop = true;

	/**
	 * Whether the size is considered a featured image size.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    bool
	 */
	protected $is_featured_size = true;

	/**
	 * Set up the object properties.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  string  $name
	 * @param  array   $options
	 * @return void
	 */
	public function __construct( $name, array $options ) {
		foreach ( array_keys( get_object_vars( $this ) ) as $key ) {
			if ( isset( $options[ $key ] ) ) {
				$this->$key = $options[ $key ];
			}
		}

		$this->name = $name;
	}

	/**
	 * Returns the image sizes in a format necessary for JSON serialization.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	#[\ReturnTypeWillChange]
	public function jsonSerialize() {
		return [
			'name'   => $this->name(),
			'label'  => $this->label(),
			'width'  => $this->width(),
			'height' => $this->height(),
		];
	}

	/**
	 * Returns the image size name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Returns the image size label.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function label() {
		return apply_filters(
			"generosity/image/size/{$this->name}/label",
			$this->label ?: $this->name(),
			$this
		);
	}

	/**
	 * Returns the image size width.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return int
	 */
	public function width() {
		return absint( $this->width );
	}

	/**
	 * Returns the image size height.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return int
	 */
	public function height() {
		return absint( $this->height );
	}

	/**
	 * Returns whether to hard-crop the image.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return bool
	 */
	public function crop() {
		return (bool) $this->crop;
	}

	/**
	 * Returns whether this is a featured image size.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return bool
	 */
	public function isFeaturedSize() {
		return (bool) $this->is_featured_size;
	}
}
