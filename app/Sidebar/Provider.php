<?php
/**
 * Component Service Provider.
 *
 * Bootstraps the sidebar components.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Sidebar;

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
		$this->app->singleton( 'core/sidebars', App\Sidebars::class );

		// Register the Sidebar Component
		$this->app->singleton( App\Component::class, function() {
			return new App\Component( $this->app->resolve( 'core/sidebars' ) );
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
