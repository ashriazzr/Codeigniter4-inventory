<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true); //Jangan di hapus
$routes->get('/', 'Login::index');
$routes->get('/category/deleteData/(:any)', 'Category::index');
$routes->get('/category/deleteData/(:any)', 'Category::deleteData/$1');

$routes->get('/product/deleteData/(:any)', 'Product::index');
$routes->get('/product/deleteData/(:any)', 'Product::deleteData/$1');
