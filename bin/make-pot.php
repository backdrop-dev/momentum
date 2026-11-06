<?php
/**
 * Builds the theme's translation template, `public/lang/{text-domain}.pot`.
 *
 *     composer make-pot
 *
 * One file holds every string translators need:
 *
 * - the theme's own strings, in its text domain (from `style.css`), and its
 *   name and description;
 * - the Backdrop framework's strings, in the `backdrop` text domain, from the
 *   `backdrop-dev/*` packages that `composer.json` requires.
 *
 * Backdrop loads its `backdrop` strings from the theme's translations (see
 * `Backdrop\Lang\Language`), so a single `{text-domain}-{locale}.mo` in
 * `public/lang` translates both.
 *
 * It reads PHP with PHP's own tokenizer, so it needs nothing beyond PHP: no
 * WP-CLI and no gettext.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 */

$root = dirname( __DIR__ );

/**
 * Prints a message and stops.
 */
function pot_fail( string $message ): void {
	fwrite( STDERR, "make-pot stopped: {$message}\n" );
	exit( 1 );
}

// The theme's details, from the style.css header.
$css = (string) @file_get_contents( $root . '/style.css' );

/**
 * Reads one field from the style.css header.
 */
function pot_header( string $css, string $field ): string {
	return preg_match( '/^[\s\*#@]*' . preg_quote( $field, '/' ) . ':(.*)$/mi', $css, $match ) ? trim( $match[1] ) : '';
}

$theme = [
	'name'        => pot_header( $css, 'Theme Name' ),
	'description' => pot_header( $css, 'Description' ),
	'uri'         => pot_header( $css, 'Theme URI' ),
	'author'      => pot_header( $css, 'Author' ),
	'version'     => pot_header( $css, 'Version' ),
	'domain'      => pot_header( $css, 'Text Domain' ),
	'path'        => trim( pot_header( $css, 'Domain Path' ) ?: '/public/lang', '/' ),
];

if ( '' === $theme['domain'] ) {
	pot_fail( 'style.css has no "Text Domain:" header.' );
}

// Which text domains to collect, and where to look: the theme, plus each
// Backdrop package that composer.json requires (not leftovers in vendor).
$domains  = [ $theme['domain'], 'backdrop' ];
$composer = json_decode( (string) @file_get_contents( $root . '/composer.json' ), true );
$sources  = [
	[ 'path' => $root, 'skip' => [ 'vendor', 'node_modules', 'public/assets', '.git', 'bin' ] ],
];

foreach ( array_keys( $composer['require'] ?? [] ) as $package ) {
	if ( 0 !== strpos( $package, 'backdrop-dev/' ) ) {
		continue;
	}

	if ( ! is_dir( "{$root}/vendor/{$package}" ) ) {
		pot_fail( "{$package} isn't installed. Run `composer install` first." );
	}

	$sources[] = [ 'path' => "{$root}/vendor/{$package}", 'skip' => [ 'vendor', 'node_modules', 'tests', '.git' ] ];
}

/*
 * Translation functions, and which argument holds what. Positions start at 0;
 * `null` means the function doesn't take that argument.
 */
$functions = [
	'__'           => [ 'single' => 0, 'domain' => 1 ],
	'_e'           => [ 'single' => 0, 'domain' => 1 ],
	'esc_html__'   => [ 'single' => 0, 'domain' => 1 ],
	'esc_html_e'   => [ 'single' => 0, 'domain' => 1 ],
	'esc_attr__'   => [ 'single' => 0, 'domain' => 1 ],
	'esc_attr_e'   => [ 'single' => 0, 'domain' => 1 ],
	'_x'           => [ 'single' => 0, 'context' => 1, 'domain' => 2 ],
	'_ex'          => [ 'single' => 0, 'context' => 1, 'domain' => 2 ],
	'esc_html_x'   => [ 'single' => 0, 'context' => 1, 'domain' => 2 ],
	'esc_attr_x'   => [ 'single' => 0, 'context' => 1, 'domain' => 2 ],
	'_n'           => [ 'single' => 0, 'plural' => 1, 'domain' => 3 ],
	'_nx'          => [ 'single' => 0, 'plural' => 1, 'context' => 3, 'domain' => 4 ],
	'_n_noop'      => [ 'single' => 0, 'plural' => 1, 'domain' => 2 ],
	'_nx_noop'     => [ 'single' => 0, 'plural' => 1, 'context' => 2, 'domain' => 3 ],
];

