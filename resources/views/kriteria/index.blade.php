@extends('layouts.app')
@section('title', 'Data Kriteria')
@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5>Daftar Kriteria Penilaian</h5>
        <a href="{{ route('kriteria.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>Tambah</a>
    </div>
    <div class="card-body p-0">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Jenis</th>
                    <th>Sub Kriteria</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $i => $k)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><code>{{ $k->kode }}</code></td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->bobot * 100 }}%</td>
                    <td><span class="badge bg-{{ $k->jenis == 'benefit' ? 'success' : 'warning' }}">{{ ucfirst($k->jenis) }}</span></td>
                    <td>
                        <a href="{{ route('subkriteria.index', $k) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-list me-1"></i>{{ $k->subKriteria->count() }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('kriteria.edit', $k) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('kriteria.destroy', $k) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kriteria ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: { first: "«", previous: "‹", next: "›", last: "»" }
            },
            columnDefs: [
                { orderable: false, targets: [5, 6] }
            ]
        });
    });
</script>
@endsection
