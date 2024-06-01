<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->post('/login', 'AuthController::login');

$routes->group('/', ['filter'=>'AuthGurd'], function($routes){
    $routes->get('/weather', 'WeatherController::view');
    $routes->post('/weather/getWeather', 'WeatherController::getWeather');

    $routes->get('/logout', 'AuthController::logout');

});

