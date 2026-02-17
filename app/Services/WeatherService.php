<?php

namespace App\Services;

class WeatherService
{
    /**
     * Get weather data manually (user input).
     * Сейчас просто возвращает данные как есть
     */
    public function getManual(array $data): array
    {
        return [
            'temperature' => $data['temperature'] ?? null,
            'weather_condition' => $data['weather_condition'] ?? null,
            'wind_speed' => $data['wind_speed'] ?? null,
            'pressure' => $data['pressure'] ?? null,
            'humidity' => $data['humidity'] ?? null,
            'weather_source' => 'manual',
        ];
    }

    /**
     * Get weather from API (future implementation).
     * В будущем здесь будет запрос к OpenWeatherMap API
     */
    public function getFromApi(string $date, float $latitude, float $longitude): array
    {
        // TODO: Подключить OpenWeatherMap API
        // $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
        //     'lat' => $latitude,
        //     'lon' => $longitude,
        //     'dt' => strtotime($date),
        //     'appid' => config('services.openweather.key'),
        //     'units' => 'metric',
        // ]);
        //
        // return [
        //     'temperature' => $response['main']['temp'],
        //     'weather_condition' => $response['weather'][0]['main'],
        //     'wind_speed' => $response['wind']['speed'],
        //     'pressure' => $response['main']['pressure'],
        //     'humidity' => $response['main']['humidity'],
        //     'weather_source' => 'api',
        // ];

        // Пока возвращаем пустой массив
        return [];
    }
}
