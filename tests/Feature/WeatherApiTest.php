<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    public function test_can_get_weather_data_with_city()
    {
        $headers = [];
        $response = $this->get('/api/v1/weather/data?city=kericho&units=metric', $headers);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_get_weather_data_without_city()
    {
        $headers = [];
        $response = $this->get('/api/v1/weather/data?units=metric', $headers);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_get_weather_forecast()
    {
        $headers = [];
        $response = $this->get('/api/v1/weather/forecast?cnt=24&units=metric', $headers);
        $response->assertStatus(Response::HTTP_OK);
    }
}
