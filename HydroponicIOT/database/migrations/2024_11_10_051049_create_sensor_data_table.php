<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorDataTable extends Migration
{
    public function up()
    {
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
            $table->float('suhu');
            $table->float('kelembapan');
            $table->float('kecerahan'); // Kolom baru untuk menyimpan nilai kecerahan
            $table->timestamp('timestamp'); // Menyimpan waktu data diambil

        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_data');
    }
}
