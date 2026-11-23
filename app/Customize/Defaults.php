<?php
/**
 * Customize defaults.
 *
 * Turns on the Layout, Footer credit and Featured image size components that
 * `backdrop-dev/customize` includes, and gives them Momentum's choices and defaults.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Customize;

use Backdrop\App;
use Backdrop\Contracts\Bootable;

use Momentum\Template\Footer;
use Momentum\Tools\Mod;

/**
 * Customize defaults.
 *
 * @since  0.0.1
 * @access public
 */
class Defaults implements Bootable {

	/**
	 * Adds the filters that enable and configure the built-in components.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function boot(): void {

		add_filter( 'backdrop/customize/layout',         '__return_true' );
		add_filter( 'backdrop/customize/footer_credit',  '__return_true' );
		add_filter( 'backdrop/customize/featured_image', '__return_true' );

		add_filter( 'backdrop/customize/layout_args',         [ $this, 'layout'        ] );
		add_filter( 'backdrop/customize/footer_credit_args',  [ $this, 'footerCredit'  ] );
		add_filter( 'backdrop/customize/featured_image_args', [ $this, 'featuredImage' ] );
	}

	/**
	 * Layout: Customize -> Theme: Content -> Layout.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  array  $args
	 * @return array
	 */
	public function layout( array $args ): array {

		return array_merge( $args, [
			'panel'   => 'theme_content',
			'title'   => esc_html__( 'Layout', 'momentum' ),
			'choices' => App::resolve( 'layouts/global' )->customizeChoices(),
			'default' => Mod::fallback( 'theme_content_layout' ),
		] );
	}

	/**
	 * Footer credit: Customize -> Theme: Footer -> Credit.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  array  $args
	 * @return array
	 */
	public function footerCredit( array $args ): array {

		return array_merge( $args, [
			'title'              => esc_html__( 'Credit', 'momentum' ),
			'powered_by_default' => Mod::fallback( 'theme_footer_powered_by' ),
			'powered_by_label'   => esc_html__( 'Enable random credit text', 'momentum' ),
			'credit_default'     => Mod::fallback( 'theme_footer_custom_credit' ),
			'credit_label'       => esc_html__( 'Custom Credit', 'momentum' ),
			'allowed_html'       => Footer::allowedTags(),
			'selector'           => '.app-footer__credit',
			'render_callback'    => function() {
				return Footer::renderCredit();
			},
		] );
	}

	/**
	 * Featured image size: Customize -> Theme: Content -> Feature Image.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  array  $args
	 * @return array
	 */
	public function featuredImage( array $args ): array {

		return array_merge( $args, [
			'title'     => esc_html__( 'Feature Image', 'momentum' ),
			'label'     => esc_html__( 'Feature Image Size', 'momentum' ),
			'choices'   => App::resolve( 'image/sizes' )->customizeChoices(),
			'default'   => Mod::fallback( 'featured_image_size' ),
			'transport' => 'refresh',
		] );
	}
}
