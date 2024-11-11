<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataController;

// Route untuk mendapatkan data sensor
Route::get('/sensor-data', [SensorDataController::class, 'getSensorData']);

// Route untuk menyimpan data sensor
Route::post('/sensor-data', [SensorDataController::class, 'store']);
