<?php

use App\Core\Router;

$router = new Router;
$router->base(BASE_URL);

/**
 *  ---------------------------------------------
 *  Public Routes
 *  ---------------------------------------------
 */
$router->namespace('App\Resources\Web');
$router->get('/', 'Welcome::index');
$router->get('/departamento/{slug}', 'Welcome::department');

/**
 *  ---------------------------------------------
 *  Private Routes
 *  ---------------------------------------------
 */
$router->namespace('App\Resources\Panel');
$router->get('/acessar', 'UserController::login');
$router->post('/acessar', 'UserController::signin');

$router->get('/painel', 'DashboardController::index');
$router->get('/painel/logout', 'UserController::signout');

$router->get('/painel/departamentos', 'DepartmentController::index');
$router->get('/painel/departamentos/novo', 'DepartmentController::new');
$router->post('/painel/departamentos/novo', 'DepartmentController::store');
$router->get('/painel/departamentos/edit/{id}', 'DepartmentController::edit');
$router->post('/painel/departamentos/edit/{id}', 'DepartmentController::store');
$router->get('/painel/departamentos/delete/{id}', 'DepartmentController::delete');

$router->get('/painel/produtos', 'ProductController::index');
$router->get('/painel/produtos/novo', 'ProductController::new');
$router->post('/painel/produtos/novo', 'ProductController::store');
$router->get('/painel/produtos/edit/{id}', 'ProductController::edit');
$router->post('/painel/produtos/edit/{id}', 'ProductController::store');
$router->get('/painel/produtos/delete/{id}', 'ProductController::delete');

/**
 *  ---------------------------------------------
 *  404 Error Handler
 * ----------------------------------------------
 */
$router->namespace('App\Resources\Errors');
$router->get('/error/404', 'Error404::index');

if ($router->error()) {
    $router->redirect('/error/404');
}
