@extends('layouts.app')
@section('title', 'Data Pegawai')
@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h5>Daftar Pegawai Non ASN</h5>
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>Tambah</a>
    </div>
    <div class="card-body p-0">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Unit Kerja</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pegawai as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><code>{{ $p->nip }}</code></td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->jabatan }}</td>
                    <td>{{ $p->unit_kerja }}</td>
                    <td><span class="badge bg-info">{{ $p->status }}</span></td>
                    <td>
                        <a href="{{ route('pegawai.edit', $p) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('pegawai.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
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
                { orderable: false, targets: [6] }
            ]
        });
    });
</script>
@endsection
