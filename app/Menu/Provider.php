<?php
/**
 * Component Service Provider.
 *
 * Bootstraps the menu components.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Menu;

use Backdrop\Core\ServiceProvider;

/**
 * Component service provider class.
 *
 * @since  0.0.1
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds sidebar and menu components to the container.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {


		// Register the Sidebars collection with shorthand
		$this->app->singleton( 'momentum/menus', App\Menus::class );

		// Register the Sidebar Component
		$this->app->singleton( App\Component::class, function() {
			return new App\Component( $this->app->resolve( 'momentum/menus' ) );
		});
	}

	/**
	 * Bootstrap the sidebar and menu components.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Boot Sidebar Component
		$this->app->resolve( App\Component::class)->boot();
	}
}
