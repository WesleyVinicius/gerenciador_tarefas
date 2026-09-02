<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('tasks', function ($routes) {
    // Leituras
    $routes->get('/', 'TasksController::index');
    $routes->get('new', 'TasksController::new');
    $routes->get('edit/(:num)', 'TasksController::edit/$1');

    // Ações
    $routes->post('create', 'TasksController::create');
    $routes->put('update/(:num)', 'TasksController::update/$1');
    $routes->delete('delete/(:num)', 'TasksController::delete/$1');
});