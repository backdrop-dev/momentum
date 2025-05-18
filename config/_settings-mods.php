<?php
/**
 * Theme mods settings Config.
 *
 * Defines the default theme mods for the theme. Child themes can overwrite this
 * with a `config/settings-mod.php` file for changing the defaults.
 *
 * Configs are loaded early in the load process. If a default value requires PHP
 * code to execute, use a closure. It will be invoked at an appropriate time when
 * all functions/variables are set up and available for use.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      https://luthemes.com/portfolio/momentum
 */

use function Backdrop\is_classicpress;

return [

	# ------------------------a----------------------------------------------
	# Theme: Global
	# ----------------------------------------------------------------------
	#
	# Handles the global theme mods.

	// Branding separator (see `config/character-entities.php` for options).
	'branding_sep' => '&#183;',

	# ----------------------------------------------------------------------
	# Theme: Header
	# ----------------------------------------------------------------------
	#
	# Handles the header theme mods.

	# ----------------------------------------------------------------------
	# Theme: Content
	# ----------------------------------------------------------------------
	#
	# Handles the content theme mods.
	'theme_content_layout' => 'left-sidebar',

	'featured_image_size' => 'momentum-landscape-medium',

	# ----------------------------------------------------------------------
	# Theme: Footer
	# ----------------------------------------------------------------------
	#
	# Handles the footer theme mods.
	'theme_footer_powered_by' => false,

	'theme_footer_custom_credit' => function() {
		$year = gmdate( 'Y' ); // Get the current year
		$copyright = sprintf( __( "&#169; %1\$s. %2\$s.", 'momentum' ), $year, Backdrop\Site\render_home_link() );

		if ( is_classicpress() ) {
			$footer_text = sprintf( __( "Powered by %1\$s and %2\$s.", 'momentum' ), Backdrop\Site\render_cp_link(), Backdrop\Site\render_theme_link() );
		} else {
			$footer_text = sprintf( __( "Powered by %1\$s and %2\$s.", 'momentum' ), Backdrop\Site\render_wp_link(), Backdrop\Site\render_theme_link() );
		}

		return $copyright . ' <br /> ' . $footer_text;
	},

];
