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

        $sensor_npk = SensorsModel::where('table_id', 2)->get();
        $selectedSensor = $request->input('selected_sensor_npk');
        session(['selected_sensor_npk' => $selectedSensor]);

        Carbon::setLocale('id');
        if ($selectedSensor) {
            $latestData = DB::table('npks')
                ->where('sensor_id', $selectedSensor)
                ->latest('created_at')
                ->take(1) // ambil data terbaru saja
                ->get();
        } else {
            $latestData = DB::table('npks')
                ->latest('created_at')
                ->take(1) // ambil data terbaru saja
                ->get();
        }
        $dataNPK = collect();
        foreach ($latestData as $data) {
            $tanggal = \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y');
            $dataNPK->push([
                'label' => 'Last Update',
                'value' => $tanggal,
                'unit' => '',
                'icon' => 'bi-calendar'
            ]);
            $dataNPK->push([
                'label' => 'Soil Temperature',
                'value' => $data->temperature,
                'unit' => '°C',
                'icon' => 'bi-thermometer-half'
            ]);
            $dataNPK->push([
                'label' => 'Soil Humidity',
                'value' => $data->humidity,
                'unit' => '%',
                'icon' => 'bi-droplet-half'
            ]);
            $dataNPK->push([
                'label' => 'Soil Conductivity',
                'value' => $data->conductivity,
                'unit' => 'μS/cm',
                'icon' => 'bi-lightning'
            ]);
            $dataNPK->push([
                'label' => 'Soil pH',
                'value' => $data->ph,
                'unit' => 'pH',
                'icon' => 'bi-speedometer'
            ]);
            $dataNPK->push([
                'label' => 'Soil Nitrogen',
                'value' => $data->nitrogen,
                'unit' => 'mg/kg',
                'icon' => 'bi-droplet-half'
            ]);
            $dataNPK->push([
                'label' => 'Soil Phosphorus',
                'value' => $data->phosphorus,
                'unit' => 'mg/kg',
                'icon' => 'bi-capsule'
            ]);
            $dataNPK->push([
                'label' => 'Soil Potassium',
                'value' => $data->potassium,
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
