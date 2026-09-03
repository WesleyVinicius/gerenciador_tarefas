<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('tasks', function ($routes) {
    // Leituras
    $routes->get('/', 'TaskController::index');
    $routes->get('new', 'TaskController::new');
    $routes->get('edit/(:num)', 'TaskController::edit/$1');

    // Ações
    $routes->post('create', 'TaskController::create');
    $routes->put('update/(:num)', 'TaskController::update/$1');
    $routes->delete('delete/(:num)', 'TaskController::delete/$1');
});

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    // Leituras
    $routes->get('tasks', 'TaskApiController::index');
    $routes->get('tasks/(:num)', 'TaskApiController::show/$1');

    // Ações
    $routes->post('tasks', 'TaskApiController::create');
    $routes->put('tasks/(:num)', 'TaskApiController::update/$1');
    $routes->delete('tasks/(:num)', 'TaskApiController::delete/$1');
});