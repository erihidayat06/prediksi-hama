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
        $schedule->command('fetch:harga-pangan')
            ->dailyAt('00:10')
            ->timezone('Asia/Jakarta'); // Jalankan setiap hari jam 00:10 WIB

        $schedule->command('weather:update')
            ->dailyAt('00:10')
            ->timezone('Asia/Jakarta'); // Jalankan setiap hari jam 00:10 WIB

        $schedule->command('cuaca:kirim-peringatan')
            ->twiceMonthly(1, 15, '08:00') // Tanggal 1 dan 15 jam 08:00 WIB
            ->timezone('Asia/Jakarta');
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
