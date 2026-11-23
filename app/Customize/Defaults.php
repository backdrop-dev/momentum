<?php
/**
 * Customize defaults.
 *
 * Turns on the Layout, Footer credit, Featured image size, Colors and Typography
 * components that `backdrop-dev/customize` includes, and gives them Momentum's choices
 * and defaults.
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
		add_filter( 'backdrop/customize/colors',         '__return_true' );
		add_filter( 'backdrop/customize/typography',     '__return_true' );

		add_filter( 'backdrop/customize/layout_args',         [ $this, 'layout'        ] );
		add_filter( 'backdrop/customize/footer_credit_args',  [ $this, 'footerCredit'  ] );
		add_filter( 'backdrop/customize/featured_image_args', [ $this, 'featuredImage' ] );
		add_filter( 'backdrop/customize/typography_args',     [ $this, 'typography'    ] );
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

	/**
	 * Typography: Customize -> Theme: Content -> Typography.
	 *
	 * Momentum's own fonts are the system stacks in Chassis, and the package already offers
	 * those, plus "Theme default", which gives the design's font back. The fonts below come
	 * from `backdrop-dev/fonts`: the Typography component loads a font when it's picked (and
	 * all of them in the customizer preview), so none is enqueued by default. Each stack ends
	 * in a generic family, which is what shows if a font hasn't loaded yet.
	 *
	 * @since  0.0.1
	 * @access public
	 * @param  array  $args
	 * @return array
	 */
	public function typography( array $args ): array {

		$fonts = [
			"'Fira Sans', sans-serif"   => [ 'Fira Sans',   'fira-sans'   ],
			"'Lato', sans-serif"        => [ 'Lato',        'lato'        ],
			"'Open Sans', sans-serif"   => [ 'Open Sans',   'open-sans'   ],
			"'Ubuntu', sans-serif"      => [ 'Ubuntu',      'ubuntu'      ],
			"'Merriweather', serif"     => [ 'Merriweather', 'merriweather' ],
			"'Alegreya', serif"         => [ 'Alegreya',    'alegreya'    ],
		];

		// Empty: use the font that `chassis.json` and Chassis give.
		$args['fonts'] = [ '' => esc_html__( 'Theme default', 'momentum' ) ] + $args['fonts'];

		foreach ( $fonts as $stack => [ $label, $handle ] ) {
			$args['fonts'][ $stack ]   = $label;
			$args['handles'][ $stack ] = $handle;
		}

		return array_merge( $args, [
			'panel' => 'theme_content',
			'title' => esc_html__( 'Typography', 'momentum' ),
		] );
	}
}
