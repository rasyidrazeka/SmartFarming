<?php

namespace App\Http\Controllers;

use App\Models\DHTSModel;
use App\Models\SensorReadingsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RiwayatDataDHTController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Data Sensor DHT',
            'paragraph' => 'Pusat informasi kondisi greenhouse Anda secara menyeluruh',
            'list' => [
                ['label' => 'Dasbor', 'url' => route('dashboard.index')],
                ['label' => 'Sensor DHT'],
            ]
        ];
        $activeMenu = 'riwayatDataDHT';
        return view('riwayat_data_DHT.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }

    public function list(Request $request)
    {
        $locationId = session('selected_location_id', 1);
        $dhts = DB::table('sensor_readings')
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
            ->orderBy('sensor_readings.created_at', 'desc');

        // ✅ Filter tanggal jika tersedia
        if ($request->start_date && $request->end_date) {
            // Konversi waktu lokal ke UTC
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date . ' 00:00:00', 'Asia/Jakarta')
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date . ' 23:59:59', 'Asia/Jakarta')
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
            $dhts->whereBetween('sensor_readings.created_at', [$start, $end]);
        }

        return DataTables::of($dhts)
            ->addIndexColumn()

            // ✅ Ambil temperature dari payload JSON
            ->addColumn('temperature', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['viciTemperature']) ? $payload['viciTemperature'] . ' °C' : 'null';
            })

            // ✅ Ambil humidity
            ->addColumn('humidity', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['viciHumidity']) ? $payload['viciHumidity'] . ' %' : 'null';
            })

            // ✅ Ambil luminosity
            ->addColumn('luminosity', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['viciLuminosity']) ? $payload['viciLuminosity'] . ' lux' : 'null';
            })

            // ✅ Format tanggal
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s');
            })

            // ✅ Public name sensor langsung dari query
            ->addColumn('sensors.public_name', function ($row) {
                return 'Sensor ' . $row->sensor_public_name ?? '-';
            })

            ->make(true);
    }
}
