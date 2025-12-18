<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    
    protected $fillable = ['nip', 'nama', 'jabatan', 'unit_kerja', 'status'];

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasil(): HasMany
    {
        return $this->hasMany(Hasil::class);
    }
}
