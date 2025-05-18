<?php
/**
 * Image Service Provider.
 *
 * Bootstraps the image component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Image;

use Backdrop\Core\ServiceProvider;

/**
 * Image service provider class.
 *
 * @since  0.0.1
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds image component to the container.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->app->singleton( Size\Sizes::class   );

		$this->app->singleton( Size\Component::class, function() {
			return new Size\Component(
				$this->app->resolve( Size\Sizes::class )
			);
		} );

		$this->app->alias( Size\Sizes::class,     'image/sizes'   );

		$this->app->singleton( Customize::class, function() {
			return new Customize( [
				'image_sizes'  => $this->app->resolve( 'image/sizes' ),
			] );
		} );

	}

	/**
	 * Bootstrap the image size component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {
		$this->app->resolve( Size\Component::class   )->boot();
	}
}