/**
 * Turns a PHP string literal token into its value.
 */
function pot_unquote( string $literal ): string {
	$quote = $literal[0];
	$body  = substr( $literal, 1, -1 );

	return "'" === $quote ? strtr( $body, [ "\\'" => "'", '\\\\' => '\\' ] ) : stripcslashes( $body );
}

/**
 * Returns an argument's string value if it's only string literals (joined
 * with `.`), or null if it's anything else, like a variable.
 */
function pot_literal( array $tokens ): ?string {
	$value = '';
	$found = false;

	foreach ( $tokens as $token ) {
		if ( is_array( $token ) && T_CONSTANT_ENCAPSED_STRING === $token[0] ) {
			$value .= pot_unquote( $token[1] );
			$found  = true;
		} elseif ( is_array( $token ) && in_array( $token[0], [ T_WHITESPACE, T_COMMENT ], true ) ) {
			continue;
		} elseif ( '.' !== $token ) {
			return null;
		}
	}

	return $found ? $value : null;
}

/**
 * Finds the translatable strings in one PHP file.
 *
 * @return array[] Each: single, plural, context, domain, line, comment.
 */
function pot_scan( string $code, array $functions ): array {
	$tokens  = token_get_all( $code );
	$found   = [];
	$comment = null;
	$count   = count( $tokens );

	for ( $i = 0; $i < $count; $i++ ) {
		$token = $tokens[ $i ];

		// Remember the last "translators:" comment, to attach to the next string.
		if ( is_array( $token ) && in_array( $token[0], [ T_COMMENT, T_DOC_COMMENT ], true ) ) {
			if ( preg_match( '/translators:/i', $token[1] ) ) {
				$text    = preg_replace( [ '#^\s*(//|/\*+|\#)\s*#', '#\s*\*+/\s*$#', '#^\s*\*\s?#m' ], '', $token[1] );
				$comment = [ 'text' => trim( preg_replace( '/\s+/', ' ', $text ) ), 'line' => $token[2] + substr_count( $token[1], "\n" ) ];
			}
			continue;
		}

		$names = [ T_STRING ];

		if ( defined( 'T_NAME_FULLY_QUALIFIED' ) ) {
			$names[] = T_NAME_FULLY_QUALIFIED;
		}

		if ( ! is_array( $token ) || ! in_array( $token[0], $names, true ) ) {
			continue;
		}

		$name = ltrim( $token[1], '\\' );

		if ( ! isset( $functions[ $name ] ) ) {
			continue;
		}

		// Skip methods (`->__()`, `::__()`) and definitions (`function __()`).
		for ( $p = $i - 1; $p >= 0 && is_array( $tokens[ $p ] ) && T_WHITESPACE === $tokens[ $p ][0]; $p-- );

		if ( $p >= 0 && is_array( $tokens[ $p ] ) && in_array( $tokens[ $p ][0], [ T_OBJECT_OPERATOR, T_DOUBLE_COLON, T_FUNCTION, T_NEW ], true ) ) {
			continue;
		}

		if ( defined( 'T_NULLSAFE_OBJECT_OPERATOR' ) && $p >= 0 && is_array( $tokens[ $p ] ) && T_NULLSAFE_OBJECT_OPERATOR === $tokens[ $p ][0] ) {
			continue;
		}

		// Find the opening parenthesis.
		for ( $j = $i + 1; $j < $count && is_array( $tokens[ $j ] ) && T_WHITESPACE === $tokens[ $j ][0]; $j++ );

		if ( $j >= $count || '(' !== $tokens[ $j ] ) {
			continue;
		}

		// Split the arguments at top-level commas.
		$args  = [ [] ];
		$depth = 0;

		for ( $k = $j + 1; $k < $count; $k++ ) {
			$t = $tokens[ $k ];

			if ( in_array( $t, [ '(', '[', '{' ], true ) || ( is_array( $t ) && in_array( $t[0], [ T_CURLY_OPEN, T_DOLLAR_OPEN_CURLY_BRACES ], true ) ) ) {
				$depth++;
			} elseif ( in_array( $t, [ ')', ']', '}' ], true ) ) {
				if ( 0 === $depth && ')' === $t ) {
					break;
				}
				$depth--;
			} elseif ( ',' === $t && 0 === $depth ) {
				$args[] = [];
				continue;
			}

			$args[ count( $args ) - 1 ][] = $t;
		}

		$spec  = $functions[ $name ];
		$value = function ( string $part ) use ( $spec, $args ) {
			return isset( $spec[ $part ], $args[ $spec[ $part ] ] ) ? pot_literal( $args[ $spec[ $part ] ] ) : null;
		};

		$single = $value( 'single' );

		if ( null === $single || '' === $single ) {
			continue;
		}

		$found[] = [
			'single'  => $single,
			'plural'  => $value( 'plural' ),
			'context' => $value( 'context' ),
			'domain'  => $value( 'domain' ),
			'line'    => $token[2],
			'comment' => $comment && $comment['line'] >= $token[2] - 2 ? $comment['text'] : null,
		];

		$comment = null;
	}

	return $found;
}

