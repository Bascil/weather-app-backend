<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetWeatherRequest;
use App\Services\WeatherApiService;
use Illuminate\Http\Response;

class WeatherController extends Controller
{
    private WeatherApiService $service;

    public function __construct(WeatherApiService $service)
    {
        $this->service = $service;
    }

    public function getWeatherData(GetWeatherRequest $request)
    {
        $response = $this->service->getWeatherData($request->validated());
        return response()->json(['data' => $response], Response::HTTP_OK);
    }
}
