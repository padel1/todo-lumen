<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return $router->app->version();
});

$router->get('/todos', 'TodoController@index');
$router->post('/todos', 'TodoController@store');
$router->get('/todos/{id}', 'TodoController@show');
$router->put('/todos/{id}', 'TodoController@update');
$router->delete('/todos/{id}', 'TodoController@destroy');
// $router->post('/todos/{id}/complete', 'TodoController@markAsComplete');
$router->options('{any:.*}', function () {
    return response('', 200);
});