// Collect the strings, keyed by context and text so each appears once.
$entries = [];

$add = function ( string $single, ?string $plural, ?string $context, string $reference, ?string $comment ) use ( &$entries ) {
	$key = ( $context ?? '' ) . "\x04" . $single;

	if ( ! isset( $entries[ $key ] ) ) {
		$entries[ $key ] = [ 'single' => $single, 'plural' => $plural, 'context' => $context, 'references' => [], 'comments' => [] ];
	}

	$entries[ $key ]['references'][] = $reference;

	if ( $comment && ! in_array( $comment, $entries[ $key ]['comments'], true ) ) {
		$entries[ $key ]['comments'][] = $comment;
	}

	if ( $plural && ! $entries[ $key ]['plural'] ) {
		$entries[ $key ]['plural'] = $plural;
	}
};

// The theme's name and description, as ClassicPress shows them translated.
if ( $theme['name'] ) {
	$add( $theme['name'], null, null, 'style.css', 'Theme Name of the theme' );
}

if ( $theme['description'] ) {
	$add( $theme['description'], null, null, 'style.css', 'Description of the theme' );
}

$per_domain = array_fill_keys( $domains, 0 );
$files      = [];

foreach ( $sources as $source ) {
	if ( ! is_dir( $source['path'] ) ) {
		continue;
	}

	$iterator = new RecursiveIteratorIterator(
		new RecursiveCallbackFilterIterator(
			new RecursiveDirectoryIterator( $source['path'], FilesystemIterator::SKIP_DOTS ),
			function ( SplFileInfo $file ) use ( $source ) {
				$relative = ltrim( substr( $file->getPathname(), strlen( $source['path'] ) ), '/' );

				return ! ( $file->isDir() && ( in_array( $relative, $source['skip'], true ) || in_array( $file->getFilename(), [ 'node_modules', 'tests', '.git' ], true ) ) );
			}
		)
	);

	foreach ( $iterator as $file ) {
		if ( 'php' === $file->getExtension() ) {
			$files[] = $file->getPathname();
		}
	}
}

sort( $files );

