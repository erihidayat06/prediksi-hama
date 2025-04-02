<?php

namespace App\Http\Controllers\Home;

use App\Models\Panduan;
use App\Models\Tanaman;
use App\Models\Golongan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PanduanController extends Controller
{
    public function index(Tanaman $tanaman)
    {
        $panduans = $tanaman->panduan;

        $panduans->each(function ($panduan) {
            if ($panduan->insektisida) {
                // Konversi string JSON menjadi array
                $crossResistensArray = json_decode($panduan->insektisida->cross_resistens, true) ?? [];
                $saranInsektisidaArray = json_decode($panduan->insektisida->saran_insektisida, true) ?? [];

                // Ambil nama golongan dan bahan berdasarkan ID
                $panduan->insektisida->cross_resistens_names = Golongan::whereIn('id', $crossResistensArray)
                    ->pluck('nm_golongan')
                    ->toArray();

                $panduan->insektisida->cross_resistens_bahan = Golongan::whereIn('id', $crossResistensArray)
                    ->pluck('bahan')
                    ->toArray();

                $panduan->insektisida->saran_insektisida_names = Golongan::whereIn('id', $saranInsektisidaArray)
                    ->pluck('nm_golongan')
                    ->toArray();

                $panduan->insektisida->saran_insektisida_bahan = Golongan::whereIn('id', $saranInsektisidaArray)
                    ->pluck('bahan')
                    ->toArray();
            }
        });
        return view('home.panduan.index', ['tanaman' => $tanaman, 'panduans' => $panduans]);
    }
}
