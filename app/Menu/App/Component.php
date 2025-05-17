<?php
/**
 * Menu Component.
 *
 * Manages the menu component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Menu\App;

use Backdrop\Contracts\Bootable;
use Momentum\Tools\Config;

/**
 * Menu Component class.
 *
 * @since  0.0.1
 * @access public
 */
class Component implements Bootable {

	/**
	 * Stores the menus collection.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    Menus
	 */
	protected $menus;

	/**
	 * Creates the component object.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  Menus  $menus
	 * @return void
	 */
	public function __construct( Menus $menus ) {
		$this->menus = $menus;
	}

	/**
	 * Bootstraps the component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Register menus on `after_setup_theme`.
		add_action( 'after_setup_theme', [ $this, 'register' ] );

		// Register default menus.
		add_action( 'momentum/core/menu/register', [ $this, 'registerDefaultMenus' ] );
	}

	/**
	 * Runs the register actions.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		// Hook for registering custom menus.
		do_action( 'momentum/core/menu/register', $this->menus );

		// Loop through the collection and register each menu.
		foreach ( $this->menus->all() as $menu ) {
			register_nav_menu( $menu->id(), $menu->name() );
		}
	}

	/**
	 * Registers default menus.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  Menus  $menus
	 * @return void
	 */
	public function registerDefaultMenus( $menus ) {
		foreach ( Config::get( '_settings-menus' ) as $id => $options ) {
			$menus->add( $id, $options );
		}
	}
}
