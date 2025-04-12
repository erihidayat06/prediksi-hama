<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Mail\PerubahanCuacaMail;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CuacaController;
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
        $controller = new CuacaController();
        $perbandinganWarna = $controller->bandingkanDataCuaca();

        if (!empty($perbandinganWarna)) {
            $users = User::pluck('email')->toArray();

            foreach ($users as $email) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'erihidayat549@gmail.com';
                    $mail->Password = 'ozrhqbajqfzccljc'; // App password Gmail
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('erihidayat549@gmail.com', 'Prediksi Hama');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Peringatan Perubahan Cuaca';
                    $mail->Body    = view('emails.perubahan_cuaca', ['data' => $perbandinganWarna])->render();

                    $mail->send();
                } catch (Exception $e) {
                    Log::error("Gagal mengirim email ke {$email}. Error: {$mail->ErrorInfo}");
                }
            }

            $this->info('Email peringatan cuaca berhasil dikirim ke semua pengguna.');
        } else {
            $this->info('Tidak ada perubahan cuaca yang perlu diberitahukan.');
        }
    }
}
