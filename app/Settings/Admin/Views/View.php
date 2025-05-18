<?php
/**
 * Settings View Base.
 *
 * Abstract base class for creating views.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Settings\Admin\Views;

use Momentum\Settings\Admin\OptionsPage;

/**
 * View class.
 *
 * @since  0.0.1
 * @access public
 */
abstract class View {

	/**
	 * Returns the view name/ID.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	abstract public function name();

	/**
	 * Returns the internationalized, human-readable view label.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	abstract public function label();

	/**
	 * Called on the `admin_init` hook and should be used to register theme
	 * settings via the Settings API.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {}

	/**
	 * Called on the `load-{$page}` hook when the view is booted. Use this
	 * to add any actions or filters needed.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {}

	/**
	 * Called when the page's HTML is output for the view.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function template() {}
}
