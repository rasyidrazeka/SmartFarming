<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'paragraph' => 'Welcome to the Smart Farming Monitoring System. Visualize sensor and weather data to support precision agriculture.',
            'list' => [
                ['label' => 'Dashboard'],
            ]
        ];
        $activeMenu = 'dashboard';
        $locationId = session('selected_location_id', 1);
        $nowJakarta = Carbon::now('Asia/Jakarta');
        $nowUtc = $nowJakarta->copy()->setTimezone('UTC');
        $latestData = DB::table('weather_now')
            ->where('location_id', $locationId)
            ->whereDate('time', $nowUtc->toDateString()) // tanggal dalam UTC
            ->whereTime('time', '<=', $nowUtc->format('H:i:s')) // waktu dalam UTC
            ->orderByDesc('time')
            ->first();

        $weatherDescriptions = [
            0 => 'Clear',
            1 => 'Mostly clear',
            2 => 'Cloudy',
            3 => 'Overcast',
            45 => 'Fog',
            48 => 'Freezing fog',
            51 => 'Light drizzle',
            53 => 'Moderate drizzle',
            55 => 'Heavy drizzle',
            56 => 'Freezing drizzle',
            57 => 'Heavy freezing drizzle',
            61 => 'Light rain',
            63 => 'Rain',
            65 => 'Heavy rain',
            66 => 'Light freezing rain',
            67 => 'Freezing rain',
            71 => 'Light snow',
            73 => 'Snow',
            75 => 'Heavy snow',
            77 => 'Snow grains',
            80 => 'Rain showers',
            81 => 'Short rain showers',
            82 => 'Heavy rain showers',
            85 => 'Snow showers',
            86 => 'Heavy snow showers',
            95 => 'Thunderstorm',
            96 => 'Thunderstorm with light hail',
            99 => 'Thunderstorm with heavy hail',
        ];

        $weatherIcons = [
            // Cerah
            0 => 'bi-sun-fill',
            1 => 'bi-sun-fill',
            2 => 'bi-cloud-sun-fill',
            3 => 'bi-cloud-fill',

            // Kabut
            45 => 'bi-cloud-fog2-fill',
            48 => 'bi-cloud-fog2-fill',

            // Gerimis
            51 => 'bi-cloud-drizzle-fill',
            53 => 'bi-cloud-drizzle-fill',
            55 => 'bi-cloud-drizzle-fill',
            56 => 'bi-cloud-drizzle-fill',
            57 => 'bi-cloud-drizzle-fill',

            // Hujan
            61 => 'bi-cloud-rain-fill',
            63 => 'bi-cloud-rain-fill',
            65 => 'bi-cloud-rain-fill',
            66 => 'bi-cloud-rain-fill',
            67 => 'bi-cloud-rain-fill',
            80 => 'bi-cloud-rain-fill',
            81 => 'bi-cloud-rain-fill',
            82 => 'bi-cloud-rain-heavy-fill',

            // Salju
            71 => 'bi-cloud-snow-fill',
            73 => 'bi-cloud-snow-fill',
            75 => 'bi-cloud-snow-fill',
            77 => 'bi-cloud-snow-fill',
            85 => 'bi-cloud-snow-fill',
            86 => 'bi-cloud-snow-fill',

            // Petir
            95 => 'bi-cloud-lightning-fill',
            96 => 'bi-cloud-lightning-rain-fill',
            99 => 'bi-cloud-lightning-rain-fill',
        ];

        $weatherData = collect();

        if ($latestData) {
            $deskripsiCuaca = $weatherDescriptions[$latestData->weather_code] ?? 'Unknown';
            $ikonCuaca = $weatherIcons[$latestData->weather_code] ?? 'bi-question-circle-fill';

            if ($latestData->temperature_2m <= 20) {
                $ikonSuhu = 'bi-thermometer-snow';
            } elseif ($latestData->temperature_2m <= 30) {
                $ikonSuhu = 'bi-thermometer-half';
            } else {
                $ikonSuhu = 'bi-thermometer-sun';
            }

            $weatherData->push([
                'label' => 'Temperature',
                'value' => $latestData->temperature_2m,
                'unit' => '°C',
                'icon' => 'bi ' . $ikonSuhu
            ]);
            $weatherData->push([
                'label' => 'Cloud Cover',
                'value' => $latestData->cloud_cover,
                'unit' => '%',
                'icon' => 'bi bi-clouds-fill'
            ]);
            $weatherData->push([
                'label' => 'Wind Speed',
                'value' => $latestData->wind_speed_10m,
                'unit' => 'km/h',
                'icon' => 'bi bi-wind'
            ]);
            $weatherData->push([
                'label' => 'Weather',
                'value' => $deskripsiCuaca,
                'unit' => '',
                'icon' => 'bi ' . $ikonCuaca
            ]);
        }

        return view('dashboard.index', compact(
            'breadcrumb',
            'activeMenu',
            'weatherData',
            'locationId'
        ));
    }
}
