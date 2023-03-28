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
$routes->get('/', 'Home::index');


/**Routes groups*/
$routes->group('login', ['namespace' => 'App\Controllers\Auth'], function ($routes) {
    $routes->get('/', 'Login::show');
    $routes->post('login', 'Login::login');
    //$routes->post("api/login", "Login::index");
});

/**Routes groups*/
$routes->group('user', ['namespace' => 'App\Controllers\User'], function ($routes) {
    $routes->get('/', 'User::show');
    $routes->post('create', 'User::create');
    $routes->post('delete', 'User::delete');
    $routes->post('edit', 'User::edit');
    $routes->post('update', 'User::update');
});

$routes->group('doctype', ['namespace' => 'App\Controllers\DocType'], function ($routes) {
    $routes->get('/', 'DocType::show');
    $routes->post('create', 'DocType::create');
    $routes->post('delete', 'DocType::delete');
    $routes->post('edit', 'DocType::edit');
    $routes->post('update', 'DocType::update');
});

$routes->group('role', ['namespace' => 'App\Controllers\Role'], function ($routes) {
    $routes->get('/', 'Role::show');
    $routes->post('create', 'Role::create');
    $routes->post('delete', 'Role::delete');
    $routes->post('edit', 'Role::edit');
    $routes->post('update', 'Role::update');
});

$routes->group('module', ['namespace' => 'App\Controllers\Module'], function ($routes) {
    $routes->get('/', 'Module::show');
    $routes->post('create', 'Module::create');
    $routes->post('delete', 'Module::delete');
    $routes->post('edit', 'Module::edit');
    $routes->post('update', 'Module::update');
});

$routes->group('userstatus', ['namespace' => 'App\Controllers\UserStatus'], function ($routes) {
    $routes->get('/', 'UserStatus::show');
    $routes->post('create', 'UserStatus::create');
    $routes->post('delete', 'UserStatus::delete');
    $routes->post('edit', 'UserStatus::edit');
    $routes->post('update', 'UserStatus::update');
});

$routes->group('country', ['namespace' => 'App\Controllers\Country'], function ($routes) {
    $routes->get('/', 'Country::show');
    $routes->post('create', 'Country::create');
    $routes->post('delete', 'Country::delete');
    $routes->post('edit', 'Country::edit');
    $routes->post('update', 'Country::update');
});

$routes->group('unit', ['namespace' => 'App\Controllers\Unit'], function ($routes) {
    $routes->get('/', 'Unit::show');
    $routes->post('create', 'Unit::create');
    $routes->post('delete', 'Unit::delete');
    $routes->post('edit', 'Unit::edit');
    $routes->post('update', 'Unit::update');
});

$routes->group('city', ['namespace' => 'App\Controllers\City'], function ($routes) {
    $routes->get('/', 'City::show');
    $routes->post('create', 'City::create');
    $routes->post('delete', 'City::delete');
    $routes->post('edit', 'City::edit');
    $routes->post('update', 'City::update');
});

$routes->group('company', ['namespace' => 'App\Controllers\Company'], function ($routes) {
    $routes->get('/', 'Company::show');
    $routes->post('create', 'Company::create');
    $routes->post('delete', 'Company::delete');
    $routes->post('edit', 'Company::edit');
    $routes->post('update', 'Company::update');
});

$routes->group('client', ['namespace' => 'App\Controllers\Client'], function ($routes) {
    $routes->get('/', 'Client::show');
    $routes->post('create', 'Client::create');
    $routes->post('delete', 'Client::delete');
    $routes->post('edit', 'Client::edit');
    $routes->post('update', 'Client::update');
});

$routes->group('product', ['namespace' => 'App\Controllers\Product'], function ($routes) {
    $routes->get('/', 'Product::show');
    $routes->post('create', 'Product::create');
    $routes->post('delete', 'Product::delete');
    $routes->post('edit', 'Product::edit');
    $routes->post('update', 'Product::update');
});

$routes->group('producttype', ['namespace' => 'App\Controllers\ProductType'], function ($routes) {
    $routes->get('/', 'ProductType::show');
    $routes->post('create', 'ProductType::create');
    $routes->post('delete', 'ProductType::delete');
    $routes->post('edit', 'ProductType::edit');
    $routes->post('update', 'ProductType::update');
});

$routes->group('filing', ['namespace' => 'App\Controllers\Filing'], function ($routes) {
    $routes->get('/', 'Filing::show');
    $routes->post('create', 'Filing::create');
    $routes->post('delete', 'Filing::delete');
    $routes->post('edit', 'Filing::edit');
    $routes->post('update', 'Filing::update');
});

$routes->group('brand', ['namespace' => 'App\Controllers\Brand'], function ($routes) {
    $routes->get('/', 'Brand::show');
    $routes->post('create', 'Brand::create');
    $routes->post('delete', 'Brand::delete');
    $routes->post('edit', 'Brand::edit');
    $routes->post('update', 'Brand::update');
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
