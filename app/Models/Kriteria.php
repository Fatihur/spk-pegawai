<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kriteria extends Model
{
    protected $table = 'kriteria';
    
    protected $fillable = ['kode', 'nama', 'bobot', 'jenis'];

    public function subKriteria(): HasMany
    {
        return $this->hasMany(SubKriteria::class);
    }

    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }
}
