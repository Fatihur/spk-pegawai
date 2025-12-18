@extends('layouts.app')
@section('title', 'Input Penilaian - ' . \Carbon\Carbon::parse($periode)->translatedFormat('F Y'))
@section('content')
<div class="card mb-4">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5>Input Penilaian Periode: {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</h5>
        <span class="badge bg-primary">{{ $pegawai->count() }} Pegawai</span>
    </div>
    <div class="card-body">
        <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
            @csrf
            <input type="hidden" name="periode" value="{{ $periode }}">
            
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">No</th>
                            <th style="min-width: 200px;">Nama Pegawai</th>
                            @foreach($kriteria as $k)
                            <th class="text-center" style="min-width: 120px;">
                                {{ $k->kode }}<br>
                                <small class="text-muted fw-normal">{{ $k->nama }}</small>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <strong>{{ $p->nama }}</strong><br>
                                <small class="text-muted">{{ $p->jabatan }}</small>
                            </td>
                            @foreach($kriteria as $k)
                            <td class="text-center">
                                <select name="nilai[{{ $p->id }}][{{ $k->id }}]" class="form-select form-select-sm" required>
                                    @php
                                        $existingNilai = $penilaianExisting[$p->id][$k->id] ?? null;
                                    @endphp
                                    <option value="">-</option>
                                    <option value="5" {{ $existingNilai == 5 ? 'selected' : '' }}>5</option>
                                    <option value="4" {{ $existingNilai == 4 ? 'selected' : '' }}>4</option>
                                    <option value="3" {{ $existingNilai == 3 ? 'selected' : '' }}>3</option>
                                    <option value="2" {{ $existingNilai == 2 ? 'selected' : '' }}>2</option>
                                    <option value="1" {{ $existingNilai == 1 ? 'selected' : '' }}>1</option>
                                </select>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info mt-3">
                <small>
                    <strong>Keterangan Nilai:</strong> 5 = Sangat Baik, 4 = Baik, 3 = Cukup, 2 = Kurang, 1 = Sangat Kurang
                </small>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="{{ route('penilaian.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Semua Penilaian</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            paging: false,
            searching: true,
            info: false,
            ordering: false,
            language: {
                search: "Cari Pegawai:",
                zeroRecords: "Pegawai tidak ditemukan"
            }
        });
    });
</script>
@endsection
