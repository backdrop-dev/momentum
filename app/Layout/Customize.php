<?php
/**
 * Layout customize class.
 *
 * Adds customizer elements for the layout component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Layout;

use WP_Customize_Manager;
use Momentum\Customize\Customizable;
use Momentum\Template\FeaturedImage;
use Momentum\Tools\Collection;
use Momentum\Tools\Mod;
use Backdrop\App;
use Backdrop\Customize\Controls\RadioImage;

/**
 * Layout customize class.
 *
 * @since  0.0.1
 * @access public
 */
class Customize extends Customizable {

	/**
	 * App layouts object.
	 *
	 * @since  0.0.1
	 * @access protected
	 * @var    Layouts
	 */
	protected $app_layouts;

	/**
	 * Registers customizer sections.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerSections( WP_Customize_Manager $manager ) {

		$manager->add_section( 'theme_content_layout', [
			'panel'    => 'theme_content',
			'title'    => __( 'Layout', 'momentum' ),
			'priority' => 10
		] );
	}

	/**
	 * Registers customizer settings.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerSettings( WP_Customize_Manager $manager ) {

		$manager->add_setting( 'theme_content_layout', [
			'default'           => Mod::fallback( 'theme_content_layout' ),
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage'
		] );

	}

	/**
	 * Registers customizer controls.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerControls( WP_Customize_Manager $manager ) {

		// Add the layout control.
		$manager->add_control( new RadioImage( $manager, 'theme_content_layout', [
			'label'    => esc_html__( 'Layout', 'momentum' ),
			'section'  => 'theme_content_layout',
			'choices'  => $this->app_layouts->customizeChoices(),
		] ) );
	}


	/**
	 * Registers customizer partials.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerPartials( WP_Customize_Manager $manager ) {

	}

	/**
	* Registers JSON for the customize controls script via `wp_localize_script()`.
	*
	* @since  0.0.1
	* @access public
	* @param  Collection  $json
	* @return void
	*/
	public function controlsJson( Collection $json ) {

	}

	/**
	* Registers JSON for the customize preview script via `wp_localize_script()`.
	*
	* @since  0.0.1
	* @access public
	* @param  Collection  $json
	* @return void
	*/
	public function previewJson( Collection $json ) {

		$json->add( 'globalLayouts',     $this->app_layouts );
	}
}
