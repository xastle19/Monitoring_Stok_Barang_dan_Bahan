<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/login/logout', 'Login::logout');

$routes->get('/login/dashboard_karyawan', 'Login::dashboard_karyawan');
$routes->get('/login/dashboard_staf', 'Login::dashboard_staf');
$routes->get('/login/dashboard_manager', 'Login::dashboard_manager');
$routes->get('/login/dashboard_keuangan', 'Login::dashboard_keuangan');
$routes->get('/surat', 'Surat::index', ['filter' => 'auth']);
$routes->post('/surat/save', 'Surat::save', ['filter' => 'auth']);

$routes->get('/karyawan', 'Karyawan::index');
$routes->post('/karyawan/kirimSurat', 'Karyawan::kirimSurat');

$routes->get('/stafgudang', 'StafGudang::index');
$routes->post('/stafgudang/updateStatus/(:num)', 'StafGudang::updateStatus/$1');
$routes->get('/stafgudang/grafikStok', 'StafGudang::grafikStok');
$routes->get('/stafgudang/laporanStok', 'StafGudang::laporanStok');
$routes->post('/stafgudang/tambahBarang', 'StafGudang::tambahBarang');
$routes->post('/stafgudang/editBarang', 'StafGudang::editBarang');
$routes->post('/stafgudang/hapusBarang/(:num)', 'StafGudang::hapusBarang/$1');
$routes->post('/stafgudang/tambahBarangKeluar', 'StafGudang::tambahBarangKeluar');
$routes->post('/stafgudang/kirimSurat', 'StafGudang::kirimSurat');
$routes->post('stafgudang/kirimInformasi', 'StafGudang::kirimInformasi');
$routes->post('/stafgudang/ajukanpembelian', 'StafGudang::ajukanPembelian');
$routes->post('/stafgudang/updateStatusSurat/(:num)', 'StafGudang::updateStatusSurat/$1');




$routes->get('/manajer', 'KepalaGudang::dashboard'); // Ini akan memanggil KepalaGudang::dashboard()
$routes->get('/manajer/informasi', 'KepalaGudang::lihatInformasi');
$routes->get('/kepalagudang/getPengajuan', 'KepalaGudang::getPengajuan');
$routes->post('/kepalagudang/setujui/(:num)', 'KepalaGudang::setujui/$1');
$routes->post('/kepalagudang/tolak/(:num)', 'KepalaGudang::tolak/$1');

$routes->get('/keuangan', 'Keuangan::index'); // Ini akan memanggil Keuangan::index()

$routes->get('/keuangan/pembelian', 'Keuangan::pembelianBarang');
$routes->post('/keuangan/updateStatus/(:num)', 'Keuangan::updateStatus/$1');
