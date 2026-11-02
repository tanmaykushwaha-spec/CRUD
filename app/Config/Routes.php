<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');
$routes->get('userinfo', 'UserController::getinfo');
$routes->get('usersinfo', 'UserController::getinfo');
$routes->get('users', 'UserController::getinfo');
$routes->get('users/new', 'UserController::add');
$routes->post('users/create', 'UserController::create');
$routes->get('users/edit/(:num)', 'UserController::edit/$1');
$routes->post('users/update/(:num)', 'UserController::update/$1');
$routes->post('users/delete/(:num)', 'UserController::delete/$1');