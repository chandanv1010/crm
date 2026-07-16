<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Backend/Authentication/Auth::login', ['filter' => 'login' ]);
$routes->get(BACKEND_DIRECTORY, 'Backend/Authentication/Auth::login', ['filter' => 'login' ]);
$routes->get('backend/authentication/auth/forgot', 'Backend/Authentication/Auth::forgot', ['filter' => 'login' ]);
$routes->get('backend/authentication/auth/logout', 'Backend/Authentication/Auth::logout', ['filter' => 'auth' ]);
$routes->match(['get','post'],'backend/dashboard/dashboard/index', 'Backend/Dashboard/Dashboard::index', ['filter' => 'auth']);

/*USER*/
$routes->group('backend/user/user', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/User/User::index');
    $routes->add('create', 'Backend/User/User::create');
    $routes->add('update', 'Backend/User/User::update');
    $routes->add('delete', 'Backend/User/User::delete');
});
/*HOSTING*/
$routes->group('backend/service/hosting', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Service/Hosting::index');
    $routes->add('create', 'Backend/Service/Hosting::create');
    $routes->add('update', 'Backend/Service/Hosting::update');
    $routes->add('delete', 'Backend/Service/Hosting::delete');
});

/*VPS*/
$routes->group('backend/service/vps', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Service/Vps::index');
    $routes->add('create', 'Backend/Service/Vps::create');
    $routes->add('update', 'Backend/Service/Vps::update');
    $routes->add('delete', 'Backend/Service/Vps::delete');
});

/*CONTRACT-Website*/
$routes->group('backend/contract/website', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Contract/Website::index');
    $routes->add('create', 'Backend/Contract/Website::create');
    $routes->add('update', 'Backend/Contract/Website::update');
    $routes->add('delete', 'Backend/Contract/Website::delete');
});

/*CONTRACT-Hosting*/
$routes->group('backend/contract/hosting', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Contract/Hosting::index');
    $routes->add('create', 'Backend/Contract/Hosting::create');
    $routes->add('update', 'Backend/Contract/Hosting::update');
    $routes->add('delete', 'Backend/Contract/Hosting::delete');
});

/*CONTRACT-Domain*/
$routes->group('backend/contract/domain', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Contract/Domain::index');
    $routes->add('create', 'Backend/Contract/Domain::create');
    $routes->add('update', 'Backend/Contract/Domain::update');
    $routes->add('delete', 'Backend/Contract/Domain::delete');
});

/*QL-ki*/
$routes->group('backend/cash/periodic', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Cash/Periodic::index');
});

/*QL - nhom tien mat*/
$routes->group('backend/cash/catalogue', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Cash/Catalogue::index');
    $routes->add('create', 'Backend/Cash/Catalogue::create');
    $routes->add('update', 'Backend/Cash/Catalogue::update');
    $routes->add('delete', 'Backend/Cash/Catalogue::delete');
});

/*QL-ki*/
$routes->group('backend/cash/common', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Cash/Common::index');
});

/*QL- tien mat*/
$routes->group('backend/cash/cash', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Cash/Cash::index');
    $routes->add('detail', 'Backend/Cash/Cash::detail');
    $routes->add('search', 'Backend/Cash/Cash::search');
});

/*QL - chi nhanh*/
$routes->group('backend/branch/branch', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Branch/Branch::index');
    $routes->add('create', 'Backend/Branch/Branch::create');
    $routes->add('update', 'Backend/Branch/Branch::update');
    $routes->add('delete', 'Backend/Branch/Branch::delete');
});

/*QL - nhom thoi gian*/
$routes->group('backend/deadline/catalogue', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Deadline/Catalogue::index');
    $routes->add('create', 'Backend/Deadline/Catalogue::create');
    $routes->add('update', 'Backend/Deadline/Catalogue::update');
    $routes->add('delete', 'Backend/Deadline/Catalogue::delete');
});

/*QL - thoi gian xu ly*/
$routes->group('backend/deadline/deadline', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Deadline/Deadline::index');
    $routes->add('create', 'Backend/Deadline/Deadline::create');
    $routes->add('update', 'Backend/Deadline/Deadline::update');
    $routes->add('delete', 'Backend/Deadline/Deadline::delete');
});

/*QL - nhom van de*/
$routes->group('backend/problem/catalogue', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Problem/Catalogue::index');
    $routes->add('create', 'Backend/Problem/Catalogue::create');
    $routes->add('update', 'Backend/Problem/Catalogue::update');
    $routes->add('delete', 'Backend/Problem/Catalogue::delete');
});

/*QL - van de xu ly*/
$routes->group('backend/problem/problem', ['filter' => 'auth'] , function($routes){
    $routes->add('index', 'Backend/Problem/Problem::index');
    $routes->add('create', 'Backend/Problem/Problem::create');
    $routes->add('update', 'Backend/Problem/Problem::update');
    $routes->add('delete', 'Backend/Problem/Problem::delete');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
