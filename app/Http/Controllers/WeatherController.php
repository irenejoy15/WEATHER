<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\WeatherResource;
use Illuminate\Support\Facades\Cache;
class WeatherController extends Controller
{
    public function getWeather($city)
    {
        $city = urlencode($city);
        $apiKey = env('API_KEY');
        $apiUrl = env('API_URL') . "?q={$city}&appid={$apiKey}";
        $response = Http::get($apiUrl)->collect();
        if (!$response->has('main') || !$response->has('weather')) {
            return response()->json(['error' => 'City not found or API error'], 404);
        }
        $response->put('flag', 0);
        $response_data = (object)$response->all();
        return new WeatherResource($response_data);
    }

    public function getWeatherWithCache($city)
    {
        $city = urlencode($city);
        $apiKey = env('API_KEY');
        $apiUrl = env('API_URL') . "?q={$city}&appid={$apiKey}";
        $response = Http::get($apiUrl)->collect();
        if (!$response->has('main') || !$response->has('weather')) {
            return response()->json(['error' => 'City not found or API error'], 404);
        }
        $response->put('flag', 1);
        $response_data = (object)$response->all();
        return Cache::remember("weather_{$city}", now()->addMinutes(10), function () use ($response_data) {
            return new WeatherResource($response_data);
        });
        
    }
}
