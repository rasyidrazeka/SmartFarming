<?php

namespace App\Http\Controllers;

use App\Models\NPKSModel;
use App\Models\SensorReadingsModel;
use App\Models\SensorsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RiwayatDataNPKController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'NPK Sensor Data History',
            'paragraph' => 'Your comprehensive greenhouse condition information center',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'NPK Sensor'],
            ]
        ];
        $activeMenu = 'riwayatDataNPK';

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

        return view('riwayat_data_NPK.index', compact(
            'breadcrumb',
            'activeMenu',
            'sensor_npk',
        ));
    }

    public function list(Request $request)
    {
        $locationId = session('selected_location_id', 1);
        $npks = DB::table('sensor_readings')
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
            ->whereIn('sensor_readings.sensor_id', [2, 3])
            ->where('locations.id', $locationId)
            ->orderBy('sensor_readings.created_at', 'desc');

        // ✅ Tambahkan filter tanggal jika tersedia
        if ($request->start_date && $request->end_date) {
            // Konversi waktu lokal ke UTC
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date . ' 00:00:00', 'Asia/Jakarta')
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date . ' 23:59:59', 'Asia/Jakarta')
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
            $npks->whereBetween('sensor_readings.created_at', [$start, $end]);
        }

        if ($request->has('selected_sensor_npk') && $request->selected_sensor_npk != '') {
            $npks->where('sensor_id', $request->selected_sensor_npk);
        }

        return DataTables::of($npks)
            ->addIndexColumn()
            ->editColumn('temperature', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilTemperature']) ? $payload['soilTemperature'] . ' °C' : 'null';
            })
            ->editColumn('humidity', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilHumidity']) ? $payload['soilHumidity'] . ' %' : 'null';
            })
            ->editColumn('conductivity', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilConductivity']) ? $payload['soilConductivity'] . ' μS/cm' : 'null';
            })
            ->editColumn('ph', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilPh']) ? $payload['soilPh'] . ' pH' : 'null';
            })
            ->editColumn('nitrogen', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilNitrogen']) ? $payload['soilNitrogen'] . ' mg/kg' : 'null';
            })
            ->editColumn('phosphorus', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilPhosphorus']) ? $payload['soilPhosphorus'] . ' mg/kg' : 'null';
            })
            ->editColumn('potassium', function ($row) {
                $payload = json_decode($row->payload, true);
                return isset($payload['soilPotassium']) ? $payload['soilPotassium'] . ' mg/kg' : 'null';
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s');
            })
            ->addColumn('sensors.public_name', function ($row) {
                return 'Sensor ' . $row->sensor_public_name;
            })
            ->make(true);
    }

    public function storeFilter(Request $request)
    {
        $request->session()->put('selected_sensor', $request->input('selected_sensor_npk'));
        return redirect()->route('riwayatDataNPK.index');
    }
}
