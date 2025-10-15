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
            'title' => 'NPK Sensor Monitoring',
            'paragraph' => 'Monitor nitrogen, phosphorus, and potassium to maintain optimal soil fertility and support healthy plant growth.',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'NPK Sensor'],
            ]
        ];
        $activeMenu = 'monitoringSensorNPK';

        $locationId = session('selected_location_id', 1);
        $sensor_npk = DB::table('sensors')
            ->join('sensor_readings', 'sensors.id', '=', 'sensor_readings.sensor_id')
            ->join('bed_locations', 'sensors.bed_location_id', '=', 'bed_locations.id')
            ->join('locations', 'bed_locations.location_id', '=', 'locations.id')
            ->whereIn('sensor_readings.sensor_id', [2, 3])
            ->where('locations.id', $locationId)
            ->select('sensors.id', 'sensors.public_name')
            ->distinct()
            ->get();
        $selectedSensor = $request->input('selected_sensor_npk');
        session(['selected_sensor_npk' => $selectedSensor]);

        Carbon::setLocale('id');
        if ($selectedSensor) {
            $latestData = collect([
                DB::table('sensor_readings')
                    ->join('sensors', 'sensor_readings.sensor_id', '=', 'sensors.id')
                    ->join('bed_locations', 'sensors.bed_location_id', '=', 'bed_locations.id')
                    ->join('locations', 'bed_locations.location_id', '=', 'locations.id')
                    ->where('sensor_readings.sensor_id', $selectedSensor)
                    ->where('locations.id', $locationId)
                    ->select(
                        'sensor_readings.*',
                        'sensors.public_name as sensor_name',
                        'locations.public_name as location_name'
                    )
                    ->latest('sensor_readings.created_at')
                    ->first()
            ]);
        } else {
            $latestData = collect([
                DB::table('sensor_readings')
                    ->join('sensors', 'sensor_readings.sensor_id', '=', 'sensors.id')
                    ->join('bed_locations', 'sensors.bed_location_id', '=', 'bed_locations.id')
                    ->join('locations', 'bed_locations.location_id', '=', 'locations.id')
                    ->whereIn('sensor_readings.sensor_id', [2, 3])
                    ->where('locations.id', $locationId)
                    ->select(
                        'sensor_readings.*',
                        'sensors.public_name as sensor_name',
                        'locations.public_name as location_name'
                    )
                    ->latest('sensor_readings.created_at')
                    ->first()
            ]);
        }
        $dataNPK = collect();
        foreach ($latestData as $data) {
            if ($data === null) {
                continue;
            }
            $payload = json_decode($data->payload, true);
            $createdAt = Carbon::parse($data->created_at)->timezone('Asia/Jakarta');
            $jamMenit = $createdAt->format('H:i');
            $dataNPK->push([
                'label' => 'Latest Update',
                'value' => $jamMenit,
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
            'locationId'
        ));
    }

    public function storeFilter(Request $request)
    {
        $request->session()->put('selected_sensor', $request->input('selected_sensor_npk'));
        return redirect()->route('monitoringSensorNPK.index');
    }
}
