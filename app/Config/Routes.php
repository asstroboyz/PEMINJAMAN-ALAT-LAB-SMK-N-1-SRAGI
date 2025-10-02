<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

//  Perbaiki
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'User::index', ['filter' => 'role:User']);
$routes->get('/', 'User::index', ['filter' => 'role:User']);

// ========================= USER ROUTES =========================
$routes->group('User', ['filter' => 'role:User'], function ($routes) {
    $routes->get('/', 'User::index');
    $routes->delete('(:num)', 'User::delete/$1');
    $routes->put('ubah/(:num)', 'User::ubah/$1');
    $routes->post('ubah/update/(:num)', 'User::updatePermin/$1');
    $routes->get('update/(:num)', 'User::ubah/$1');
    $routes->put('profile/(:num)', 'User::profile/$1');
    $routes->put('ubah/simpanProfile/(:num)', 'User::simpanProfile/$1');
});

// ========================= ADMIN ROUTES =========================
$routes->group('Admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->post('save', 'Admin::save');
    $routes->get('(:num)', 'Admin::detail/$1');
    $routes->put('detail/(:num)', 'Admin::detailinv/$1');
    $routes->get('detail/(:num)', 'Admin::detail/$1');

    // Inventaris management
    $routes->post('inventaris/save', 'Inventaris::save');
    $routes->put('inventaris/ubah/(:num)', 'Inventaris::ubah/$1');
    $routes->put('inventaris/ubah/update/(:num)', 'Inventaris::update/$1');

    // Tambah & Kurang stok
    $routes->get('formTambahStok/(:num)', 'Admin::formTambahStok/$1');
    $routes->post('formTambahStok/tambahStok/(:num)', 'Admin::tambahStok/$1');
    $routes->get('formKurangStok/(:num)', 'Admin::formKurangStok/$1');
    $routes->post('formKurangStok/kurangiStok/(:num)', 'Admin::kurangiStok/$1');

    // Soft delete
    $routes->get('softDelete/(:segment)', 'Admin::softDelete/$1');
});
// $routes->get('/User', 'User::index', ['filter' => 'role:User']);
// $routes->post('inventaris/save', 'Inventaris::save', ['filter' => 'role:admin']);
// $routes->post('Admin/save', 'admin::save', ['filter' => 'role:admin']);
// $routes->get('/Admin', 'Admin::index', ['filter' => 'role:admin']);
// $routes->get('/Admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
// $routes->put('/Admin/detail/(:num)', 'Admin::detailinv/$1', ['filter' => 'role:admin']);
// $routes->get('Admin/detail/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
// $routes->put('/inventaris/ubah/(:num)', 'Inventaris::ubah/$1', ['filter' => 'role:admin']);
// $routes->put('/inventaris/ubah/update/(:num)', 'Inventaris::update/$1', ['filter' => 'role:admin']);
// $routes->get('/Admin/formTambahStok/(:num)', 'Admin::formTambahStok/$1', ['filter' => 'role:admin']);
// $routes->post('/Admin/formTambahStok/tambahStok/(:num)', 'Admin::tambahStok/$1', ['filter' => 'role:admin']);
// $routes->get('/Admin/formKurangStok/(:num)', 'Admin::formKurangStok/$1', ['filter' => 'role:admin']);
// $routes->post('/Admin/formKurangStok/kurangiStok/(:num)', 'Admin::kurangiStok/$1', ['filter' => 'role:admin']);
// $routes->get('Admin/softDelete/(:segment)', 'Admin::softDelete/$1');
// $routes->delete('/User/(:num)', 'User::delete/$1', ['filter' => 'role:User']);
// $routes->put('/User/ubah/(:num)', 'User::ubah/$1', ['filter' => 'role:User']);
// $routes->post('/User/ubah/update/(:num)', 'User::updatePermin/$1', ['filter' => 'role:User']);
// $routes->get('/User/update/(:num)', 'User::ubah/$1', ['filter' => 'role:User']);
// $routes->put('/User/profile/(:num)', 'User::profile/$1', ['filter' => 'role:User']);
// $routes->put('/User/ubah/simpanProfile/(:num)', 'User::simpanProfile/$1', ['filter' => 'role:User']);
// $routes->get('/administrator', 'administrator::index', ['filter' => 'role:administrator']);


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
