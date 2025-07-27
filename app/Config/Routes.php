<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

$routes->get('login', 'AuthController::showLoginForm');
$routes->get('signup', 'AuthController::showSignupForm');
$routes->post('login', 'AuthController::login');
$routes->post('signup', 'AuthController::signup');
$routes->get('/logout', 'AuthController::logoutConfirm');
$routes->post('/logout', 'AuthController::logout');

$routes->get('user/(:num)', 'User::index/$1');
$routes->get('user/(:num)/addMovie', 'User::addMovieForm/$1');
$routes->post('user/(:num)/addMovie', 'User::submitMovie/$1');

$routes->post('movie/react', 'MovieController::react');
