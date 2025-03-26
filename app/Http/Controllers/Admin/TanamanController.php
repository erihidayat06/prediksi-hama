<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tanaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TanamanController extends Controller
{
    public function index(Tanaman $tanaman)
    {

        $tanamanList = ['padi', 'cabai', 'bawang-merah'];

        foreach ($tanamanList as $tanaman) {
            Tanaman::firstOrCreate(['nm_tanaman' => $tanaman]);
        }

        return view('admin.tanaman.index');
    }

    public function gap(Tanaman $tanaman)
    {
        return view('admin.tanaman.index');
    }
}
