<?php
/**
 * Layout Service Provider.
 *
 * Bootstraps the layout components.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Layout;

use Backdrop\Core\ServiceProvider;
/**
 * Layout service provider class.
 *
 * @since  0.0.1
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds layout components to the container.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->app->singleton( 'layouts/global', App\Layouts::class      );

		$this->app->singleton( App\Component::class, function() {
			return new App\Component( $this->app->resolve( 'layouts/global' ) );
		} );

		$this->app->singleton( Customize::class, function() {
			return new Customize( [
				'app_layouts'  => $this->app->resolve( 'layouts/global' ),
			] );
		} );
	}

	/**
	 * Bootstrap the layout family component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {
		$this->app->resolve( App\Component::class )->boot();
	}
}
