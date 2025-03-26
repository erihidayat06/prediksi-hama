<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panduan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bio()
    {
        return $this->belongsTo(Bio::class);
    }

    public function insektisida()
    {
        return $this->belongsTo(Insektisida::class);
    }

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }
}
