<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{

    protected $guarded = ['id'];
    protected $table = 'tanamans'; // Pastikan nama tabel sesuai dengan database
    /**
     * Gunakan 'nm_tanaman' sebagai parameter untuk Route Model Binding.
     */
    public function getRouteKeyName()
    {
        return 'nm_tanaman';
    }

    public function bio()
    {
        return $this->hasMany(Bio::class);
    }

    public function bios()
    {
        return $this->hasMany(Bio::class);
    }
    public function gaps()
    {
        return $this->hasMany(Gap::class);
    }
    public function komoditi()
    {
        return $this->hasMany(Komoditi::class);
    }
    public function panduan()
    {
        return $this->hasMany(Panduan::class);
    }

    use HasFactory;
}
