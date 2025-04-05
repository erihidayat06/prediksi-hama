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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->text('gambar');
            $table->string('judul');
            $table->string('no_tlp');
            $table->string('harga');
            $table->string('satuan');
            $table->text('kecamatan');
            $table->text('desa');
            $table->text('alamat');
            $table->text('deskripsi');
            $table->string('slug');
            $table->boolean('aktive')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
