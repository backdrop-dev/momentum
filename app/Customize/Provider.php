<?php
/**
 * Customize service provider.
 *
 * Bootstraps the customize component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Customize;

use Backdrop\Core\ServiceProvider;

/**
 * Customize service provider.
 *
 * @since  0.0.1
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds customize component to the container.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register(): void {

		$this->app->singleton( Component::class, function() {
			return new Component();
		} );
	}

	/**
	 * Bootstrap the customize component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot(): void {
		// The filters must be in place before the customizer registers its components.
		( new Defaults() )->boot();

		$this->app->resolve( Component::class )->boot();
	}
}
