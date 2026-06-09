<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Arahkan halaman utama ke fungsi index() di Controller Sekolah
$routes->get('/', 'Sekolah::index');

// Rute untuk halaman peta dan API data sekolah
$routes->get('sekolah/peta', 'Sekolah::peta');
$routes->get('sekolah/get_data_sekolah', 'Sekolah::get_data_sekolah');