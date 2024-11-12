<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    public function getSensorData()
    {
        // Ambil semua data dari database
        $data = SensorData::all();

        // Hitung nilai max, min, dan rata-rata suhu dari seluruh data
        $suhumax = $data->max('suhu');
        $suhumin = $data->min('suhu');
        $suhurata = $data->avg('suhu');

        // Ambil semua data yang memiliki suhu maksimum
        $nilai_suhu_max_humid_max = $data->filter(function ($item) use ($suhumax) {
            return $item->suhu === $suhumax;
        })->map(function ($item) {
            return [
                'idx' => $item->id,
                'suhun' => $item->suhu,
                'humid' => $item->kelembapan,
                'kecerahan' => $item->kecerahan,
                'timestamp' => $item->timestamp
            ];
        })->values();

        // Buat array untuk month_year_max berdasarkan bulan dan tahun dari timestamp pada data suhu maksimum
        $month_year_max = $nilai_suhu_max_humid_max->map(function ($item) {
            return [
                'month_year' => Carbon::parse($item['timestamp'])->format('n-Y')
            ];
        })->unique()->values();

        // Format semua data untuk ditampilkan
        $all_data = $data->map(function ($item) {
            return [
                'idx' => $item->id,
                'suhun' => $item->suhu,
                'humid' => $item->kelembapan,
                'kecerahan' => $item->kecerahan,
                'timestamp' => $item->timestamp
            ];
        });

        // Kembalikan response JSON
        return response()->json([
            'suhumax' => $suhumax,
            'suhumin' => $suhumin,
            'suhurata' => round($suhurata, 2),
            'nilai_suhu_max_humid_max' => $nilai_suhu_max_humid_max,
            'all_data' => $all_data,
            'month_year_max' => $month_year_max
        ]);
    }
}


