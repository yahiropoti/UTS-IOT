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
            $table->float('ph')->nullable(); // Menambahkan kolom pH
            $table->float('kekeruhan')->nullable(); // Menambahkan kolom kekeruhan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_data');
    }
}
