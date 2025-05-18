<?php
/**
 * Custom Header Settings.
 *
 * This configuration file defines custom headers for the Momentum theme.
 * Each header includes a name and a URL to its corresponding image.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2025 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      https://luthemes.com/portfolio/momentum
 */

return [
    'default-header' => [
        'name' => 'Default Header',
        'url'  => get_template_directory_uri() . '/public/images/headers/andromeda-galaxy.png'
    ],
    'alternative-header' => [
        'name' => 'Alternative Header',
        'url'  => get_template_directory_uri() . '/public/images/headers/macbook-pro.png'
    ],
    'dark-header' => [
        'name' => 'Dark Header',
        'url'  => get_template_directory_uri() . '/public/images/headers/sombrero-galaxy.png'
    ]
];
