<?php
declare(strict_types=1);

/**
 * Saicosys Technologies Private Limited
 * Copyright (c) 2017-2025, Saicosys Technologies
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.md
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    Saicosys <info@saicosys.com>
 * @copyright Copyright (c) 2017-2025, Saicosys Technologies
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://www.saicosys.com
 * @since     1.0.0
 */
namespace Saicosys\Maintenance\Middleware;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Maintenance middleware
 *
 * This middleware checks if the application is in maintenance mode, either by:
 *   - Setting 'enabled' => true in the maintenance configuration, or
 *   - The presence of the config/maintenance.flag file.
 *
 * If maintenance mode is active and the client's IP is not allowed, a maintenance response is returned.
 */
class MaintenanceMiddleware implements MiddlewareInterface
{
    /**
     * Process an incoming server request.
     *
     * If maintenance mode is enabled (via config or flag file) and the client's IP is not allowed,
     * returns a maintenance response. Otherwise, passes the request to the next handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Read maintenance configuration (from config/maintenance.php or fallback)
        $maintenance = Configure::read('maintenance');

        // Check if maintenance mode is active and client is not allowed
        if (
            $this->isMaintenanceMode($maintenance) &&
            !$this->isAllowedIP($request, $maintenance)
        ) {
            return $this->getMaintenanceResponse($maintenance);
        }

        return $handler->handle($request);
    }

    /**
     * Checks if the application is in maintenance mode.
     *
     * Maintenance mode is enabled if either:
     *   - The 'enabled' key in the maintenance config is true, or
     *   - The config/maintenance.flag file exists.
     *
     * @param array<string, mixed> $maintenance The maintenance configuration array.
     * @return bool True if maintenance mode is enabled, false otherwise.
     */
    private function isMaintenanceMode(array $maintenance): bool
    {
        return (!empty($maintenance['enabled']) && $maintenance['enabled'] === true)
            || file_exists(CONFIG . 'maintenance.flag');
    }

    /**
     * Checks if the client's IP address is allowed to access the site during maintenance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request object.
     * @param array<string, mixed> $maintenance The maintenance configuration array.
     * @return bool True if the IP is allowed, false otherwise.
     */
    private function isAllowedIP(ServerRequestInterface $request, array $maintenance): bool
    {
        // Get allowed IPs from config, default to empty array
        $allowedIPs = $maintenance['allowedIPs'] ?? [];
        $clientIP = $request->getServerParams()['REMOTE_ADDR'] ?? '';

        return in_array($clientIP, $allowedIPs);
    }

    /**
     * Generates a maintenance response for the client.
     *
     * Uses a custom template and variables if provided in config, otherwise falls back to defaults.
     *
     * @param array<string, mixed> $maintenance The maintenance configuration array.
     * @return \Psr\Http\Message\ResponseInterface The maintenance response.
     */
    private function getMaintenanceResponse(array $maintenance): ResponseInterface
    {
        $response = new Response();
        $view = new View();
        // Use custom template/variables if set, otherwise fallback to defaults
        $layout = $maintenance['view']['layout'] ?? 'Saicosys/Maintenance.default';
        $template = $maintenance['view']['template'] ?? 'Saicosys/Maintenance.element/maintenance';
        $variables = $maintenance['variables'] ?? [
            'title' => __('System Maintenance'),
            'message' => __('We are upgrading our systems. Please try again later.'),
        ];
        $view->set('response', $variables);
        $view->setTheme('Saicosys/Maintenance');
        $view->setTemplate($template);
        $view->setLayout($layout);
        $content = $view->render();

        return $response
            ->withStatus(Configure::read('maintenance.statusCode', 503))
            ->withHeader('Retry-After', $maintenance['retryAfter'] ?? 3600)
            ->withType('html')
            ->withStringBody($content);
    }
}
