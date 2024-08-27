<?php

namespace App\Services;

/**
 * Class WeatherApiService.
 */
class WeatherApiService
{
    private $baseUri;
    private $apiKey;

    // initialize data with constructors
    public function __construct()
    {
        $this->baseUri = env("WEATHER_API_ENDPOINT");
        $this->apiKey = env("WEATHER_API_KEY");
    }

    /**
     * getWeatherData
     *
     * @param  mixed $attributes
     * @return void
     */
    public function getWeatherData(array $attributes)
    {
        $params = [
            'q' => $attributes['city'],
            'units' => $attributes['units'],
        ];

        return $this->callApi('/weather', $params);
    }

    /**
     * callApi
     *
     * @param  mixed $endpoint
     * @param  mixed $params
     * @return void
     */
    private function callApi(string $endpoint, array $params = [])
    {
        $url = $this->buildApiUrl($endpoint, $params);
        return $this->submitGetRequest($url);
    }

    /**
     * buildApiUrl
     *
     * @param  mixed $endpoint
     * @param  mixed $params
     * @return string
     */
    private function buildApiUrl(string $endpoint, array $params = []): string
    {
        $baseUrl = $this->baseUri . $endpoint;
        $queryParams = http_build_query(array_merge(['appid' => $this->apiKey], $params));
        return $baseUrl . '?' . $queryParams;
    }

    /**
     * submitGetRequest
     *
     * @param  mixed $endpoint
     * @return void
     */
    private function submitGetRequest($endpoint)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
}
