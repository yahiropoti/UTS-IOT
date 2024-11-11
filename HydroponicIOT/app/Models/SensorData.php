<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'sensor_data';

    // Kolom-kolom yang bisa diisi
    protected $fillable = [
        'suhu', 'kelembapan', 'ph', 'kekeruhan',
    ];
}
