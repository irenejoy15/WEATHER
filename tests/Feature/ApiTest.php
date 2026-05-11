<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_weather_api()
    {
        $response = $this->getJson('/api/weather/Manila');
        $response->assertJson($response->json());
    }

    public function test_get_weather_api_cache()
    {
        $response = $this->getJson('/api/weather/Manila/cache');
        $response->assertJson($response->json());
    }
}
