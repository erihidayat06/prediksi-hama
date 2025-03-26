<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insektisida extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }
}
