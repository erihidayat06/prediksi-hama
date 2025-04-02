<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class BioHamaController extends Controller
{
    public function index(Tanaman $tanaman)
    {
        $bio = $tanaman->bio;
        return view('home.bio_hama.index', ['tanaman' => $tanaman, 'dataHama' => $bio]);
    }
}
