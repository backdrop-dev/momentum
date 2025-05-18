<?php
/**
 * Bootstrap the Momentum Theme.
 *
 * This file initializes the Momentum theme by creating a new instance of the
 * Backdrop Core Application, registering service providers, and bootstrapping
 * the application. This is the core entry point for setting up the theme's
 * architecture and extending its capabilities.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

# ----------------------------------------------------------------------------------
# Create a new application.
# ----------------------------------------------------------------------------------
#
# This code creates the one true instance of the Backdrop Core Application, which can
# be access via the `Backdrop\app();` function or the `Backdrop\App` static class after
# the application has been booted.

$theme = new Backdrop\Core\Application();

# ------------------------------------------------------------------------------
# Register default service providers with the application.
# ------------------------------------------------------------------------------
#
# Here are the default service providers that are essential for the theme to function
# before booting the application. These service providers form the foundation for the
# theme.
$theme->provider( Backdrop\Customize\Provider::class );
$theme->provider( Backdrop\Fonts\Provider::class );
$theme->provider( Backdrop\Mix\Provider::class );

# ------------------------------------------------------------------------------
# Register additional service providers for the theme.
# ------------------------------------------------------------------------------
#
# These are the additional service providers that are crucial for the theme to
# operate before booting the application. These providers offer supplementary
# features to the theme.
$theme->provider( Momentum\Provider::class );
$theme->provider( Momentum\CleanCP\Provider::class );
$theme->provider( Momentum\CustomHeader\Provider::class );
$theme->provider( Momentum\Customize\Provider::class );
$theme->provider( Momentum\Footer\Provider::class );
$theme->provider( Momentum\Image\Provider::class );
$theme->provider( Momentum\Layout\Provider::class );
$theme->provider( Momentum\Menu\Provider::class );
$theme->provider( Momentum\Settings\Provider::class );
$theme->provider( Momentum\Sidebar\Provider::class );

# ------------------------------------------------------------------------------
# Perform bootstrap actions.
# ------------------------------------------------------------------------------
#
# This code creates an action hook that child themes or plugins can utilize to
# integrate their own binding into the bootstrap process before the app is booted.
# The action callback receives the application instance as a parameter.

do_action( 'momentum/bootstrap', $theme );

# ------------------------------------------------------------------------------
# Bootstrap the application.
# ------------------------------------------------------------------------------
#
# The code invokes the `boot();` method of the application, which initiates the
# launch of the application. Congratulations on a job well done!

$theme->boot();
