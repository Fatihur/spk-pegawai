@extends('layouts.app')
@section('title', 'Perhitungan MFEP')
@section('content')
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Proses Perhitungan MFEP</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-4">
                    <h6 class="mb-2"><i class="bi bi-info-circle me-1"></i>Metode MFEP</h6>
                    <p class="mb-2 small">Multi-Factor Evaluation Process - metode pengambilan keputusan berdasarkan beberapa faktor dengan bobot tertentu.</p>
                    <div class="bg-white rounded p-2">
                        <code>Nilai Total = Σ (Bobot × Nilai Kriteria)</code>
                    </div>
                </div>

                <form action="{{ route('perhitungan.hitung') }}" method="GET" id="formHitung">
                    <div class="mb-3">
                        <label class="form-label">Pilih Periode Penilaian</label>
                        <select name="periode" class="form-select" required id="selectPeriode">
                            <option value="">-- Pilih Periode --</option>
                            @foreach($periodes as $p)
                            @php $sudahDihitung = in_array($p, $periodeSudahDihitung); @endphp
                            <option value="{{ $p }}" {{ $sudahDihitung ? 'disabled' : '' }}>
                                {{ \Carbon\Carbon::parse($p)->translatedFormat('F Y') }}
                                {{ $sudahDihitung ? '(Sudah Dihitung)' : '' }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Periode yang sudah dihitung tidak dapat dipilih</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="btnHitung">
                        <i class="bi bi-calculator me-1"></i>Proses Perhitungan
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-question-circle me-2"></i>Langkah Perhitungan</h6>
            </div>
            <div class="card-body">
                <ol class="mb-0 small">
                    <li class="mb-2">Tentukan bobot setiap kriteria (total = 100%)</li>
                    <li class="mb-2">Input nilai pegawai per kriteria (skala 1-5)</li>
                    <li class="mb-2">Kalikan nilai dengan bobot kriteria</li>
                    <li class="mb-2">Jumlahkan semua hasil perkalian</li>
                    <li>Ranking berdasarkan nilai tertinggi</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Daftar Periode</h5>
            </div>
            <div class="card-body p-0">
                @if($periodes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th class="text-center">Pegawai</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periodes as $i => $p)
                            @php
                                $jumlahPegawai = \App\Models\Penilaian::where('periode', $p)->distinct('pegawai_id')->count('pegawai_id');
                                $sudahDihitung = in_array($p, $periodeSudahDihitung);
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ \Carbon\Carbon::parse($p)->translatedFormat('F Y') }}</strong></td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $jumlahPegawai }}</span>
                                </td>
                                <td class="text-center">
                                    @if($sudahDihitung)
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Sudah Dihitung</span>
                                    @else
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Belum Dihitung</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($sudahDihitung)
                                    <a href="{{ route('perbandingan', ['periode' => $p]) }}" class="btn btn-sm btn-info" title="Lihat Hasil">
                                        <i class="bi bi-eye me-1"></i>Hasil
                                    </a>
                                    @else
                                    <a href="{{ route('perhitungan.hitung', ['periode' => $p]) }}" class="btn btn-sm btn-success" title="Hitung MFEP">
                                        <i class="bi bi-calculator me-1"></i>Hitung
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0">Belum ada data penilaian</p>
                    <p class="small">Silakan input penilaian terlebih dahulu</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
