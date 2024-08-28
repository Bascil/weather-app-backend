<?php

namespace Tests\Feature;

use App\Services\WeatherApiService;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use Tests\TestCase;

class WeatherApiTest extends TestCase
{
    public function test_can_get_weather_data_with_city()
    {
        $headers = [];

        $this->instance(
            WeatherApiService::class,
            \Mockery::mock(WeatherApiService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getWeatherData')
                    ->once();
            })
        );

        $response = $this->get('/api/v1/weather/data?city=kericho&units=metric', $headers);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_get_weather_data_without_city()
    {
        $headers = [];

        $this->instance(
            WeatherApiService::class,
            \Mockery::mock(WeatherApiService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getWeatherData')
                    ->once();
            })
        );

        $response = $this->get('/api/v1/weather/data?units=metric', $headers);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_can_get_weather_forecast()
    {
        $headers = [];

        $this->instance(
            WeatherApiService::class,
            \Mockery::mock(WeatherApiService::class, function (MockInterface $mock) {
                $mock->shouldReceive('getWeatherForecast')
                    ->once();
            })
        );

        $response = $this->get('/api/v1/weather/forecast?cnt=24&units=metric', $headers);
        $response->assertStatus(Response::HTTP_OK);
    }
}
