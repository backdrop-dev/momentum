/**
 * Laravel Mix configuration file.
 *
 * Laravel Mix is a layer constructed over ClassicPress, which simplifes the
 * process of creating a Webpack configuration file by elminiating much of its
 * complexity. This file is used to configure how assets are managed during the
 * build process.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @link      https://luthemes.com/portfolio/momentum
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

	// Import All Required Packages
const mix = require( 'laravel-mix' );

/*
* Sets the development path to assets. By default, this is the `/resources`
* folder in the theme.
*/
const devPath  = 'resources';

/*
 * Sets the path to the generated assets. By default, this is the `/public` folder in the theme.
 */
mix.setPublicPath( 'public' );

/*
 * Versioning and cache busting. Append a unique hash for production assets. If
 * you only want versioned assets in production, do a conditional check for
 * `mix.inProduction()`.
 *
 * @link https://laravel.com/docs/5.6/mix#versioning-and-cache-busting
 */
mix.version();

/*
 * Compile JavaScript.
 *
 * @link https://laravel.com/docs/6.x/mix#working-with-stylesheets
 */
mix.js( `${devPath}/js/app.js`, 'assets/js' )
   .js( `${devPath}/js/customize-controls.js`, 'assets/js' )
   .js( `${devPath}/js/customize-preview.js`, 'assets/js' );


/*
 * Compile CSS. Mix supports Sass, Less, Stylus, and plain CSS, and has functions
 * for each of them.
 *
 * @link https://laravel.com/docs/6.x/mix#working-with-stylesheets
 * @link https://laravel.com/docs/6.x/mix#sass
 */

// Compile SASS/CSS.
mix.sass( `${devPath}/scss/screen.scss`, 'assets/css' )
   .sass( `${devPath}/scss/admin.scss`, 'assets/css' )
   .sass( `${devPath}/scss/customize-controls.scss`, 'assets/css' )
   .sass( `${devPath}/scss/customize-preview.scss`, 'assets/css' );
