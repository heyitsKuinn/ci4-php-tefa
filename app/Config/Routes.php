<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route Login
$routes->get('/', 'WelcomeController::index');  // Rute untuk halaman welcome
$routes->get('/login', 'LoginController::index');  // Rute untuk halaman login
$routes->post('/login', 'LoginController::login');  // Proses login
$routes->get('/logout', 'LoginController::logout');  // Rute untuk logout

// Halaman dashboard setelah login
$routes->get('/dashboard', 'Home::index');  // Halaman dashboard setelah login

// Route Register
$routes->get('register', 'Auth::register');  // Untuk menampilkan form register
$routes->post('register', 'Auth::register'); // Untuk memproses form register

// Route untuk halaman forgot passwordF
$routes->get('forgot-password', 'Auth::forgotPassword'); // Menampilkan form forgot password
$routes->post('forgot-password', 'Auth::forgotPassword'); // Mengirim email reset password

// Route untuk halaman reset password
$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1'); // Menampilkan form reset password berdasarkan token
$routes->get('/verify-code', 'Auth::verifyCode');
$routes->post('/verify-code', 'Auth::verifyCode');



$routes->get('device', 'device::device'); 
$routes->post('/device/save', 'device::simpandevice');
$routes->match(['get', 'post'],'/device/edit', 'device::editDevice');
$routes->post('/device/hapus', 'device::hapusDevice');