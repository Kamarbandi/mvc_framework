<?php

use App\Helpers\Router;

require_once '../config/config.php';

$router = new Router();

//$router->get('/api/tests', 'TestController@index');
//$router->post('/api/tests', 'TestController@store');
//$router->put('/api/tests/{id}', 'TestController@update');
//$router->delete('/api/tests/{id}', 'TestController@destroy');

$router->handleRequest();
