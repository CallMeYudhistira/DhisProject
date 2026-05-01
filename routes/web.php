<?php

use Illuminate\Support\Facades\Auth;

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

    $router->get('/webshell', function () {
        return response()->json([
            "success" => false,
            "idiot" => true,
            "message" => "Oh no! webshell is not found...",
        ], 404);
    });

    $router->get('/shell', function () {
        return response()->json([
            "success" => false,
            "idiot" => true,
            "message" => "Oh no! shell is not found...",
        ], 404);
    });

    $router->get('/login/for/projects/management', 'AuthController@showLogin');
    $router->post('/login/for/projects/management/post', 'AuthController@login');
    $router->get('/logout', 'AuthController@logout');

    $router->group([
        'middleware' => ['auth']
    ], function () use ($router) {
        // CRUD Projects
        $router->get('/projects', 'ProjectController@index');
        $router->get('/projects/create', 'ProjectController@create');
        $router->post('/projects', 'ProjectController@store');
        $router->get('/projects/{id}/edit', 'ProjectController@edit');
        $router->post('/projects/{id}', 'ProjectController@update');
        $router->post('/projects/{id}/delete', 'ProjectController@destroy');
    });
});
