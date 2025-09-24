<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringSensorDHTController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Pemantauan Sensor DHT',
            'paragraph' => 'Pantau data sensor secara real-time untuk menjaga kondisi optimal pada greenhouse.',
            'list' => [
                ['label' => 'Dasbor', 'url' => route('dashboard.index')],
                ['label' => 'Sensor DHT'],
            ]
        ];
        $activeMenu = 'monitoringSensorDHT';

        $locationId = session('selected_location_id', 1);
        Carbon::setLocale('id');
        $latestData = DB::table('sensor_readings')
            ->select(
                'sensor_readings.id',
                'sensor_readings.payload',
                'sensor_readings.sensor_id',
                'sensor_readings.created_at',
                'sensors.name as sensor_name',
                'sensors.public_name as sensor_public_name'
            )
            ->join('sensors', 'sensor_readings.sensor_id', '=', 'sensors.id')
            ->join('bed_locations', 'sensors.bed_location_id', '=', 'bed_locations.id')
            ->join('locations', 'bed_locations.location_id', '=', 'locations.id')
            ->where('sensor_readings.sensor_id', 1)
            ->where('locations.id', $locationId)
            ->orderByDesc('sensor_readings.created_at')
            ->limit(1)
            ->get();
        $dataDHT = collect();

        foreach ($latestData as $data) {
            $payload = json_decode($data->payload, true);
            $createdAt = Carbon::parse($data->created_at)->timezone('Asia/Jakarta');
            $jamMenit = $createdAt->format('H:i');

            $dataDHT->push([
                'label' => 'Latest Update',
                'value' => $jamMenit,
                'unit' => '',
                'icon' => 'bi-calendar'
            ]);

            $dataDHT->push([
                'label' => 'Room Temperature',
                'value' => $payload['viciTemperature'] ?? '-',
                'unit' => '°C',
                'icon' => 'bi-thermometer-half'
            ]);

            $dataDHT->push([
                'label' => 'Room Humidity',
                'value' => $payload['viciHumidity'] ?? '-',
                'unit' => '%',
                'icon' => 'bi-droplet-half'
            ]);

            $dataDHT->push([
                'label' => 'Light Density',
                'value' => $payload['viciLuminosity'] ?? '-',
                'unit' => 'lux',
                'icon' => 'bi-brightness-high-fill'
            ]);
        }

        return view('monitoring_sensor_DHT.index', compact(
            'breadcrumb',
            'activeMenu',
            'dataDHT',
            'locationId'
        ));
    }
}
