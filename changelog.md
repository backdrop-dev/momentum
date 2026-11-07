# Changelog

## [0.0.6] - 11.06.2026
### Added
- `npm run export` copies only what a site needs into `dist/{text-domain}/`, ready to zip, like Prismatic's export. It includes `chassis.json`, strips `.git` folders from `vendor`, and stops if the assets aren't built or `vendor` has the dev tools. `npm run build` builds and then exports.
- `npm run pot` builds one translation template, `public/lang/momentum.pot`, with [node-wp-i18n](https://github.com/cedaro/node-wp-i18n). It holds the theme's strings and the Backdrop framework's (`backdrop` text domain), which use the theme's translations. `composer rename` rebuilds it under the new text domain.
- `composer rename` renames the theme from `themerename.json`: the namespace, name, slug (text domain, hooks, handles, option and function names), author details and copyright year. `composer rename -- --dry-run` previews it. `themerename.json` gains the `Slug` and `Namespace` fields it needs.
- A "Starting points" section in the readme, listing what's switched on but left for you to finish (header image, meta icons) and what's empty on purpose (`chassis.json`, `screen.scss`, `app.js`).
- `.github/workflows/build.yml` checks every PHP file on PHP 7.4 and 8.3, and runs the asset build, on each push to `develop` and each pull request.
- The workflows use `actions/checkout@v7` and `actions/setup-node@v7`, which run on Node 24; GitHub is retiring the Node 20 that `@v4` used.

### Fixed
- The `.pot` file's header comment no longer shows node-wp-i18n's `<!= … =!>` markers, and its bug-report link uses the theme's URI from `style.css` instead of wordpress.org.
- A stray "Translators" comment in `app/Footer/Customize.php` was attached to the wrong string in the `.pot`.
- The coding-standards check skips `bin/` (the rename, `.pot` and export tools, which never run inside ClassicPress) and `dist/`. Since `composer rename` was added, it had failed on `bin/rename.php`. It also runs on pull requests now, not only after merging to `develop`.
- `style.css` declares `Domain Path: /public/lang`. The theme already loaded its translations from there, but Backdrop looked in the theme's root folder.

## [0.0.5] - 11.06.2026
### Changed
- Built on [Chassis](https://github.com/techkodeninja/chassis) (`techkodeninja/chassis`): the page skeleton, menu, posts, widgets, comments and pagination come from it, and the design is set in `chassis.json`. The templates use its classes (`.app-header`, `.app-nav`, `.app-content`, `.entry__*` and so on). `chassis.json` and `screen.scss` are empty, so a new theme starts from Chassis's defaults.
- Requires `backdrop-dev/framework` and `backdrop-dev/fonts` from `develop`, pinned to tested commits. `backdrop-dev/customize` (now part of the framework) and `backdrop-dev/mix` are no longer used; assets load with `Momentum\Vite\asset()`.
- vite 7.3.7 or later, with Rollup and Immutable kept at patched versions; Node 20.19 or 22.12 and later.

### Added
- The Layout setting changes the preview without reloading it.
- A no-results template, pagination, post navigation, footer widgets and a social menu with icons.
- If the `vendor` folder is missing, administrators see a notice and visitors get a 503 page instead of a fatal error.
- The theme's own stylesheet and script only load once something is in them. Both start empty, so a page loads just Chassis's files.

### Fixed
- Class names follow BEM throughout: the metadata separator is `.entry__sep` (was `.sep`), and the footer credit links are `.app-footer__link` (were `.home-link`, `.cp-link` and `.theme-link`).
- The layout picker's images were broken, and the customizer requested scripts that didn't exist.
- The settings page's Customize link and tab classes were empty, and an unknown tab caused a fatal error.
- The post and page templates didn't close `.entry-content`, and single posts referred to Generosity's code.
- Hooks named after Generosity now use `momentum/`.

## [0.0.4] - 09.15.2026
### Enhancement
- Minor changes to the Register/Boot due to Backdrop changed.

## [0.0.3] - 11.06.2025
### Enhancement
- Move theme to vite for assets

## [0.0.2] - 05.22.2025
### Enhancement
- Use wp_get_theme()->get( 'Name' ) to grab the theme's name

## [0.0.1] - 05.19.2025

### Added
- Everything's new!
