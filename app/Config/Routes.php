<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['POST', 'GET'], '/', 'AuthController::index');

//dashboard
$routes->group('dashboard', ['filter' => 'auth'], static function($routes) {
    $routes->get('logout', 'AuthController::Logout');
    $routes->get('/', 'Home::index');
    $routes->post('/', 'Home::index');



    //
    $routes->match(['POST', 'GET'], 'master/user', 'UserController::index');
    $routes->match(['POST', 'GET'], 'master/user/update/(:num)', 'UserController::update/$1');
    $routes->get('master/user/delete/(:num)', 'UserController::delete/$1');

    //
    $routes->match(['POST', 'GET'],'master/cabang', 'CabangController::index');
    $routes->match(['POST', 'GET'], 'master/cabang/update/(:num)', 'CabangController::update/$1');
    $routes->get('master/cabang/delete/(:num)', 'CabangController::delete/$1');

    //
    $routes->match(['POST', 'GET'],'master/akun', 'AkunController::index');
    $routes->match(['POST', 'GET'], 'master/akun/update/(:num)', 'AkunController::update/$1');
    $routes->get('master/akun/delete/(:num)', 'AkunController::delete/$1');
    
    //
    $routes->match(['POST', 'GET'],'data/kolektibilitas', 'KolektibilitasController::index');
    $routes->match(['POST', 'GET'], 'data/kolektibilitas/update/(:num)', 'KolektibilitasController::update/$1');
    $routes->get('data/kolektibilitas/delete/(:num)', 'KolektibilitasController::delete/$1');
    $routes->get('data/kolektibilitas/export/(:any)/(:any)', 'KolektibilitasController::export/$1/$2');

    
    //
    $routes->match(['POST', 'GET'],'data/mutasi', 'MutasiController::index');
    $routes->match(['POST', 'GET'], 'data/mutasi/update/(:num)', 'MutasiController::update/$1');
    $routes->get('data/mutasi/delete/(:num)', 'MutasiController::delete/$1');
    $routes->get('data/mutasi/export/(:any)/(:any)', 'MutasiController::export/$1/$2');
    
    //
    $routes->match(['POST', 'GET'],'data/pos2', 'POS2Controller::index');
    $routes->match(['POST', 'GET'], 'data/pos2/update/(:num)', 'POS2Controller::update/$1');
    $routes->get('data/pos2/delete/(:num)', 'POS2Controller::delete/$1');
    $routes->get('data/pos2/export/(:any)/(:any)', 'POS2Controller::export/$1/$2');
    
    //
    $routes->match(['POST', 'GET'],'data/liabilitas', 'LiabilitasController::index');
    $routes->match(['POST', 'GET'], 'data/liabilitas/update/(:num)', 'LiabilitasController::update/$1');
    $routes->get('data/liabilitas/delete/(:num)', 'LiabilitasController::delete/$1');
    $routes->get('data/liabilitas/export/(:any)/(:any)', 'LiabilitasController::export/$1/$2');
    

    //
    $routes->match(['POST', 'GET'],'data/laba', 'LabaController::index');
    $routes->match(['POST', 'GET'], 'data/laba/update/(:num)', 'LabaController::update/$1');
    $routes->get('data/laba/delete/(:num)', 'LabaController::delete/$1');
    $routes->get('data/laba/export/(:any)/(:any)/(:any)', 'LabaController::export/$1/$2/$3');
    
    //
    $routes->match(['POST', 'GET'],'data/neraca', 'NeracaController::index');
    $routes->match(['POST', 'GET'], 'data/neraca/update/(:num)', 'NeracaController::update/$1');
    $routes->get('data/neraca/delete/(:num)', 'NeracaController::delete/$1');
    $routes->get('data/neraca/export/(:any)/(:any)', 'NeracaController::export/$1/$2');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
