<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('product', 'Product::index');
$routes->get('product/create', 'Product::create');
$routes->post('product/store', 'Product::store');
$routes->get('product/edit/(:num)', 'Product::edit/$1');
$routes->post('product/update/(:num)', 'Product::update/$1');
$routes->get('product/delete/(:num)', 'Product::delete/$1');
$routes->post('product/datatable', 'Product::datatable');
