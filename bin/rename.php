<?php
/**
 * Renames the theme, using `themerename.json`.
 *
 *     composer rename                 Rename the theme.
 *     composer rename -- --dry-run    Show what would change, without writing anything.
 *
 * `themerename.json` has a `from` (the current theme) and a `to` (your theme).
 * It rewrites, in this order:
 *
 * - Author details and URLs: `Description`, `Uri`, `AuthorUri`, `AuthorEmail`, `Author`.
 * - The PHP namespace, `Namespace`: `Momentum\…` and `namespace Momentum;`.
 * - The theme name, `Name`: "Momentum" in headers, docblocks and text.
 * - The slug, `Slug`: the text domain, hooks (`momentum/…`), handles (`momentum-…`),
 *   and package names. Before an underscore, as in function and option names
 *   (`momentum_…`), the slug is written with underscores (`my_theme_…`).
 * - The copyright year, `Year`, on copyright lines only.
 *
 * It skips `vendor`, `node_modules`, built assets, images, `changelog.md`
 * (the starter's history), translations and this script, then rebuilds the
 * `.pot` under the new text domain. When it's done, `from` is set to
 * `to`, so the file always describes the current theme, and Composer's
 * autoloader is rebuilt for the new namespace.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 */

$root    = dirname( __DIR__ );
$dry_run = in_array( '--dry-run', $argv, true );
$config  = $root . '/themerename.json';

/**
 * Prints a message and stops.
 */
function rename_fail( string $message ): void {
	fwrite( STDERR, "Rename stopped: {$message}\n" );
	exit( 1 );
}

$data = json_decode( (string) @file_get_contents( $config ), true );

if ( ! is_array( $data ) || ! isset( $data['from'], $data['to'] ) || ! is_array( $data['from'] ) || ! is_array( $data['to'] ) ) {
	rename_fail( 'themerename.json needs a "from" and a "to".' );
}

$from = $data['from'];
$to   = $data['to'];

// The three fields every rename needs, and what they may contain.
$required = [
	'Name'      => [ '/^\S.*\S$|^\S$/', 'any name, such as "My Theme"' ],
	'Slug'      => [ '/^[a-z][a-z0-9]*(-[a-z0-9]+)*$/', 'lowercase letters, numbers and dashes, such as "my-theme"' ],
	'Namespace' => [ '/^[A-Z][A-Za-z0-9]*$/', 'a PHP namespace such as "MyTheme"' ],
];

foreach ( $required as $field => [ $pattern, $hint ] ) {
	foreach ( [ 'from' => $from, 'to' => $to ] as $side => $values ) {
		if ( ! isset( $values[ $field ] ) || ! is_string( $values[ $field ] ) || ! preg_match( $pattern, $values[ $field ] ) ) {
			rename_fail( "\"{$side}.{$field}\" should be {$hint}." );
		}
	}
}

if ( $from === $to ) {
	echo "Nothing to rename: \"from\" and \"to\" are the same.\n";
	exit( 0 );
}

/*
 * The replacements, in order. Each is [ pattern, replacement ], applied with
 * preg_replace. Longer, more specific values go first so a shorter one
 * (like the slug) doesn't break them.
 */
$replacements = [];

foreach ( [ 'Description', 'Uri', 'AuthorUri', 'AuthorEmail', 'Author' ] as $field ) {
	if ( isset( $from[ $field ], $to[ $field ] ) && '' !== $from[ $field ] && $from[ $field ] !== $to[ $field ] ) {
		$replacements[ $field ] = [ '/' . preg_quote( $from[ $field ], '/' ) . '/', $to[ $field ] ];
	}
}

$ns = preg_quote( $from['Namespace'], '/' );

// `Momentum\Foo`, `\Momentum\Foo`, `"Momentum\\"` in JSON, and `namespace Momentum;`.
$replacements['Namespace'] = [ '/(?<![A-Za-z0-9_])' . $ns . '(?=\\\\|;|\s*\{)/', $to['Namespace'] ];
$replacements['Name']      = [ '/(?<![A-Za-z0-9_])' . preg_quote( $from['Name'], '/' ) . '(?![A-Za-z0-9_])/', $to['Name'] ];

$slug = preg_quote( $from['Slug'], '/' );

// Before an underscore, the slug may already be written with underscores (`my_theme_…`).
$slug_underscored = preg_quote( str_replace( '-', '_', $from['Slug'] ), '/' );

