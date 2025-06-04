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
            'title' => 'Monitoring Sensor DHT',
            'paragraph' => 'Pantau data sensor secara real-time untuk menjaga kondisi optimal pada greenhouse.',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Sensor DHT'],
            ]
        ];
        $activeMenu = 'monitoringSensorDHT';

        Carbon::setLocale('id');
        $latestData = DB::table('dhts')
            ->latest('created_at')
            ->take(1) // ambil data terbaru saja
            ->get();
        $dataDHT = collect();
        foreach ($latestData as $data) {
            $tanggal = \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y');
            $dataDHT->push([
                'label' => 'Last Update',
                'value' => $tanggal,
                'unit' => '',
                'icon' => 'bi-calendar'
            ]);
            $dataDHT->push([
                'label' => 'Room Temperature',
                'value' => $data->temperature,
                'unit' => '°C',
                'icon' => 'bi-thermometer-half'
            ]);
            $dataDHT->push([
                'label' => 'Room Humidity',
                'value' => $data->humidity,
                'unit' => '%',
                'icon' => 'bi-droplet-half'
            ]);
            $dataDHT->push([
                'label' => 'Luminosity',
                'value' => $data->luminosity,
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
