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

## Exporting

To upload the theme to a site, export a copy with only what ClassicPress needs:

<pre>
composer install --no-dev
npm run build
</pre>

`npm run build` builds the assets, then runs `npm run export`, which copies the theme into `dist/momentum/`. Zip that folder and upload it in *Appearance → Themes → Add New*.

The copy has `style.css`, `functions.php`, `index.php`, `chassis.json`, `readme.txt`, `screenshot.png` if you add one, and the `app`, `config`, `public` and `vendor` folders. It leaves out the sources (`resources`, `bin`), the dev config and `node_modules`. From `vendor`, it removes Composer's tools and any `.git` folders.

The export stops if the assets aren't built, or if `vendor` still has the dev tools from a plain `composer install`. The folder is named after the text domain, so it follows `composer rename`. `bin/export-theme.cjs` lists what's copied.

## Chassis

Momentum is built on [Chassis](https://github.com/techkodeninja/chassis), the shared structure and UI building blocks used by both ClassicPress themes and Novaris sites. `app/framework.php` registers its service provider, which loads Chassis's CSS, its ClassicPress add-on, the menu script and the theme's `chassis.json`.

What comes from where:

* **Chassis:** the page skeleton (`.app`, `.app-header`, `.app-nav`, `.app-content`, `.app-main`, `.app-sidebar`, `.app-footer`), the mobile Menu button and dropdowns, posts (`.entry__*`), widgets, comments, pagination, buttons, cards and the grid.
* **`chassis.json`:** the design: colors, fonts, spacing, widths and where the Menu button sits. It's empty, so Momentum uses Chassis's defaults; add only what you change, then refresh. There's nothing to build. See the [settings](https://github.com/techkodeninja/chassis#set-the-design-with-chassisjson).
* **`resources/scss/`:** Momentum's own styles, for anything Chassis doesn't cover. `screen.scss` is empty, since Momentum is a starter theme. Load Chassis's tools in a partial with `@use 'techkodeninja/chassis/scss/02.tools' as ui;` to use its breakpoints (`ui.up( medium )`) and values (`ui.space( m )`, `ui.color( content-muted )`).
* **Customize → Theme: Content → Layout:** left sidebar, right sidebar or no sidebar, which sets Chassis's `app-content--sidebar-left` or `--sidebar-right`.

## Renaming

Make Momentum your own theme in one step. In `themerename.json`, fill in `to` with your theme's details:

```json
"to": {
	"Name": "My Theme",
	"Slug": "my-theme",
	"Namespace": "MyTheme",
	"Description": "My Theme is…",
	"Uri": "https://example.com/my-theme",
	"Author": "Your Name",
	"AuthorEmail": "you@example.com",
	"AuthorUri": "https://example.com",
	"Year": "2026"
}
```

Then preview and run it:

<pre>
composer rename -- --dry-run
composer rename
</pre>

It rewrites:
* the PHP namespace (`Momentum\…` becomes `MyTheme\…`),
* the theme name,
* the slug: the text domain, hooks (`my-theme/…`), handles (`my-theme-…`) and package names, with underscores where PHP needs them (`my_theme_settings`),
* the author details and URLs,
* the copyright year.

It then rebuilds Composer's autoloader and sets `from` to your new details, so you can run it again later. `Name`, `Slug` and `Namespace` are required; the other fields are optional.

It doesn't touch `vendor`, `node_modules`, built assets, images or `changelog.md`. Two things it leaves for you:
* The package vendor names: `backdrop-dev/` in `composer.json` and `@luthemes/` in `package.json`.
* `package-lock.json`, which `npm install` updates.

Check the result with `git diff`.

## Translations

All of the theme's text, and the Backdrop framework's, is in one translation template, `public/lang/momentum.pot`. Rebuild it after changing any text:

<pre>
npm run pot
</pre>

It uses [node-wp-i18n](https://github.com/cedaro/node-wp-i18n), which needs PHP on your path. Run `composer install` first so the framework is there to read. It collects the theme's strings (text domain `momentum`, plus the theme's name and details) and the framework's (text domain `backdrop`, from `vendor/backdrop-dev`). The rest of `vendor` is left out; `bin/make-pot.cjs` lists what's excluded.

Translators make `momentum-{locale}.po` from it, for example `momentum-de_DE.po`, and compile it to `.mo` in `public/lang`. The framework's `backdrop` strings use the theme's translations, so that one file covers both. `style.css` points ClassicPress there with `Domain Path: /public/lang`.

`composer rename` rebuilds the template under your new text domain.

## Starting points

Momentum is a starting point, so some things are switched on but left for you to finish, and some files are samples. Wire them up or delete them:

| What | Where | State |
|---|---|---|
| Your theme's name, author and URIs | `themerename.json` | Momentum's own. Fill in `to` and run `composer rename` (see [Renaming](#renaming)). `style.css` stays at version `0.0.1` for your first release. |
| Design | `chassis.json` | Empty, so Chassis's defaults show. Add colors, fonts and spacing. |
| Your own styles and scripts | `resources/scss/screen.scss`, `resources/js/app.js` | Empty. Each loads once it has something in it. |
| Header image | `app/CustomHeader/`, `public/images/headers/` | Header image support is on, with three sample images, but no template prints it. Add it to `public/views/header/default.php`, or remove the component. "Display site title and tagline" isn't wired up either. |
| Meta icons | `public/svg/meta-icons/` | Calendar, comment and user icons, not used yet. For post metadata, if you want icons. |
| Layout picker images | `public/images/layouts/` | Used by Customize → Layout. `header-image.jpg` isn't used. |
| Menus | `config/_settings-menus.php` | Primary and Social. |
| Widget areas | `config/_settings-sidebars.php` | Primary and Footer. |
| Theme settings page | `app/Settings/` | Appearance → Momentum, with recommended plugins from `config/plugins.json`. |
| Translations | `public/lang/` | Holds `momentum.pot`, with the theme's and Backdrop's text. Build it with `npm run pot` ([Translations](#translations)). |

## Checks

Each push and pull request runs `.github/workflows/build.yml`. It checks every PHP file for syntax errors on PHP 7.4 and 8.3, then installs the dependencies and runs `npm run build`, so a theme copied from Momentum always builds. `cpcs.yml` checks the ClassicPress coding standards on pushes to `develop`.

## Copyright and License

Momentum is licensed under the [GNU GPL](https://www.gnu.org/licenses/gpl-2.0.html), version 2 or later.

2025 &copy; Benjamin Lu.
