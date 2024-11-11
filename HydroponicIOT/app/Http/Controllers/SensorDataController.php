<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    // Metode untuk mendapatkan data sensor
    public function getSensorData()
    {
        // Mengambil semua data dari model SensorData
        $data = SensorData::all();

        // Mengembalikan data dalam format JSON
        return response()->json($data);
    }

    // Metode untuk menyimpan data sensor
    public function store(Request $request)
    {
        // Validasi input agar semua kolom diperlukan
        $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'ph' => 'required|numeric',
            'kekeruhan' => 'required|numeric',
        ]);

        // Menyimpan data sensor ke database
        $sensorData = SensorData::create([
            'suhu' => $request->input('suhu'),
            'kelembapan' => $request->input('kelembapan'),
            'ph' => $request->input('ph'),
            'kekeruhan' => $request->input('kekeruhan'),
        ]);

        return response()->json(['message' => 'Data saved successfully!', 'data' => $sensorData]);
    }
}
