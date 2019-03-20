<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    // $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
    //    'httpOnly' => true
    //     'httpOnly' => true
    // ]));

    /**
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
     */
    // $routes->applyMiddleware('csrf');
    //$routes->applyMiddleware('csrf');



    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /** Categories*/
    $routes->connect('/categories/index', ['controller' => 'Categories', 'action' => 'index']);
    $routes->connect('/categories/view/:id', ['controller' => 'Categories', 'action' => 'view']);
    $routes->connect('/categories/edit/:id', ['controller' => 'Categories', 'action' => 'edit']);
    $routes->connect('/categories/delete/:id', ['controller' => 'Categories', 'action' => 'delete']);
    $routes->connect('/categories/add', ['controller' => 'Categories', 'action' => 'add']);
    /** Brands*/
    $routes->connect('/brand/index', ['controller' => 'Brands', 'action' => 'index']);
    $routes->connect('/brand/view/:id', ['controller' => 'Brands', 'action' => 'view']);
    $routes->connect('/brand/edit/:id', ['controller' => 'Brands', 'action' => 'edit']);
    $routes->connect('/brand/delete', ['controller' => 'Brands', 'action' => 'delete']);
    $routes->connect('/brand/add', ['controller' => 'Brands', 'action' => 'add']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    $routes->connect('list', ['controller' => 'BorrowDetails', 'action' => 'index']);


    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    //$routes->connect('/devices.json', ['controller' => 'Devices']);

 

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->setExtensions(['json', 'xml']);
    //Devices
    $routes->connect('/devices/index', ['controller' => 'Devices','action' => 'index']);
    $routes->connect('/devices/add', ['controller' => 'Devices','action' => 'add']);
    $routes->connect('/devices/addImage', ['controller' => 'Devices','action' => 'addImage']);
    $routes->connect('/devices/view/:id', ['controller' => 'Devices','action' => 'view']);
    $routes->connect('/devices/edit/:id', ['controller' => 'Devices','action' => 'edit']);
    $routes->connect('/devices/delete/:id', ['controller' => 'Devices','action' => 'delete']);

    //$routes->fallbacks(DashedRoute::class);
});
    Router::prefix('inventory', function ($routes) {
        $routes->connect('/devices.json', ['controller' => 'Devices']);
    });

/**
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
