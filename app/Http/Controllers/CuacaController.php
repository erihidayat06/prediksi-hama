<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CuacaController extends Controller
{
    public function index(Request $request)
    {

        $dataCuaca = dataCuaca()['weatherData'];

        return view('cuaca', compact('dataCuaca'));
    }


    public function home()
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        return view('index', compact('dataCuaca'));
    }

    public function resitensi()
    {
        $dataCuaca = dataCuaca(true)['weatherData'];
        return view('resitensi', compact('dataCuaca'));
    }
}
