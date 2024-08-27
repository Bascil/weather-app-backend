<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/weather')->group(function (Router $router) {
    $router->get('/data', [WeatherController::class, 'getWeatherData']);
    $router->get('/forecast', [WeatherController::class, 'getWeatherForecast']);
});

// perform a health check, evaluating the status of targeted services,
Route::get('/health-check', fn() => Response::noContent())->name('health-check');
