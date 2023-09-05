<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Ramsey\Uuid\Guid\Guid;
use Illuminate\Support\Facades\Http;

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

    $books = Http::get('http://lumenbooksapi-web-1');
    $authors = Http::get('http://lumenauthorsapi-web-1');
    

    return "GetwayApi(" .$books->body() ."," .$authors->body() .")";
});
