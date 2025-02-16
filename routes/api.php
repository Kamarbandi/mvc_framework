<?php

use App\Helpers\Router;

require_once '../config/config.php';

$router = new Router();

$router->get('/api/medications', 'MedicationController@index');
$router->post('/api/medications', 'MedicationController@store');
$router->put('/api/medications/{id}', 'MedicationController@update');
$router->delete('/api/medications/{id}', 'MedicationController@destroy');
$router->get('/api/users/{user_id}/medications', 'MedicationController@getByUserId');

$router->handleRequest();
