<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('monitoring_sensor_DHT.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }
}
