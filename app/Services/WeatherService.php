<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function current($lat, $lon)
    {
        $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
            'latitude'        => $lat,
            'longitude'       => $lon,
            'current_weather' => true,
            'hourly'          => 'relative_humidity_2m,apparent_temperature',
            'daily'           => 'temperature_2m_max,temperature_2m_min',
            'timezone'        => 'America/Sao_Paulo'
        ]);

        if (! $response->ok()) {
            return null;
        }

        $data = $response->json();
        $current = $data['current_weather'] ?? [];

        if (empty($current)) {
            return null;
        }

        $currentHourIndex = 0;
        if (isset($data['hourly']['time'])) {
            $index = array_search($current['time'], $data['hourly']['time']);
            if ($index !== false) {
                $currentHourIndex = $index;
            }
        }

        // Traduz o weathercode diretamente aqui
        $meta = $this->parseWeatherCode($current['weathercode'] ?? 0, (bool) ($current['is_day'] ?? 1));

        return array_merge([
            'temperature'   => round($current['temperature']),
            'windspeed'     => round($current['windspeed'], 1),
            'winddirection' => $current['winddirection'] ?? 0,
            'weathercode'   => $current['weathercode'] ?? 0,
            'is_day'        => $current['is_day'] ?? 1,
            'min'           => isset($data['daily']['temperature_2m_min'][0]) ? round($data['daily']['temperature_2m_min'][0]) : null,
            'max'           => isset($data['daily']['temperature_2m_max'][0]) ? round($data['daily']['temperature_2m_max'][0]) : null,
            'humidity'      => $data['hourly']['relative_humidity_2m'][$currentHourIndex] ?? null,
            'feels_like'    => isset($data['hourly']['apparent_temperature'][$currentHourIndex]) 
                                ? round($data['hourly']['apparent_temperature'][$currentHourIndex]) 
                                : round($current['temperature']),
        ], $meta);
    }

    /**
     * Mapeia os códigos WMO para descrição e ícone.
     */
    protected function parseWeatherCode(int $code, bool $isDay = true): array
    {
        return match (true) {
            $code === 0 => [
                'condition' => 'Céu limpo',
                'code'      => 'sunny',
                'icon'      => $isDay ? 'bi-sun-fill' : 'bi-moon-stars-fill'
            ],
            in_array($code, [1, 2, 3]) => [
                'condition' => 'Parcialmente nublado',
                'code'      => 'cloudy',
                'icon'      => $isDay ? 'bi-cloud-sun-fill' : 'bi-cloud-moon-fill'
            ],
            in_array($code, [45, 48]) => [
                'condition' => 'Nevoeiro',
                'code'      => 'fog',
                'icon'      => 'bi-cloud-fog2-fill'
            ],
            in_array($code, [51, 53, 55, 61, 63, 65, 80, 81, 82]) => [
                'condition' => 'Chuva',
                'code'      => 'rain',
                'icon'      => 'bi-cloud-rain-heavy-fill'
            ],
            in_array($code, [95, 96, 99]) => [
                'condition' => 'Tempestade',
                'code'      => 'storm',
                'icon'      => 'bi-cloud-lightning-rain-fill'
            ],
            default => [
                'condition' => 'Ensolarado',
                'code'      => 'sunny',
                'icon'      => 'bi-sun-fill'
            ]
        };
    }
}