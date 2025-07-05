<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringCuacaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Monitoring Cuaca',
            'paragraph' => 'Pantau data cuaca secara real-time untuk menjaga kondisi optimal pada greenhouse.',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Data Cuaca'],
            ]
        ];
        $activeMenu = 'monitoringSensorDHT';

        Carbon::setLocale('id');
        $latestData = DB::table('sensor_readings')
            ->where('sensor_id', 1)
            ->orderByDesc('created_at')
            ->limit(1)
            ->get();
        $dataDHT = collect();
        foreach ($latestData as $data) {
            $payload = json_decode($data->payload, true);
            $tanggal = \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y');
            $dataDHT->push([
                'label' => 'Last Update',
                'value' => $tanggal,
                'unit' => '',
                'icon' => 'bi-calendar'
            ]);
            $dataDHT->push([
                'label' => 'Room Temperature',
                'value' => $payload['viciTemperature'] ?? null,
                'unit' => '°C',
                'icon' => 'bi-thermometer-half'
            ]);
            $dataDHT->push([
                'label' => 'Room Humidity',
                'value' => $payload['viciHumidity'] ?? null,
                'unit' => '%',
                'icon' => 'bi-droplet-half'
            ]);
            $dataDHT->push([
                'label' => 'Luminosity',
                'value' => $payload['viciLuminosity'] ?? null,
                'unit' => 'lux',
                'icon' => 'bi-brightness-high-fill'
            ]);
        }

        return view('monitoring_sensor_DHT.index', compact(
            'breadcrumb',
            'activeMenu',
            'dataDHT',
        ));
    }
}
