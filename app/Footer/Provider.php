<?php
/**
 * Footer service provider.
 *
 * Bootstraps the Footer component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Footer;

use Backdrop\Core\ServiceProvider;

/**
 * Footer service provider class.
 *
 * @since  0.0.1
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Binds components to the container.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {
		$this->app->singleton( Customize::class );
	}
}
