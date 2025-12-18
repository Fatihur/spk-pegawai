<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penilaian extends Model
{
    protected $table = 'penilaian';
    
    protected $fillable = ['pegawai_id', 'kriteria_id', 'nilai', 'periode'];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
