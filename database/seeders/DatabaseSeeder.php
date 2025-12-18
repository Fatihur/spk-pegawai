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

        // Kriteria sesuai indikator Diskominfotiksan
        $kriteriaData = [
            ['kode' => 'C1', 'nama' => 'Kedisiplinan', 'bobot' => 0.20, 'jenis' => 'benefit'],
            ['kode' => 'C2', 'nama' => 'Tanggung Jawab', 'bobot' => 0.20, 'jenis' => 'benefit'],
            ['kode' => 'C3', 'nama' => 'Kerja Sama', 'bobot' => 0.20, 'jenis' => 'benefit'],
            ['kode' => 'C4', 'nama' => 'Kehadiran', 'bobot' => 0.20, 'jenis' => 'benefit'],
            ['kode' => 'C5', 'nama' => 'Produktivitas Kerja', 'bobot' => 0.20, 'jenis' => 'benefit'],
        ];

        $subKriteriaTemplate = [
            ['nama' => 'Sangat Baik', 'nilai' => 5],
            ['nama' => 'Baik', 'nilai' => 4],
            ['nama' => 'Cukup', 'nilai' => 3],
            ['nama' => 'Kurang', 'nilai' => 2],
            ['nama' => 'Sangat Kurang', 'nilai' => 1],
        ];

        foreach ($kriteriaData as $k) {
            $kriteria = Kriteria::create($k);
            foreach ($subKriteriaTemplate as $s) {
                SubKriteria::create([
                    'kriteria_id' => $kriteria->id,
                    'nama' => $s['nama'],
                    'nilai' => $s['nilai'],
                ]);
            }
        }

        // Pegawai
        $pegawaiData = [
            ['nip' => '198501012010011001', 'nama' => 'Ahmad Fauzi', 'jabatan' => 'Staff IT', 'unit_kerja' => 'Bidang Infrastruktur'],
            ['nip' => '198702152011012002', 'nama' => 'Siti Rahayu', 'jabatan' => 'Staff Administrasi', 'unit_kerja' => 'Sekretariat'],
            ['nip' => '199003202012011003', 'nama' => 'Budi Santoso', 'jabatan' => 'Programmer', 'unit_kerja' => 'Bidang Aplikasi'],
            ['nip' => '198805102013012004', 'nama' => 'Dewi Lestari', 'jabatan' => 'Analis Data', 'unit_kerja' => 'Bidang Data'],
            ['nip' => '199112252014011005', 'nama' => 'Eko Prasetyo', 'jabatan' => 'Teknisi Jaringan', 'unit_kerja' => 'Bidang Infrastruktur'],
            ['nip' => '198906152015012006', 'nama' => 'Fitri Handayani', 'jabatan' => 'Staff Keuangan', 'unit_kerja' => 'Sekretariat'],
            ['nip' => '199204102016011007', 'nama' => 'Gunawan Wibowo', 'jabatan' => 'Web Developer', 'unit_kerja' => 'Bidang Aplikasi'],
            ['nip' => '199008202017012008', 'nama' => 'Hesti Permata', 'jabatan' => 'Staff Humas', 'unit_kerja' => 'Sekretariat'],
            ['nip' => '198712052018011009', 'nama' => 'Irfan Hakim', 'jabatan' => 'Network Admin', 'unit_kerja' => 'Bidang Infrastruktur'],
            ['nip' => '199305152019012010', 'nama' => 'Julia Putri', 'jabatan' => 'Database Admin', 'unit_kerja' => 'Bidang Data'],
            ['nip' => '198810102020011011', 'nama' => 'Kurniawan Adi', 'jabatan' => 'System Analyst', 'unit_kerja' => 'Bidang Aplikasi'],
            ['nip' => '199107252021012012', 'nama' => 'Linda Sari', 'jabatan' => 'Staff Perencanaan', 'unit_kerja' => 'Sekretariat'],
        ];

        foreach ($pegawaiData as $p) {
            $p['status'] = 'Non ASN';
            Pegawai::create($p);
        }

        // Penilaian untuk periode 2024-12
        $periode = '2024-12';
        $kriteria = Kriteria::all();
        $pegawai = Pegawai::all();

        $nilaiPenilaian = [
            // pegawai_id => [C1, C2, C3, C4, C5]
            1 => [5, 4, 5, 4, 5],
            2 => [4, 5, 4, 5, 4],
            3 => [5, 5, 5, 4, 4],
            4 => [4, 4, 5, 5, 5],
            5 => [3, 4, 4, 4, 5],
            6 => [5, 4, 4, 5, 4],
            7 => [4, 5, 5, 4, 3],
            8 => [4, 4, 3, 5, 5],
            9 => [5, 5, 4, 3, 4],
            10 => [4, 4, 5, 4, 5],
            11 => [5, 4, 4, 5, 4],
            12 => [3, 5, 4, 4, 4],
        ];

        foreach ($nilaiPenilaian as $pegawaiId => $nilai) {
            foreach ($kriteria as $index => $k) {
                Penilaian::create([
                    'pegawai_id' => $pegawaiId,
                    'kriteria_id' => $k->id,
                    'nilai' => $nilai[$index],
                    'periode' => $periode,
                ]);
            }
        }
    }
}
