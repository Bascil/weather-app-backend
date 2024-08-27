<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/weather')->group(function (Router $router) {
    $router->get('/data', [WeatherController::class, 'getWeatherData']);
});
