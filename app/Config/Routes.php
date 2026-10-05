<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public pages
$routes->get('/', 'Pages::home');
$routes->get('about', 'Pages::about');

// Authentication routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');

$routes->get('signup', 'Auth::signup');
$routes->post('signup', 'Auth::register');

// Routes requiring authentication
$routes->group(
    '',
    ['filter' => 'auth'],
    static function (RouteCollection $routes): void {
        // Customer routes
        $routes->get(
            'customers',
            'Customers::index'
        );

        $routes->get(
            'customers/new',
            'Customers::new'
        );

        $routes->post(
            'customers',
            'Customers::create'
        );

        $routes->get(
            'customers/(:num)/edit',
            'Customers::edit/$1'
        );

        $routes->post(
            'customers/(:num)/update',
            'Customers::update/$1'
        );

        // User routes
        $routes->get(
            'users',
            'Users::index'
        );

        $routes->get(
            'users/new',
            'Users::new'
        );

        $routes->post(
            'users',
            'Users::create'
        );

        $routes->get(
            'users/(:num)/edit',
            'Users::edit/$1'
        );

        $routes->post(
            'users/(:num)/update',
            'Users::update/$1'
        );

        // Logout must use POST.
        $routes->post(
            'logout',
            'Auth::logout'
        );
    }
);