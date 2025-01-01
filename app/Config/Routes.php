<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'WelcomeController::index');  // Rute untuk halaman welcome
$routes->get('/login', 'LoginController::index');  // Rute untuk halaman login
$routes->post('/login', 'LoginController::login');  // Proses login
$routes->get('/logout', 'LoginController::logout');  // Rute untuk logout

// Halaman dashboard setelah login
$routes->get('/dashboard', 'Home::index');  // Halaman dashboard setelah login

$routes->get('device', 'device::device'); 