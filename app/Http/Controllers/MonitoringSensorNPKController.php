<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringSensorNPKController extends Controller
{
    public function index()
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
        return view('monitoring_sensor_npk.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }
}
