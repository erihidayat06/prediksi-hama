<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('fetch:harga-pangan')->dailyAt('00:10'); // Jalankan setiap hari jam 00:10
        $schedule->command('weather:update')->dailyAt('00:10'); // Ambil data setiap hari jam 00:10
        $schedule->command('cuaca:kirim-peringatan')->twiceMonthly(1, 15, '00:00'); // Tanggal 1 dan 15 setiap bulan
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
