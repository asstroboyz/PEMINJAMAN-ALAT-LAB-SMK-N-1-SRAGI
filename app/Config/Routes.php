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
$routes->get('/', 'Pegawai::index', ['filter' => 'role:pegawai']);

$routes->get('/Pegawai', 'Pegawai::index', ['filter' => 'role:pegawai']);
$routes->post('inventaris/save', 'Inventaris::save', ['filter' => 'role:admin']);
$routes->post('Admin/save', 'admin::save', ['filter' => 'role:admin']);
$routes->get('/Admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/Admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->put('/Admin/detail/(:num)', 'Admin::detailinv/$1', ['filter' => 'role:admin']);
$routes->get('Admin/detail/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);

// $routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);

$routes->put('/inventaris/ubah/(:num)', 'Inventaris::ubah/$1', ['filter' => 'role:admin']);
$routes->put('/inventaris/ubah/update/(:num)', 'Inventaris::update/$1', ['filter' => 'role:admin']);

$routes->get('/Admin/formTambahStok/(:num)', 'Admin::formTambahStok/$1', ['filter' => 'role:admin']);
$routes->post('/Admin/formTambahStok/tambahStok/(:num)', 'Admin::tambahStok/$1', ['filter' => 'role:admin']);
$routes->get('/Admin/formKurangStok/(:num)', 'Admin::formKurangStok/$1', ['filter' => 'role:admin']);
$routes->post('/Admin/formKurangStok/kurangiStok/(:num)', 'Admin::kurangiStok/$1', ['filter' => 'role:admin']);
$routes->get('Admin/softDelete/(:segment)', 'Admin::softDelete/$1');

$routes->put('/Admin/detail_inv/(:num)', 'Admin::detail_inv/$1', ['filter' => 'role:admin']);
$routes->put('/pegawai/detail_inv/(:num)', 'pegawai::detail_inv/$1', ['filter' => 'role:pegawai']);

// $routes->get('/barang/formTambahStok/(:num)', 'Barang::formTambahStok/$1', ['filter' => 'role:admin']);
// $routes->post('/barang/formTambahStok/tambahStok/(:num)', 'Barang::tambahStok/$1', ['filter' => 'role:admin']);
// $routes->get('/barang/formKurangStok/(:num)', 'Barang::formKurangStok/$1', ['filter' => 'role:admin']);

$routes->put('/pegawai/editPengadaan/(:num)', 'pegawai::editPengadaan/$1', ['filter' => 'role:pegawai']);
$routes->put('/pegawai/editPengadaan/updatePengadaan/(:num)', 'pegawai::updatePengadaan/$1', ['filter' => 'role:pegawai']);
$routes->put('/pegawai/detailPengadaan/(:num)', 'pegawai::detailPengadaan/$1', ['filter' => 'role:pegawai']);
// app/Config/Routes.php

$routes->get('/Petugas_pengadaan', 'Petugas_pengadaan::index', ['filter' => 'role:petugas_pengadaan']);

$routes->delete('/pegawai/(:num)', 'pegawai::delete/$1', ['filter' => 'role:pegawai']);
// routes.php
$routes->put('/pegawai/ubah/(:num)', 'pegawai::ubah/$1', ['filter' => 'role:pegawai']);
$routes->post('/pegawai/ubah/update/(:num)', 'pegawai::updatePermin/$1', ['filter' => 'role:pegawai']);
$routes->get('/pegawai/update/(:num)', 'pegawai::ubah/$1', ['filter' => 'role:pegawai']);


$routes->put('/pegawai/profile/(:num)', 'pegawai::profile/$1', ['filter' => 'role:pegawai']);

$routes->put('/pegawai/ubah/simpanProfile/(:num)', 'pegawai::simpanProfile/$1', ['filter' => 'role:pegawai']);

$routes->get('cetak', 'Admin::index', ['filter' => 'role:admin']);
$routes->post('cetak/cetakData', 'Admin::cetakData', ['filter' => 'role:admin']);
$routes->get('admin/cetakDataPdf', 'Admin::cetakDataPdf', ['filter' => 'role:admin']);
$routes->get('admin/cetakDataPengadaan', 'Admin::cetakDataPengadaan', ['filter' => 'role:admin']);
$routes->get('admin/cetakDataInventaris', 'Admin::cetakDataInventaris', ['filter' => 'role:admin']);
$routes->get('admin/cetakDataATK', 'Admin::cetakDataATK', ['filter' => 'role:admin']);
$routes->get('admin/cetakDataMasuk', 'Admin::cetakDataMasuk', ['filter' => 'role:admin']);
$routes->get('admin/cetakDataBarang', 'Admin::cetakDataBarang', ['filter' => 'role:admin']);


$routes->get('/administrator', 'administrator::index', ['filter' => 'role:administrator']);


// Perbaiki

// $routes->put('/pegawai/detail/(:num)', 'pegawai::detail/$1', ['filter' => 'role:pegawai']);
// $routes->put('/user/profile/(:num)', 'user::profile/$1', ['filter' => 'role:user']);
// $routes->put('/user/tentang/(:num)', 'user::tentang/$1', ['filter' => 'role:user']);
// $routes->put('/user/ubah/simpanProfile/(:num)', 'user::simpanProfile/$1', ['filter' => 'role:user']);
// $routes->put('/user/cetakdata/(:num)', 'user::cetakdata/$1', ['filter' => 'role:user']);


// $routes->get('/user/pengaduan', 'User::pengaduan', ['filter' => 'role:user']);
// $routes->get('/user/simpanPengaduan', 'User::simpanPengaduan', ['filter' => 'role:user']);
// $routes->put('/user/ubah/(:num)', 'user::ubah/$1', ['filter' => 'role:user']);
// $routes->put('/user/ubah/ubahPengaduan/(:num)', 'user::ubahPengaduan/$1', ['filter' => 'role:user']);
// $routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
// $routes->get('/admin/pengaduan', 'Admin::pengaduan', ['filter' => 'role:admin']);
// $routes->put('/admin/detail/(:num)', 'admin::detail/$1', ['filter' => 'role:admin']);
// $routes->put('/admin/simpanBalasan/(:num)', 'admin::simpanBalasan/$1', ['filter' => 'role:admin']);
// $routes->put('/admin/prosesPengaduan/(:num)', 'admin::prosesPengaduan/$1', ['filter' => 'role:admin']);
// $routes->put('/admin/terimaPengaduan/(:num)', 'admin::terimaPengaduan/$1', ['filter' => 'role:admin']);
// $routes->put('/admin/ubah/simpanProfile/(:num)', 'admin::simpanProfile/$1', ['filter' => 'role:admin']);
// $routes->put('/admin/ubah/updatePassword/(:num)', 'admin::updatePassword/$1', ['filter' => 'role:admin']);
// $routes->put('/user/updatePassword/(:num)', 'user::updatePassword/$1', ['filter' => 'role:user']);

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
