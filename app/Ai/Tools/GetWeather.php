<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

use Illuminate\Support\Facades\Http;

class GetWeather implements Tool
{
    public function description(): Stringable|string
    {
        return 'Get the current weather for a given city.';
    }

    public function handle(Request $request): Stringable|string
    {
        $city = $request['city'];

        // ขั้นที่ 1: ค้นหาพิกัดจากชื่อเมือง
        $geo = Http::get(
            'https://geocoding-api.open-meteo.com/v1/search',
            [
                'name' => $city,
                'count' => 1,
                'language' => 'en',
                'format' => 'json',
            ]
        )->throw()->json();

        // ตรวจสอบว่าพบเมืองหรือไม่
        if (empty($geo['results'][0])) {
            return "ไม่พบข้อมูลเมือง {$city}";
        }

        $latitude = $geo['results'][0]['latitude'];
        $longitude = $geo['results'][0]['longitude'];

        // ขั้นที่ 2: ใช้พิกัดไปดึงข้อมูลอากาศ
        $weather = Http::get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,weather_code,wind_speed_10m',
                'timezone' => 'Asia/Bangkok',
            ]
        )->throw()->json();

        $current = $weather['current'];

        return "Weather in {$city}: "
            . "Temperature: {$current['temperature_2m']}°C, "
            . "Feels like: {$current['apparent_temperature']}°C, "
            . "Humidity: {$current['relative_humidity_2m']}%, "
            . "Precipitation: {$current['precipitation']} mm, "
            . "Wind speed: {$current['wind_speed_10m']} km/h.";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'city' => $schema->string()->required(),
            'unit' => $schema->string(),
        ];
    }
}
