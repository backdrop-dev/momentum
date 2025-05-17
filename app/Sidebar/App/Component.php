<?php
/**
 * Sidebar Component.
 *
 * Manages the sidebar component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Sidebar\App;

use Backdrop\Contracts\Bootable;
use Momentum\Tools\Config;

/**
 * Sidebar Component class.
 *
 * @since  0.0.1
 * @access public
 */
class Component implements Bootable {

	/**
	 * Stores the sidebars collection.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    Sidebars
	 */
	protected $sidebars;

	/**
	 * Creates the component object.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  Sidebars  $sidebars
	 * @return void
	 */
	public function __construct( Sidebars $sidebars ) {
		$this->sidebars = $sidebars;
	}

	/**
	 * Bootstraps the component.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot() {

		// Register sidebars on `widgets_init`.
		add_action( 'widgets_init', [ $this, 'register' ] );

		// Register default sidebars.
		add_action( 'momentum/core/sidebar/register', [ $this, 'registerDefaultSidebars' ] );
	}

	/**
	 * Runs the register actions.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function register() {

		// Hook for registering custom sidebars.
		do_action( 'momentum/core/sidebar/register', $this->sidebars );

		// Loop through the collection and register each sidebar.
		foreach ( $this->sidebars->all() as $sidebar ) {
			register_sidebar( [
				'id'            => $sidebar->id(),
				'name'          => $sidebar->name(),
				'description'   => $sidebar->description(),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			] );
		}
	}

	/**
	 * Registers default sidebars.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  Sidebars  $sidebars
	 * @return void
	 */
	public function registerDefaultSidebars( $sidebars ) {
		foreach ( Config::get( '_settings-sidebars' ) as $id => $options ) {
			$sidebars->add( $id, $options );
		}
	}
}
