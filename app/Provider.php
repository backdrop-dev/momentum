<?php
/**
 * App service provider.
 *
 * Service providers are essentially the bootstrapping code for your theme.
 * They allow you to add bindings to the container on registration and boot them
 * once everything has been registered.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum;

use Backdrop\Core\ServiceProvider;
use Momentum\Tools\Config;

/**
 * App service provider.
 *
 * @since  0.0.1
 * @access public
 */
class Provider extends ServiceProvider {


	/**
	 * Callback executed when the `Backdrop\Core\Application` class registers
	 * providers. Use this method to bind items to the container.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register(): void {

		// Bind a single instance of theme mod defaults.
		$this->app->singleton( 'momentum/mods', function() {

			return array_merge(
				Config::get( '_settings-mods' )
			);
		} );
	}
}
