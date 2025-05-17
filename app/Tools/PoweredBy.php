<?php
/**
 * Powered By Text Class.
 *
 * A simple class for randomly displaying a "powered by..." line of text in the
 * theme footer.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

namespace Momentum\Tools;

/**
 * Powered by class.
 *
 * @since  0.0.1
 * @access public
 */
class PoweredBy {

	/**
	 * Returns an array of all the powered by quotes.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	public static function all() {

		return apply_filters( 'momentum/poweredby/collection', [
			esc_html__( 'Powered by heart and soul.', 'momentum' ),
			esc_html__( 'Powered by crazy ideas and passion.', 'momentum' ),
			esc_html__( 'Powered by the thing that holds all things together in the universe.', 'momentum' ),
			esc_html__( 'Powered by love.', 'momentum' ),
			esc_html__( 'Powered by the vast and endless void.', 'momentum' ),
			esc_html__( 'Powered by the code of a maniac.', 'momentum' ),
			esc_html__( 'Powered by peace and understanding.', 'momentum' ),
			esc_html__( 'Powered by coffee.', 'momentum' ),
			esc_html__( 'Powered by sleepness nights.', 'momentum' ),
			esc_html__( 'Powered by the love of all things.', 'momentum' ),
			esc_html__( 'Powered by something greater than myself.', 'momentum' ),
			esc_html__( 'Powered by whispers from the future.', 'momentum' ),
			esc_html__( 'Powered by the fusion of technology and dreams.', 'momentum' ),
			esc_html__( 'Powered by the strength found in kindness.', 'momentum' ),
			esc_html__( 'Powered by the melodies of the unseen world.', 'momentum' ),
			esc_html__( 'Powered by the courage of the unheard voices.', 'momentum' ),
			esc_html__( 'Powered by the beauty of the human spirit.', 'momentum' ),
			esc_html__( 'Powered by the quest for eternal wisdom.', 'momentum' ),
			esc_html__( 'Powered by the energy of uncharted galaxies.', 'momentum' ),
			esc_html__( 'Powered by the magic hidden in plain sight.', 'momentum' ),
			esc_html__( 'Powered by the legacy of the ancients.', 'momentum' ),
			esc_html__( 'Powered by the dance between light and darkness.', 'momentum' ),
			esc_html__( 'Powered by the touch of the morning sun.', 'momentum' ),
			esc_html__( 'Powered by the secrets of the deep ocean.', 'momentum' ),
			esc_html__( 'Powered by the echoes of laughter and joy.', 'momentum' ),
			esc_html__( 'Powered by the relentless pursuit of truth.', 'momentum' ),
		] );
	}

	/**
	 * Displays a random powered by quote.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public static function display() {

		echo esc_html( static::render() );
	}

	/**
	 * Returns a random powered by quote.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public static function render() {

		$collection = static::all();

		return $collection[ array_rand( $collection, 1 ) ];
	}
}
