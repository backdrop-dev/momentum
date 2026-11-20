/**
 * Exports the theme for a site: copies only what ClassicPress needs into
 * `dist/{text-domain}/`, ready to zip and upload.
 *
 *     npm run build     builds the assets, then exports
 *     npm run export    exports only
 *
 * Install the PHP dependencies without the dev tools first, so they aren't
 * shipped:
 *
 *     composer install --no-dev
 *
 * The folder is named after the `Text Domain` in style.css, so it follows
 * `composer rename`.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 */

const fs = require( 'fs' );
const fsp = fs.promises;
const path = require( 'path' );

const root = path.resolve( __dirname, '..' );

// Files at the theme's root that a site needs.
const files = [
	'chassis.json', // Chassis reads the design from it.
	'functions.php',
	'index.php',
	'readme.txt',
	'screenshot.png',
	'style.css',
];

// Folders a site needs. `public` holds the built assets, images, views and translations.
const folders = [
	'app',
	'config',
	'public',
	'vendor',
];

// Removed from the copy: Composer's tools, and git checkouts of packages
// installed from a branch (Backdrop is pinned to commits on `develop`).
const removeAfterCopy = [
	'vendor/bin',
	'vendor/composer/installers',
];

/**
 * Reads a field from the style.css header.
 */
function header( css, field ) {
	const match = css.match( new RegExp( `^[\\s*#@]*${ field }:(.*)$`, 'mi' ) );

	return match ? match[ 1 ].trim() : '';
}

/**
 * Whether a path exists.
 */
async function exists( p ) {
	try {
		await fsp.access( p );
		return true;
	} catch {
		return false;
	}
}

/**
 * Removes every folder with this name under a folder.
 */
async function removeNamed( dir, name ) {
	let removed = 0;

	for ( const entry of await fsp.readdir( dir, { withFileTypes: true } ) ) {
		if ( ! entry.isDirectory() ) {
			continue;
		}

		const full = path.join( dir, entry.name );

		if ( entry.name === name ) {
			await fsp.rm( full, { recursive: true, force: true } );
			removed++;
		} else {
			removed += await removeNamed( full, name );
		}
	}

	return removed;
}

/**
 * Stops with a message.
 */
function fail( message ) {
	console.error( `Export stopped: ${ message }` );
	process.exit( 1 );
}

async function main() {
	const css = await fsp.readFile( path.join( root, 'style.css' ), 'utf8' );
	const slug = header( css, 'Text Domain' );

	if ( ! slug ) {
		fail( 'style.css has no "Text Domain:" header.' );
	}

	// The site loads the built assets through the manifest.
	if ( ! ( await exists( path.join( root, 'public/assets/manifest.json' ) ) ) ) {
		fail( 'the assets aren\'t built. Run `npm run build`.' );
	}

	if ( ! ( await exists( path.join( root, 'vendor/autoload.php' ) ) ) ) {
		fail( 'vendor is missing. Run `composer install --no-dev`.' );
	}

	// Don't ship the coding-standards tools and other dev packages.
	const installed = JSON.parse( await fsp.readFile( path.join( root, 'vendor/composer/installed.json' ), 'utf8' ) );

	if ( installed.dev ) {
		fail( 'vendor includes the dev tools. Run `composer install --no-dev`, then export again.' );
	}

	const target = path.join( root, 'dist', slug );

	// Start clean.
	await fsp.rm( target, { recursive: true, force: true } );

	for ( const file of files ) {
		const src = path.join( root, file );

		if ( await exists( src ) ) {
			await fsp.mkdir( target, { recursive: true } );
			await fsp.copyFile( src, path.join( target, file ) );
		}
	}

	for ( const folder of folders ) {
		const src = path.join( root, folder );

		if ( await exists( src ) ) {
			await fsp.cp( src, path.join( target, folder ), { recursive: true, force: true } );
		}
	}

	for ( const p of removeAfterCopy ) {
		await fsp.rm( path.join( target, p ), { recursive: true, force: true } );
	}

	const gitFolders = await removeNamed( path.join( target, 'vendor' ), '.git' );

	console.log( `Exported ${ path.relative( root, target ) }${ gitFolders ? ` (removed ${ gitFolders } .git folders from vendor)` : '' }.` );
	console.log( `Zip that folder to upload it in Appearance → Themes → Add New.` );
}

main().catch( ( error ) => {
	console.error( 'Export failed:', error );
	process.exit( 1 );
} );
