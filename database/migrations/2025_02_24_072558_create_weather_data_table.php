<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan'); // Nama kecamatan
            $table->decimal('latitude', 10, 6); // Koordinat
            $table->decimal('longitude', 10, 6);
            $table->date('tanggal'); // Tanggal data cuaca

            // Data cuaca
            $table->decimal('suhu_min', 5, 2)->nullable();
            $table->decimal('suhu_max', 5, 2)->nullable();
            $table->decimal('suhu_optimum', 5, 2)->nullable();

            $table->decimal('kelembapan_min', 5, 2)->nullable();
            $table->decimal('kelembapan_max', 5, 2)->nullable();
            $table->decimal('kelembapan_optimum', 5, 2)->nullable();

            $table->decimal('curah_hujan', 6, 2)->nullable(); // Curah hujan (mm)

            $table->timestamps();

            // Pastikan tidak ada duplikasi data untuk kecamatan dan tanggal yang sama
            $table->unique(['kecamatan', 'tanggal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('weather_data');
    }
};
