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

$router->get('/', function () use ($router) {
    echo "TG寒假后端练习一";
});

$router->post('/register', ['uses' => 'RegisterController@index']);
$router->post('/login', ['uses' => 'LoginController@index' ]);
$router->group(['prefix' => 'post'], function () use ($router) {
	$router->get('/', ['uses' => 'PostController@index']);
	$router->get('/{id}', ['uses' => 'PostController@show']);
	$router->post('/', ['uses' => 'PostController@create', 'middleware' => 'auth']);
	$router->put('/{id}', ['uses' => 'PostController@update', 'middleware' => 'auth']);
	$router->delete('/{id}', ['uses' => 'PostController@delete', 'middleware' => 'auth']);
	$router->get('/like/{id}', ['uses' => 'PostController@like', 'middleware' => 'auth']);
});
