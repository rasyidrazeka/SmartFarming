<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'paragraph' => 'Pusat informasi kondisi greenhouse Anda secara menyeluruh',
            'list' => [
                ['label' => 'Dashboard'],
            ]
        ];
        $activeMenu = 'dashboard';

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

        return view('dashboard.index', compact(
            'breadcrumb',
            'activeMenu',
            'dataDHT',
        ));
    }
}
