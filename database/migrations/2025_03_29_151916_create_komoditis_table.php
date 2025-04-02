<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('komoditis', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal');
            $table->string('nama_provinsi');
            $table->integer('harga_provinsi');
            $table->foreignId('tanaman_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komoditis');
    }
};
