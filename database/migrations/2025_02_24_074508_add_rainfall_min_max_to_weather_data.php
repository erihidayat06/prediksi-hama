<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->float('curah_hujan_min')->nullable()->after('curah_hujan');
            $table->float('curah_hujan_max')->nullable()->after('curah_hujan_min');
        });
    }

    public function down()
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->dropColumn(['curah_hujan_min', 'curah_hujan_max']);
        });
    }
};
