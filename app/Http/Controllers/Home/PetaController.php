<?php

namespace App\Http\Controllers\Home;

use App\Models\User;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use App\Mail\PerubahanCuacaMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PetaController extends Controller
{
    public function index(Tanaman $tanaman)
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        $dataCuacaSebelum = dataCuacaSebelum(true)['weatherData'];





        return view('home.peta.index', ['tanaman' => $tanaman, 'dataCuaca' => $dataCuaca]);
    }
}
