<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
    $router->post('userauth', 'UsuariosController@getUserAuth');
    $router->post('logout', 'UsuariosController@userLogout');
    
    $router->get('all', 'UsuariosController@getAllUsuarios');
    $router->post('new', 'UsuariosController@setNewUser');
    $router->put('update/{id}', 'UsuariosController@updateUser');
});

$router->group(['prefix' => 'login'], function () use ($router) {
	$router->post('/', 'LoginController@Login');
	$router->post('new', 'LoginController@setNewUser');
	$router->post('recoverpass', 'LoginController@recoverPass');
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
