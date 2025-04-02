<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class GapController extends Controller
{
    public function index(Tanaman $tanaman)
    {
        $getTanaman = Tanaman::latest()->get();
        return view('home.gap.index', ['tanaman' => $tanaman, 'getTanamans' => $getTanaman]);
    }
}
