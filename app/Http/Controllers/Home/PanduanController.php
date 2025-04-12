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
                $crossResistensArray = json_decode($panduan->insektisida->cross_resistens, true) ?? [];
                $saranInsektisidaArray = json_decode($panduan->insektisida->saran_insektisida, true) ?? [];

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

        // ⬇️ Ini yang penting: diolah jadi array siap pakai
        $processedPanduans = $panduans->map(function ($item) {
            return [
                'id' => $item->id,
                'bio_id' => $item->bio_id,
                'insektisida_id' => $item->insektisida_id,
                'bio' => [
                    'id' => $item->bio->id,
                    'nm_hama' => $item->bio->nm_hama,
                ],
                'insektisida' => $item->insektisida ? [
                    'id' => $item->insektisida->id,
                    'nm_insektisida' => $item->insektisida->nm_insektisida,
                    'cross_resistens_names' => $item->insektisida->cross_resistens_names ?? [],
                    'cross_resistens_bahan' => $item->insektisida->cross_resistens_bahan ?? [],
                    'saran_insektisida_names' => $item->insektisida->saran_insektisida_names ?? [],
                    'saran_insektisida_bahan' => $item->insektisida->saran_insektisida_bahan ?? [],
                ] : null,
            ];
        });

        return view('home.panduan.index', [
            'tanaman' => $tanaman,
            'panduans' => $panduans,
            'processedPanduans' => $processedPanduans,
        ]);
    }
}
