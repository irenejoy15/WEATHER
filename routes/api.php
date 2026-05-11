<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/weather/{city}', [WeatherController::class, 'getWeather']);
Route::get('/weather/{city}/cache', [WeatherController::class, 'getWeatherWithCache']);
