<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
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

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * This file is loaded in the context of the `Application` class.
  * So you can use  `$this` to reference the application class instance
  * if required.
 */
return function (RouteBuilder $routes): void {
    /*
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
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->setExtensions(['rss','ics','json','xml']);
        //$builder->setExtensions(['rss','ics']);
        $builder->connect('/*', ['controller' => 'Conferences', 'action' => 'index'],['_name'=>'home']);
        $builder->connect('/index',['controller'=>'Conferences','action'=>'index'],['_name'=>'index']);
        $builder->connect('/conferences/view/{id}', ['controller' => 'Conferences', 'action' => 'view'])->setPass(['id']);
        $builder->connect('/conferences/edit/{id}', ['controller' => 'Conferences', 'action' => 'edit'])->setPass(['id']);
        $builder->connect('/conferences/edit/{id}/{editkey}', ['controller' => 'Conferences', 'action' => 'edit'])->setPass(['id','editkey']);
        $builder->connect('/conferences/delete/{id}/{editkey}', ['controller' => 'Conferences', 'action' => 'delete'])->setPass(['id','editkey']);
        $builder->connect('/conferences/add/{tagstring}', ['controller' => 'Conferences', 'action' => 'add'])->setPass(['tagstring']);
        $builder->connect('/conferences/add', ['controller' => 'Conferences', 'action' => 'add']);
        $builder->connect('/conferences/search', ['controller' => 'Conferences', 'action' => 'search']);
        $builder->connect('/conferences/about', ['controller' => 'Conferences', 'action' => 'about']);
        $builder->connect('/conferences/curatorCookie', ['controller' => 'Conferences', 'action' => 'curatorCookie']);

        $builder->connect('/conferences/{tagstring}', ['controller' => 'Conferences', 'action' => 'index'],['_name'=>'tagstring'])->setPass(['tagstring']);
        
        //$builder->connect('/{tagstring}', ['controller' => 'Conferences', 'action' => 'index'])->setPass(['tagstring']);
        /*
         * ...and connect the rest of 'Pages' controller's URLs.
            NOTE: we have none
         */
        //$builder->connect('/pages/*', 'Pages::display');



        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        //$builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
