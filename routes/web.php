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

$router->group([
    'middleware' => ['throttle']
], function () use ($router) {

    $router->get('/', function () {
        $projects = \App\Models\Project::all();
        return view('index', compact('projects'));
    });

    $router->get('/test', function () {
        return "Hello World (2)";
    });

    // CRUD Projects
    $router->get('/projects', 'ProjectController@index');
    $router->get('/projects/create', 'ProjectController@create');
    $router->post('/projects', 'ProjectController@store');
    $router->get('/projects/{id}/edit', 'ProjectController@edit');
    $router->post('/projects/{id}', 'ProjectController@update');
    $router->post('/projects/{id}/delete', 'ProjectController@destroy');

});
