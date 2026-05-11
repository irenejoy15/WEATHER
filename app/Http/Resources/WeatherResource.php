<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class WeatherResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->withoutWrapping();
    }
    public function toArray(Request $request): array
    {
        return [
            'city' => $this->name,
            //Convert temperature from Kelvin to Celsius
            'temperature' => $this->main['temp'] - 273.15 . ' C',
            'weather_description' => $this->weather[0]['description'],   
            // YMD H:i a format 
            'timestamp' => Carbon::now()->format('Y-m-d H:i a'),
            'source' => $this->flag == 0 ? 'external' : 'cache',
        ];
    }
}
