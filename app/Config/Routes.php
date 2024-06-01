<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/weather', 'WeatherController::view');
$routes->post('/weather/getWeather', 'WeatherController::getWeather');
