<?php
$app->get('/', function() use ($app) {
    return view('index'); 
});

$app->post('/create-user',      'UserController@store');
$app->get('/read-users',        'UserController@index');
$app->get('/read-user/{id}',    'UserController@show');
$app->post('/edit-user/{id}', 'UserController@update');
$app->post('/delete-user/{id}', 'UserController@destroy');