$replacements['Slug before _'] = [ '/(?<![A-Za-z0-9_])(?:' . $slug . '|' . $slug_underscored . ')(?=_)/', str_replace( '-', '_', $to['Slug'] ) ];
$replacements['Slug']          = [ '/(?<![A-Za-z0-9])' . $slug . '(?![a-z0-9])/', $to['Slug'] ];

if ( isset( $from['Year'], $to['Year'] ) && $from['Year'] !== $to['Year'] ) {
	$year = preg_quote( (string) $from['Year'], '/' );

	// "© 2025", "Copyright 2025", "@copyright 2025", and "2025 ©".
	$replacements['Year']       = [ '/((?:@copyright|Copyright|&copy;|©)\s+)' . $year . '\b/i', '${1}' . $to['Year'] ];
	$replacements['Year before'] = [ '/\b' . $year . '(\s*(?:&copy;|©))/', $to['Year'] . '${1}' ];
}

// Which files to rewrite.
$skip_dirs  = [ '.git', 'vendor', 'node_modules', 'public/assets', 'public/lang' ];
$skip_files = [ 'changelog.md', 'themerename.json', 'bin/rename.php', 'package-lock.json' ];
$text       = [ 'php', 'js', 'mjs', 'scss', 'css', 'json', 'md', 'txt', 'xml', 'dist', 'yml', 'yaml', 'html', 'pot', 'editorconfig' ];

$files = new RecursiveIteratorIterator(
	new RecursiveCallbackFilterIterator(
		new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ),
		function ( SplFileInfo $file ) use ( $root, $skip_dirs ) {
			$relative = ltrim( substr( $file->getPathname(), strlen( $root ) ), '/' );

			return ! ( $file->isDir() && in_array( $relative, $skip_dirs, true ) );
		}
	)
);

$changed = 0;
$total   = 0;

foreach ( $files as $file ) {
	$relative  = ltrim( substr( $file->getPathname(), strlen( $root ) ), '/' );
	$extension = strtolower( $file->getExtension() ?: ltrim( $file->getFilename(), '.' ) );

	if ( ! $file->isFile() || in_array( $relative, $skip_files, true ) || ! in_array( $extension, $text, true ) ) {
		continue;
	}

	$before = (string) file_get_contents( $file->getPathname() );
	$after  = $before;
	$count  = 0;

	foreach ( $replacements as [ $pattern, $replacement ] ) {
		$after  = preg_replace( $pattern, $replacement, $after, -1, $n );
		$count += $n;
	}

	if ( $after === $before ) {
		continue;
	}

	$changed++;
	$total += $count;

	printf( "%s %s (%d)\n", $dry_run ? 'would change' : 'changed', $relative, $count );

	if ( ! $dry_run ) {
		file_put_contents( $file->getPathname(), $after );
	}
}

printf(
	"\n%s %d replacements in %d files: %s → %s (%s, %s).\n",
	$dry_run ? 'Would make' : 'Made',
	$total,
	$changed,
	$from['Name'],
	$to['Name'],
	$to['Slug'],
	$to['Namespace']
);

if ( $dry_run ) {
	echo "Nothing was written. Run `composer rename` to apply it.\n";
	exit( 0 );
}

// Record the new theme as the current one, so the next rename starts from it.
$data['from'] = $to;
file_put_contents( $config, json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n" );

// Rebuild the autoloader for the new namespace.
$composer = getenv( 'COMPOSER_BINARY' );
$command  = $composer ? escapeshellarg( PHP_BINARY ) . ' ' . escapeshellarg( $composer ) : 'composer';
passthru( $command . ' dump-autoload --working-dir=' . escapeshellarg( $root ), $status );

if ( 0 !== $status ) {
	echo "Run `composer dump-autoload` to finish: the autoloader still uses the old namespace.\n";
}

// Rebuild the translation template under the new text domain.
$old_pot = "{$root}/public/lang/{$from['Slug']}.pot";

if ( is_file( $old_pot ) ) {
	unlink( $old_pot );

	if ( is_dir( "{$root}/node_modules/node-wp-i18n" ) ) {
		passthru( 'npm run pot --prefix ' . escapeshellarg( $root ) );
	} else {
		echo "Run `npm install` and `npm run pot` to rebuild the translation template as public/lang/{$to['Slug']}.pot.\n";
	}
}

echo "Done. Check the changes with `git diff`, then search for anything the rename couldn't know about.\n";
