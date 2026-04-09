<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api/kategori', function($routes){
        $routes->post('createKategori', 'Kategori::createKategori');
        $routes->get('getAllKategori', 'Kategori::getAllKategori');
        $routes->get('(:num)', 'Kategori::getByIdKategori/$1');
        $routes->put('(:num)', 'Kategori::update/$1');
        $routes->delete('(:num)', 'Kategori::delete/$1');
});

$routes->group('api/barang', function($routes){
        $routes->post('createBarang', 'Barang::createBarang');
        $routes->get('getAllBarang', 'Barang::getAllBarang');
        $routes->get('(:num)', 'Barang::getByIdBarang/$1');
        $routes->put('(:num)', 'Barang::update/$1');
        $routes->delete('(:num)', 'Barang::delete/$1');
});

