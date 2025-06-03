<?php

namespace App\Http\Controllers;

use App\Models\NPKSModel;
use App\Models\SensorsModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatDataNPKController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Data Sensor NPK',
            'paragraph' => 'Pusat informasi kondisi greenhouse Anda secara menyeluruh',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Sensor NPK'],
            ]
        ];
        $activeMenu = 'riwayatDataNPK';

        $sensor_npk = SensorsModel::where('table_id', 2)->get();
        $selectedSensor = $request->input('selected_sensor_npk');
        session(['selected_sensor_npk' => $selectedSensor]);

        return view('riwayat_data_NPK.index', compact(
            'breadcrumb',
            'activeMenu',
            'sensor_npk',
        ));
    }

    public function list(Request $request)
    {
        $npks = NPKSModel::select(['id', 'temperature', 'humidity', 'conductivity', 'ph', 'nitrogen', 'phosphorus', 'potassium', 'created_at', 'read_at', 'sensor_id'])
            ->with(['sensors'])
            ->orderBy('created_at', 'desc');

        // ✅ Tambahkan filter tanggal jika tersedia
        if ($request->start_date && $request->end_date) {
            $npks->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        if ($request->has('selected_sensor_npk') && $request->selected_sensor_npk != '') {
            $npks->where('sensor_id', $request->selected_sensor_npk);
        }

        return DataTables::of($npks)
            ->addIndexColumn()
            ->editColumn('temperature', function ($row) {
                return $row->temperature . ' °C';
            })
            ->editColumn('humidity', function ($row) {
                return $row->humidity . ' %';
            })
            ->editColumn('conductivity', function ($row) {
                return $row->conductivity . ' lux';
            })
            ->editColumn('ph', function ($row) {
                return $row->ph . ' lux';
            })
            ->editColumn('nitrogen', function ($row) {
                return $row->nitrogen . ' lux';
            })
            ->editColumn('phosphorus', function ($row) {
                return $row->phosphorus . ' lux';
            })
            ->editColumn('potassium', function ($row) {
                return $row->potassium . ' lux';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('sensors.sensor_name', function ($row) {
                return optional($row->sensors)->sensor_name;
            })
            ->make(true);
    }

    public function storeFilter(Request $request)
    {
        $request->session()->put('selected_sensor', $request->input('selected_sensor_npk'));
        return redirect()->route('riwayatDataNPK.index');
    }
}
