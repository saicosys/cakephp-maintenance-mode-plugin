<?php
/**
 * Maintenance Configuration Example
 *
 * This file provides an example configuration array for the Saicosys Maintenance plugin.
 * Copy this file to config/maintenance.php and adjust the settings as needed.
 *
 * Example usage:
 *
 * return [
 *     'maintenance' => [
 *         'enabled' => true, // Enable or disable maintenance mode
 *         'view' => [
 *             'layout' => 'default.php', // Layout file to use
 *             'template' => null,        // Custom template (optional)
 *         ],
 *         'variables' => [
 *             'logo' => 'logo.png',      // Logo image path
 *             'alt' => 'Company',        // Alt text for logo
 *             'title' => 'System Maintenance',
 *             'message' => 'We are upgrading our systems. Please try again later.'
 *         ],
 *         'allowedIPs' => ['127.0.0.1', '::1'], // IPs allowed during maintenance
 *         'statusCode' => 503, // HTTP status code
 *         'retryAfter' => 3600 // Retry-After header (seconds)
 *     ],
 * ];
 *
 * @author    Saicosys <info@saicosys.com>
 * @copyright Copyright (c) 2017-2025, Saicosys Technologies
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://www.saicosys.com
 * @since     1.0.0
 */

return [
    'maintenance' => [
        'enabled' => true,
        'view' => [
            'layout' => 'default.php',
            'template' => null,
        ],
        'variables' => [
            'logo' => 'logo.png',
            'alt' => 'Company',
            'title' => 'System Maintenance',
            'message' => 'We are upgrading our systems. Please try again later.'
        ],
        'allowedIPs' => ['127.0.0.1', '::1'], // List of IP addresses allowed to access the site during maintenance.
        'statusCode' => 503, // HTTP status code to return during maintenance.
        'retryAfter' => 3600 // Number of seconds after which the site is expected to be back online.
    ],
];