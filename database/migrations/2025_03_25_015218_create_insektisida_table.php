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
        Schema::create('insektisidas', function (Blueprint $table) {
            $table->id();
            $table->string('nm_insektisida');
            $table->text('cross_resistens');
            $table->text('saran_insektisida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insektisidas');
    }
};