foreach ( $files as $path ) {
	$relative = ltrim( substr( $path, strlen( $root ) ), '/' );

	foreach ( pot_scan( (string) file_get_contents( $path ), $functions ) as $string ) {
		if ( ! in_array( $string['domain'], $domains, true ) ) {
			continue;
		}

		$per_domain[ $string['domain'] ]++;
		$add( $string['single'], $string['plural'], $string['context'], "{$relative}:{$string['line']}", $string['comment'] );
	}
}

/**
 * Formats a string for a .pot file, splitting it over lines at newlines.
 */
function pot_string( string $keyword, string $value ): string {
	$escaped = addcslashes( $value, "\\\"\t" );
	$escaped = str_replace( [ "\r\n", "\n" ], '\n', $escaped );

	if ( false === strpos( $value, "\n" ) ) {
		return "{$keyword} \"{$escaped}\"\n";
	}

	$lines = preg_split( '/(?<=\\\\n)/', $escaped, -1, PREG_SPLIT_NO_EMPTY );

	return "{$keyword} \"\"\n" . implode( '', array_map( function ( $line ) {
		return "\"{$line}\"\n";
	}, $lines ) );
}

$year = gmdate( 'Y' );
$pot  = "# Copyright (C) {$year} {$theme['author']}\n";
$pot .= "# This file is distributed under the same license as the {$theme['name']} theme.\n";
$pot .= "# It also holds the Backdrop framework's strings (text domain \"backdrop\"), which use this theme's translations.\n";
$pot .= "msgid \"\"\n";
$pot .= "msgstr \"\"\n";

foreach ( [
	'Project-Id-Version'        => trim( "{$theme['name']} {$theme['version']}" ),
	'Report-Msgid-Bugs-To'      => $theme['uri'],
	'POT-Creation-Date'         => gmdate( 'Y-m-d H:i+0000' ),
	'PO-Revision-Date'          => 'YEAR-MO-DA HO:MI+ZONE',
	'Last-Translator'           => 'FULL NAME <EMAIL@ADDRESS>',
	'Language-Team'             => 'LANGUAGE <LL@li.org>',
	'Language'                  => '',
	'MIME-Version'              => '1.0',
	'Content-Type'              => 'text/plain; charset=UTF-8',
	'Content-Transfer-Encoding' => '8bit',
	'Plural-Forms'              => 'nplurals=INTEGER; plural=EXPRESSION;',
	'X-Domain'                  => $theme['domain'],
] as $header => $value ) {
	$pot .= '"' . addcslashes( "{$header}: {$value}", '"\\' ) . "\\n\"\n";
}

foreach ( $entries as $entry ) {
	$pot .= "\n";

	foreach ( $entry['comments'] as $comment ) {
		$pot .= "#. {$comment}\n";
	}

	$pot .= '#: ' . implode( "\n#: ", $entry['references'] ) . "\n";

	if ( preg_match( '/%(\d+\$)?[sdfu]/', $entry['single'] . $entry['plural'] ) ) {
		$pot .= "#, php-format\n";
	}

	if ( null !== $entry['context'] ) {
		$pot .= pot_string( 'msgctxt', $entry['context'] );
	}

	$pot .= pot_string( 'msgid', $entry['single'] );

	if ( $entry['plural'] ) {
		$pot .= pot_string( 'msgid_plural', $entry['plural'] );
		$pot .= "msgstr[0] \"\"\nmsgstr[1] \"\"\n";
	} else {
		$pot .= "msgstr \"\"\n";
	}
}

$dir  = $root . '/' . $theme['path'];
$file = "{$dir}/{$theme['domain']}.pot";

if ( ! is_dir( $dir ) && ! mkdir( $dir, 0755, true ) ) {
	pot_fail( "couldn't create {$theme['path']}." );
}

file_put_contents( $file, $pot );

printf(
	"Wrote %s/%s.pot: %d strings (%d from the theme, %d from Backdrop; repeats are merged).\n",
	$theme['path'],
	$theme['domain'],
	count( $entries ),
	$per_domain[ $theme['domain'] ],
	$per_domain['backdrop']
);
