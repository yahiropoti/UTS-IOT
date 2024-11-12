<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    protected $table = 'sensor_data';

    protected $fillable = [
        'suhu', 'kelembapan', 'kecerahan', 'timestamp', 'created_at', 'updated_at'
    ];

    public $timestamps = false; // Tambahkan ini untuk mematikan timestamp otomatis
}
