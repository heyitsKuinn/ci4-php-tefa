<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); 


$routes->get('device', 'device::device'); 
$routes->post('/device/save', 'device::simpandevice');
$routes->match(['get', 'post'],'/device/edit', 'device::editDevice');
