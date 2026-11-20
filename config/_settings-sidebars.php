<?php
/**
 * Sidebar Settings Configuration.
 *
 * This file defines the sidebar locations for the Momentum theme.
 * These settings are used during theme initialization to register
 * the available sidebars with their respective names and descriptions.
 *
 * @package   Momentum
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2026 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/momentum
 */

return [
    'primary' => [
        'name'        => __( 'Primary Sidebar', 'momentum' ),
        'description' => __( 'The main sidebar for widgets alongside primary content.', 'momentum' )
    ],
    'footer' => [
        'name'        => __( 'Footer Sidebar', 'momentum' ),
        'description' => __( 'A widget area displayed in the footer section of the site.', 'momentum' )
    ],
];
