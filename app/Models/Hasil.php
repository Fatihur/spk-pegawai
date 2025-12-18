<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hasil extends Model
{
    protected $table = 'hasil';
    
    protected $fillable = ['pegawai_id', 'periode', 'nilai_mfep', 'ranking_mfep'];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
