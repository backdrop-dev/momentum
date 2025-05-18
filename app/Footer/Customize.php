<?php
/**
 * Footer customize class.
 *
 * Adds customizer elements for the footer component.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Footer;

use WP_Customize_Manager;
use Momentum\Customize\Customizable;
use Momentum\Tools\Mod;

use Momentum\Template\Footer;

/**
 * Footer customize class.
 *
 * @since 0.0.1
 * @access public
 */
class Customize extends Customizable {

	/**
	 * Registers customizer sections.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerSections( WP_Customize_Manager $manager ) {

		$manager->add_section( 'theme_footer_credit', [
			'title' => esc_html__( 'Credit', 'momentum' ),
			'panel' => 'theme_footer'
		] );
	}

	/**
	 * Registers customizer settings.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerSettings( WP_Customize_Manager $manager ) {

		// Register footer settings.
		$manager->add_setting( 'theme_footer_powered_by', [
			'default'           => Mod::fallback( 'theme_footer_powered_by' ),
			'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'postMessage',
		] );

		$manager->add_setting( 'theme_footer_custom_credit', [
			// Translators: %s is the theme link.
			'default'           => Mod::fallback( 'theme_footer_custom_credit' ),
            'transport'         => 'postMessage',
			'sanitize_callback' => function( $value ) {
				return wp_kses( $value, Footer::allowedTags() );
			},
		] );
	}

	/**
	 * Registers customizer controls.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerControls( WP_Customize_Manager $manager ) {


		// Powered by control.
		$manager->add_control( 'theme_footer_powered_by', [
			'section'  => 'theme_footer_credit',
			'type'     => 'checkbox',
			'label'    => __( 'Enable random credit text', 'momentum' ),
		] );

    		// Footer credit control.
		$manager->add_control( 'theme_footer_custom_credit', [
			'section'         => 'theme_footer_credit',
			'type'            => 'textarea',
			'label'           => __( 'Custom Credit', 'momentum' ),
		] );
	}

	/**
	 * Registers customizer partials.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param  WP_Customize_Manager  $manager
	 * @return void
	 */
	public function registerPartials( WP_Customize_Manager $manager ) {

		// Footer credit partial.
		$manager->selective_refresh->add_partial( 'theme_footer_powered_by', [
			'selector'            => '.site-footer__credit',
			'container_inclusive' => true,
			'settings'            => [ 'theme_footer_powered_by', 'theme_footer_custom_credit' ],
			'render_callback'     => function() {
				return Footer::renderCredit();
			}
		] );
	}
}
