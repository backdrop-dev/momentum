<?php
/**
 * Layout Component.
 *
 * Manages the layout component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Layout\App;

use Backdrop\Contracts\Bootable;
use Momentum\Tools\Config;

/**
 * Layout component class.
 *
 * @since  0.0.1
 * @access public
 */
class Component implements Bootable {

	/**
	 * Stores the layouts object.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    Layouts
	 */
	protected $layouts;

	/**
	 * Creates the component object.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  Layouts  $global
	 * @param  Layouts  $loop
	 * @return void
	 */
	public function __construct( Layouts $layouts ) {

		$this->layouts = $layouts;
	}

	/**
	 * Bootstraps the component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Run registration on `after_setup_theme`.
		add_action( 'after_setup_theme', [ $this, 'register' ] );

		// Register default layouts.
		add_action( 'generosity/global/layout/register', [ $this, 'registerDefaultLayouts' ] );
	}

	/**
	 * Runs the register actions.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		// Hook for registering custom layouts.
		do_action( 'generosity/global/layout/register', $this->layouts );
	}

	/**
	 * Registers default loop layouts.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  Layouts  $layouts
	 * @return void
	 */
	public function registerDefaultLayouts( $layouts ) {

		foreach ( Config::get( 'global-layouts' ) as $name => $options ) {
			$layouts->add( $name, new Layout( $name, $options ) );
		}
	}
}
