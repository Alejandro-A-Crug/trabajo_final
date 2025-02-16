<?php

use App\Controllers\TimeController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController_M::login');


//paginas principales
$routes->get('metronic', 'UserController::metronic');
$routes->get('calendar', 'UserController::calendar');
$routes->get('usuarios', 'UserController::index');
$routes->get('sessiontest', 'UserController_M::sessiontest');

//usuarios
$routes->get('metronic/userlist', 'UserController_M::index');
$routes->get('metronic/users/saveuser', 'UserController_M::saveUser');
$routes->post('metronic/users/saveuser', 'UserController_M::saveUser');
$routes->post('metronic/users/saveuser/(:num)', 'UserController_M::saveUser/$1');
$routes->get('metronic/users/saveuser/(:num)', 'UserController_M::saveUser/$1');
$routes->get('metronic/users/deleteuser/(:num)', 'UserController_M::deleteUser/$1');

//login y logout
$routes->get('metronic/login', 'UserController_M::login');
$routes->post('metronic/login/process', 'UserController_M::loginProcess');
$routes->get('metronic/logout', 'UserController_M::logout');


//time

$routes->get('metronic/timezone', 'TimeController::index');
$routes->get('metronic/timezone/create', 'TimeController::saveAge');
$routes->post('metronic/timezone/create', 'TimeController::saveAge');
$routes->get('metronic/timezone/create/(:num)', 'TimeController::saveAge/$1');
$routes->post('metronic/timezone/create/(:num)', 'TimeController::saveAge/$1');
$routes->get('metronic/timezone/deleteAge/(:num)', 'TimeController::deleteAge/$1');


//roles
$routes->get('metronic/roles', 'RoleController::index');
$routes->get('metronic/roles/create', 'RoleController::saveRole');
$routes->post('metronic/roles/create', 'RoleController::saveRole');
$routes->get('metronic/roles/create/(:num)', 'RoleController::saveRole/$1');
$routes->post('metronic/roles/create/(:num)', 'RoleController::saveRole/$1');
$routes->get('metronic/roles/delete/(:num)', 'RoleController::deleteRole/$1');

//news

$routes->get('metronic/news', 'NewsController::index');
$routes->get('metronic/news/save', 'NewsController::saveNews');
$routes->post('metronic/news/save', 'NewsController::saveNews');
$routes->get('metronic/news/save/(:num)', 'NewsController::saveNews/$1');
$routes->post('metronic/news/save/(:num)', 'NewsController::saveNews/$1');
$routes->get('metronic/news/delete/(:num)', 'NewsController::deleteNews/$1');


