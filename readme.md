# Momentum

Momentum is a starter theme for ClassicPress.

The theme's primary goal is to offer a modern development experience for ClassicPress theme authors while sticking as close to possible to ClassicPress standards as we can.  Sometimes those things don't always mesh well.  This theme aims to balance that.

## Requirements

There's a few requirements in order to develop a new theme or contribute back to the project:

* PHP 7.4+ (preferably 8+).
* [Git](https://git-scm.com/) for version control.
* [Composer](https://getcomposer.org/) for managing PHP dependencies.
* [Node](https://nodejs.org) 20.19 or later, or 22.12 or later.
* [NPM](https://www.npmjs.com/) or [Yarn](https://yarnpkg.com/en/) (your choice) for managing JS dependencies.

You should feel reasonably comfortable using the command line. The theme tries to keep this as simple as possible, but some command line knowledge is necessary in modern development.

## Building

<pre>
composer install --no-dev
npm ci
npm run build
</pre>

Run `composer install` first: the Sass build loads Chassis's tools from `vendor/`. `npm run watch` rebuilds the assets as you work. Assets are built by [Vite](https://vite.dev) into `public/assets`, and the theme loads them by their source path with `Momentum\Vite\asset()`, for example `asset( 'resources/scss/screen.scss' )`.

## Chassis

Momentum is built on [Chassis](https://github.com/techkodeninja/chassis), the shared structure and UI building blocks used by both ClassicPress themes and Novaris sites. `app/framework.php` registers its service provider, which loads Chassis's CSS, its ClassicPress add-on, the menu script and the theme's `chassis.json`.

What comes from where:

* **Chassis:** the page skeleton (`.app`, `.app-header`, `.app-nav`, `.app-content`, `.app-main`, `.app-sidebar`, `.app-footer`), the mobile Menu button and dropdowns, posts (`.entry__*`), widgets, comments, pagination, buttons, cards and the grid.
* **`chassis.json`:** the design: colors, fonts, spacing, widths and where the Menu button sits. It's empty, so Momentum uses Chassis's defaults; add only what you change, then refresh. There's nothing to build. See the [settings](https://github.com/techkodeninja/chassis#set-the-design-with-chassisjson).
* **`resources/scss/`:** Momentum's own styles, for anything Chassis doesn't cover. `screen.scss` is empty, since Momentum is a starter theme. Load Chassis's tools in a partial with `@use 'techkodeninja/chassis/scss/02.tools' as ui;` to use its breakpoints (`ui.up( medium )`) and values (`ui.space( m )`, `ui.color( content-muted )`).
* **Customize → Theme: Content → Layout:** left sidebar, right sidebar or no sidebar, which sets Chassis's `app-content--sidebar-left` or `--sidebar-right`.

## Copyright and License

Momentum is licensed under the [GNU GPL](https://www.gnu.org/licenses/gpl-2.0.html), version 2 or later.

2025 &copy; Benjamin Lu.
