<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;
use App\Admin\Controllers\RegisterController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('register',  [RegisterController::class, 'show'])->name('register');
    $router->post('register',  [RegisterController::class, 'register'])->name('post-register');

    $router->get('/', 'HomeController@show');

    $router->resource('companies', 'CompanyController');
    $router->resource('series', 'SeriesController');
    $router->resource('active-stocks', 'ActiveStockController');
});
