# Changelog

## [Unreleased]
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
