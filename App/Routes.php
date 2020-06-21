<?php

use App\Core\Router;

Router::base(BASE_URL);

/**
 *  ---------------------------------------------
 *  Public Routes
 *  ---------------------------------------------
 */
Router::namespace('App\Resources\Web');

Router::get('/', 'Welcome::index');
Router::get('/departamento/{slug}', 'Welcome::department');

/**
 *  ---------------------------------------------
 *  Private Routes
 *  ---------------------------------------------
 */
Router::namespace('App\Resources\Panel');

Router::get('/acessar', 'UserController::login');
Router::post('/acessar', 'UserController::signin');

Router::get('/painel', 'DashboardController::index');
Router::get('/painel/logout', 'UserController::signout');

Router::get('/painel/departamentos', 'DepartmentController::index');
Router::get('/painel/departamentos/novo', 'DepartmentController::new');
Router::post('/painel/departamentos/novo', 'DepartmentController::save');
Router::get('/painel/departamentos/edit/{id}', 'DepartmentController::edit');
Router::post('/painel/departamentos/edit/{id}', 'DepartmentController::save');
Router::get('/painel/departamentos/delete/{id}', 'DepartmentController::delete');

Router::get('/painel/produtos', 'ProductController::index');
Router::get('/painel/produtos/novo', 'ProductController::new');
Router::post('/painel/produtos/novo', 'ProductController::save');
Router::get('/painel/produtos/edit/{id}', 'ProductController::edit');
Router::post('/painel/produtos/edit/{id}', 'ProductController::save');
Router::get('/painel/produtos/delete/{id}', 'ProductController::delete');

/**
 *  ---------------------------------------------
 *  404 Error Handler
 * ----------------------------------------------
 */
Router::namespace('App\Resources\Errors');
Router::get('/error/404', 'Error404::index');

if (Router::error()['404']) {
    Router::redirect('/error/404');
}
