<?php

namespace App\Http\Controllers;

use App\Models\CuacaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RiwayatDataCuacaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Weather Forecast History',
            'paragraph' => 'Analyze previous weather forecasts to evaluate accuracy, understand climate patterns, and improve future planning.',
            'list' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.index')],
                ['label' => 'Weather History Forecast'],
            ]
        ];
        $activeMenu = 'riwayatDataCuaca';
        return view('riwayat_data_cuaca.index', compact(
            'breadcrumb',
            'activeMenu',
        ));
    }

    public function list(Request $request)
    {
        $locationId = session('selected_location_id', 1);
        $cuaca = DB::table('weather_data')
            ->select('id', 'time', 'temperature_2m', 'weather_code', 'cloud_cover', 'wind_speed_10m')
            ->where('location_id', $locationId)
            ->orderBy('time', 'desc');

        // ✅ Tambahkan filter tanggal jika tersedia
        if ($request->start_date && $request->end_date) {
            $startUtc = Carbon::parse($request->start_date . ' 00:00:00', 'Asia/Jakarta')->setTimezone('UTC');
            $endUtc = Carbon::parse($request->end_date . ' 23:59:59', 'Asia/Jakarta')->setTimezone('UTC');

            $cuaca->whereBetween('time', [$startUtc, $endUtc]);
        }

        $weatherDescriptions = [
            0 => 'Clear',
            1 => 'Mostly clear',
            2 => 'Cloudy',
            3 => 'Overcast',
            45 => 'Fog',
            48 => 'Freezing fog',
            51 => 'Light drizzle',
            53 => 'Moderate drizzle',
            55 => 'Heavy drizzle',
            56 => 'Freezing drizzle',
            57 => 'Heavy freezing drizzle',
            61 => 'Light rain',
            63 => 'Rain',
            65 => 'Heavy rain',
            66 => 'Light freezing rain',
            67 => 'Freezing rain',
            71 => 'Light snow',
            73 => 'Snow',
            75 => 'Heavy snow',
            77 => 'Snow grains',
            80 => 'Rain showers',
            81 => 'Short rain showers',
            82 => 'Heavy rain showers',
            85 => 'Snow showers',
            86 => 'Heavy snow showers',
            95 => 'Thunderstorm',
            96 => 'Thunderstorm with light hail',
            99 => 'Thunderstorm with heavy hail',
        ];

        return DataTables::of($cuaca)
            ->addIndexColumn()

            // Ambil temperature dari payload
            ->editColumn('temperature_2m', function ($row) {
                return ($row->temperature_2m ?? 'null') . ' °C';
            })

            // Ambil humidity dari payload
            ->editColumn('cloud_cover', function ($row) {
                return ($row->cloud_cover ?? 'null') . ' %';
            })

            // Ambil luminosity dari payload
            ->editColumn('wind_speed_10m', function ($row) {
                return ($row->wind_speed_10m ?? 'null') . ' km/h';
            })

            // Format tanggal
            ->editColumn('time', function ($row) {
                return Carbon::parse($row->time)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s');
            })

            ->editColumn('weather_code', function ($row) use ($weatherDescriptions) {
                return $weatherDescriptions[$row->weather_code] ?? 'Tidak diketahui';
            })

            ->make(true);
    }
}
