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
        $response->put('flag', 0);
        $response_data = (object)$response->all();
        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch weather data'], 500);
        }
        return new WeatherResource($response_data);
    }

    public function getWeatherWithCache($city)
    {
        $city = urlencode($city);
        $apiKey = env('API_KEY');
        $apiUrl = env('API_URL') . "?q={$city}&appid={$apiKey}";
        $response = Http::get($apiUrl)->collect();
        $response->put('flag', 1);
        $response_data = (object)$response->all();
        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch weather data'], 500);
        }
        return Cache::remember("weather_{$city}", now()->addMinutes(10), function () use ($response_data) {
            return new WeatherResource($response_data);
        });
        
    }
}
