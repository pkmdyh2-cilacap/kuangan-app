<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'DashboardController::index');

// Pasien
$routes->get('/pasien', 'PasienController::index');
$routes->get('/pasien/create', 'PasienController::create');
$routes->post('/pasien/save', 'PasienController::save');
$routes->get('/pasien/edit/(:num)', 'PasienController::edit/$1');
$routes->patch('/pasien/update/(:num)', 'PasienController::update/$1');
$routes->delete('/pasien/delete/(:num)', 'PasienController::delete/$1');
$routes->get('/pasien/detail/(:num)', 'PasienController::detail/$1');

// Layanan
$routes->get('/layanan', 'LayananController::index');
$routes->get('/layanan/create', 'LayananController::create');
$routes->post('/layanan/save', 'LayananController::save');
$routes->get('/layanan/edit/(:num)', 'LayananController::edit/$1');
$routes->patch('/layanan/update/(:num)', 'LayananController::update/$1');
$routes->delete('/layanan/delete/(:num)', 'LayananController::delete/$1');

// Transaksi
$routes->get('/transaksi/(:segment)', 'TransaksiController::index/$1');
$routes->get('/transaksi/create/(:segment)', 'TransaksiController::create/$1');
$routes->post('/transaksi/store', 'TransaksiController::store');
$routes->get('/transaksi/detail/(:num)', 'TransaksiController::detail/$1');
$routes->get('/transaksi/invoice/(:num)', 'TransaksiController::invoice/$1');

// Laporan
$routes->get('/laporan/laba-rugi', 'LaporanController::labaRugi');
$routes->get('/laporan/cash-flow', 'LaporanController::cashFlow');
$routes->get('/laporan/bagi-hasil', 'LaporanController::bagiHasil');
