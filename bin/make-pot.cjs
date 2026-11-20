/**
 * Builds the theme's translation template with node-wp-i18n:
 *
 *     npm run pot
 *
 * One file, `{Domain Path}/{Text Domain}.pot` from the style.css header
 * (`public/lang/momentum.pot`), holds every string translators need: the
 * theme's own, in its text domain, and the Backdrop framework's, in the
 * `backdrop` text domain. Backdrop loads its strings from the theme's
 * translations (see `Backdrop\Lang\Language`), so one
 * `{text-domain}-{locale}.mo` translates both.
 *
 * node-wp-i18n collects every translation call it finds, whatever the text
 * domain, so the excludes decide what's in the file: the theme, plus
 * `vendor/backdrop-dev/*`, and nothing else from `vendor`.
 *
 * The patterns are regular expressions, matched against whole paths. They
 * can't contain `|`, which the matcher uses as its delimiter.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 */

const fs = require( 'fs' );
const path = require( 'path' );
const { makepot } = require( 'node-wp-i18n' );

// The theme's details, from the style.css header.
const css = fs.readFileSync( path.resolve( __dirname, '../style.css' ), 'utf8' );
const header = ( field ) => {
	const match = css.match( new RegExp( `^[\\s*#@]*${ field }:(.*)$`, 'mi' ) );

	return match ? match[ 1 ].trim() : '';
};

makepot( {
	type: 'wp-theme',
	mainFile: 'style.css',

	// Without these, node-wp-i18n leaves its `<!= … =!>` markers in the file
	// comment and points bug reports at wordpress.org.
	potComments: `Copyright (C) {year} ${ header( 'Author' ) }\nThis file is distributed under the ${ header( 'License' ) || 'same license as the theme' }.`,
	potHeaders: {
		'report-msgid-bugs-to': header( 'Theme URI' ),
	},

	// Keep the date unless a string changed, so rebuilding doesn't create a diff.
	updateTimestamp: false,

	exclude: [
		'node_modules/.*',

		// Everything in vendor except the Backdrop packages.
		'vendor/(?!backdrop-dev(?:/.*)?$).+',

		// Inside the Backdrop packages, only their own code.
		'vendor/backdrop-dev/[^/]+/tests/.*',
		'vendor/backdrop-dev/[^/]+/vendor/.*',
		'vendor/backdrop-dev/[^/]+/node_modules/.*',

		// The theme's tools and build output.
		'bin/.*',
		'public/assets/.*',

		// The exported copy (npm run export).
		'dist/.*',
	],
} ).then( ( wpPackage ) => {
	if ( wpPackage ) {
		console.log( `Wrote ${ wpPackage.getPotFilename() }` );
	}
} );
