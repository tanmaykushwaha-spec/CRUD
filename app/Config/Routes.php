<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');
$routes->get('userinfo', 'UserController::index');
$routes->get('usersinfo', 'UserController::index');
$routes->get('users', 'UserController::index');
