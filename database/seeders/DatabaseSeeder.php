<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Penilaian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@spk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kepala Instansi',
            'email' => 'kepala@spk.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_instansi',
        ]);

       
    }
}
