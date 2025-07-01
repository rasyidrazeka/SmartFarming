<?php

namespace App\Http\Controllers;

use App\Models\SensorsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringSensorNPKController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Monitoring Sensor NPK',
            'paragraph' => 'Pantau data sensor secara real-time untuk menjaga kondisi optimal pada greenhouse.',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Sensor NPK'],
            ]
        ];
        $activeMenu = 'monitoringSensorNPK';

        $sensor_npk = SensorsModel::whereNotNull('bed_location_id')->get();
        $selectedSensor = $request->input('selected_sensor_npk');
        session(['selected_sensor_npk' => $selectedSensor]);

        Carbon::setLocale('id');
        if ($selectedSensor) {
            $latestData = DB::table('sensor_readings')
                ->where('sensor_id', $selectedSensor)
                ->latest('created_at')
                ->take(1) // ambil data terbaru saja
                ->get();
        } else {
            $latestData = DB::table('sensor_readings')
                ->whereIn('sensor_id', [1, 2]) // ambil sensor_id 1 dan 2
                ->orderByDesc('created_at')    // urutkan dari yang terbaru
                ->limit(1)                     // ambil data terbaru
                ->get();
        }
        $dataNPK = collect();
        foreach ($latestData as $data) {
            $payload = json_decode($data->payload, true);
            $tanggal = \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y');
            $dataNPK->push([
                'label' => 'Last Update',
                'value' => $tanggal,
                'unit' => '',
                'icon' => 'bi-calendar'
            ]);
            $dataNPK->push([
                'label' => 'Soil Temperature',
                'value' => $payload['soilTemperature'] ?? null,
                'unit' => '°C',
                'icon' => 'bi-thermometer-half'
            ]);
            $dataNPK->push([
                'label' => 'Soil Humidity',
                'value' => $payload['soilHumidity'] ?? null,
                'unit' => '%',
                'icon' => 'bi-droplet-half'
            ]);
            $dataNPK->push([
                'label' => 'Soil Conductivity',
                'value' => $payload['soilConductivity'] ?? null,
                'unit' => 'μS/cm',
                'icon' => 'bi-lightning'
            ]);
            $dataNPK->push([
                'label' => 'Soil pH',
                'value' => $payload['soilPh'] ?? null,
                'unit' => 'pH',
                'icon' => 'bi-speedometer'
            ]);
            $dataNPK->push([
                'label' => 'Soil Nitrogen',
                'value' => $payload['soilNitrogen'] ?? null,
                'unit' => 'mg/kg',
                'icon' => 'bi-droplet-half'
            ]);
            $dataNPK->push([
                'label' => 'Soil Phosphorus',
                'value' => $payload['soilPhosphorus'] ?? null,
                'unit' => 'mg/kg',
                'icon' => 'bi-capsule'
            ]);
            $dataNPK->push([
                'label' => 'Soil Potassium',
                'value' => $payload['soilPotassium'] ?? null,
                'unit' => 'mg/kg',
                'icon' => 'bi-shield-check'
            ]);
        }
        return view('monitoring_sensor_npk.index', compact(
            'breadcrumb',
            'activeMenu',
            'sensor_npk',
            'selectedSensor',
            'dataNPK',
        ));
    }

    public function storeFilter(Request $request)
    {
        $request->session()->put('selected_sensor', $request->input('selected_sensor_npk'));
        return redirect()->route('monitoringSensorNPK.index');
    }
}
