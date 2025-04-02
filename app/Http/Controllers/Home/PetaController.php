<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index(Tanaman $tanaman)
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        return view('home.peta.index', ['tanaman' => $tanaman, 'dataCuaca' => $dataCuaca]);
    }
}
