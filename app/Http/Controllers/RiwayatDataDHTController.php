<?php

namespace App\Http\Controllers;

use App\Models\DHTSModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RiwayatDataDHTController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Data Sensor DHT',
            'paragraph' => 'Pusat informasi kondisi greenhouse Anda secara menyeluruh',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Sensor DHT'],
            ]
        ];
        $activeMenu = 'riwayatDataDHT';
        return view('riwayat_data_DHT.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }

    // public function list(Request $request)
    // {

    //     $dhts = DHTSModel::select(['id', 'temperature', 'humidity', 'luminosity', 'sensor_id', 'created_at'])->with(['sensors'])->orderBy('created_at', 'desc');

    //     return DataTables::of($dhts)
    //         ->addIndexColumn()
    //         ->editColumn('temperature', function ($row) {
    //             return $row->temperature . ' °C';
    //         })
    //         ->editColumn('humidity', function ($row) {
    //             return $row->humidity . ' %';
    //         })
    //         ->editColumn('luminosity', function ($row) {
    //             return $row->luminosity . ' lux';
    //         })
    //         ->editColumn('created_at', function ($row) {
    //             return $row->created_at->format('d-m-Y H:i:s');
    //         })
    //         ->addColumn('sensors.sensor_name', function ($row) {
    //             return optional($row->sensors)->sensor_name;
    //         })
    //         ->make(true);
    // }

    public function list(Request $request)
    {
        $dhts = DHTSModel::select(['id', 'temperature', 'humidity', 'luminosity', 'sensor_id', 'created_at'])
            ->with(['sensors'])
            ->orderBy('created_at', 'desc');

        // ✅ Tambahkan filter tanggal jika tersedia
        if ($request->start_date && $request->end_date) {
            $dhts->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        return DataTables::of($dhts)
            ->addIndexColumn()
            ->editColumn('temperature', function ($row) {
                return $row->temperature . ' °C';
            })
            ->editColumn('humidity', function ($row) {
                return $row->humidity . ' %';
            })
            ->editColumn('luminosity', function ($row) {
                return $row->luminosity . ' lux';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->addColumn('sensors.sensor_name', function ($row) {
                return optional($row->sensors)->sensor_name;
            })
            ->make(true);
    }
}
