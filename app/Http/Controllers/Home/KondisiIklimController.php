<?php

namespace App\Http\Controllers\Home;

use App\Models\Tanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KondisiIklimController extends Controller
{
    public function index(Tanaman $tanaman)
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        return view('home.kondisi_iklim.index', ['tanaman' => $tanaman, 'dataCuaca' => $dataCuaca]);
    }
}
