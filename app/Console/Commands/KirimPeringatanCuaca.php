<?php

namespace App\Console\Commands;

use App\Http\Controllers\CuacaController;
use Illuminate\Console\Command;
use App\Mail\PerubahanCuacaMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\Home\PetaController;

class KirimPeringatanCuaca extends Command
{
    protected $signature = 'cuaca:kirim-peringatan';
    protected $description = 'Mengirim peringatan perubahan warna cuaca setiap dua minggu sekali';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Panggil metode dari controller yang membandingkan data
        $controller = new CuacaController();
        $perbandinganWarna = $controller->bandingkanDataCuaca();

        if (!empty($perbandinganWarna)) {
            $users = User::pluck('email')->toArray();

            foreach ($users as $email) {
                Mail::to($email)->send(new PerubahanCuacaMail($perbandinganWarna));
            }

            $this->info('Email peringatan cuaca berhasil dikirim ke semua pengguna.');
        } else {
            $this->info('Tidak ada perubahan cuaca yang perlu diberitahukan.');
        }
    }
}
