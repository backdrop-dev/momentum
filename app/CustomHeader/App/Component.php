<?php
/**
 * Custom Header Component.
 *
 * Manages the custom header component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\CustomHeader\App;

use Backdrop\Contracts\Bootable;
use Momentum\Tools\Config;

/**
 * Custom Header Component class.
 *
 * @since  0.0.1
 * @access public
 */
class Component implements Bootable {

	/**
	 * Stores the headers collection.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    CustomHeaders
	 */
	protected $headers;

	/**
	 * Creates the component object.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  CustomHeaders  $headers
	 * @return void
	 */
	public function __construct( CustomHeaders $headers ) {
		$this->headers = $headers;
	}

	/**
	 * Bootstraps the component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Enable custom header support
		add_theme_support('custom-header', [
			'default-image' => get_template_directory_uri() . '/public/images/headers/andromeda-galaxy.png',
			'width'         => 1600,
			'height'        => 400,
			'flex-height'   => true,
			'flex-width'    => true,
		]);

		// Register headers on `after_setup_theme`.
		add_action( 'after_setup_theme', [ $this, 'register' ] );

		// Register default headers.
		add_action( 'momentum/core/header/register', [ $this, 'registerHeader' ] );
	}

	/**
	 * Runs the register actions.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		// Hook for registering custom headers.
		do_action( 'momentum/core/header/register', $this->headers );

		// Loop through the collection and register each header.
		foreach ( $this->headers->all() as $header ) {
			register_default_headers( [
				$header->id() => [
					'url'           => $header->url(),
					'thumbnail_url' => $header->url(),
					'description'   => $header->name()
				]
			] );
		}
	}

	/**
	 * Registers default headers.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  CustomHeaders  $headers
	 * @return void
	 */
	public function registerHeader( $headers ) {
		foreach ( Config::get( '_settings-headers' ) as $id => $options ) {
			$headers->add( $id, $options );
		}
	}
}
