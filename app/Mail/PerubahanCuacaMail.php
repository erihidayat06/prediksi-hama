<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PerubahanCuacaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $perbandinganWarna;

    /**
     * Create a new message instance.
     */
    public function __construct($perbandinganWarna)
    {
        $this->perbandinganWarna = $perbandinganWarna;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Peringatan Perubahan Cuaca')
            ->view('emails.perubahan_cuaca')
            ->with(['perbandinganWarna' => $this->perbandinganWarna]);
    }
}
