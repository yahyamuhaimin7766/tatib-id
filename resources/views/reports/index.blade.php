@extends('layouts.app')

@section('title', 'Rekap - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rekap Laporan Pelanggaran</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form action="{{ route('reports.export.pdf') }}" method="GET" class="d-inline">
                <input type="hidden" name="kelas" value="{{ request('kelas') }}">
                <button type="submit" class="btn btn-sm btn-success">
                    <i class="fas fa-file-pdf me-2"></i>Export to PDF
                </button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('reports.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-auto"><label for="kelas" class="form-label mb-0 fw-bold">Filter Kelas:</label></div>
                <div class="col-auto">
                    <select name="kelas" id="kelas" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="all">Tampilkan Semua Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->kelas }}" {{ request('kelas') == $class->kelas ? 'selected' : '' }}>
                                {{ $class->kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <form action="{{ route('violations.bulk.destroy') }}" method="POST" id="bulk-delete-form-violations"
        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua data yang dipilih?');">
        @csrf
        @method('DELETE')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-file-alt me-2"></i>Daftar Pelanggaran</h5>
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-2"></i>Hapus yang
                    Dipilih</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 1%;"><input type="checkbox" id="select-all"></th>
                                <th style="width: 5%;">No</th>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Poin</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($violations as $index => $violation)
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="ids[]"
                                            value="{{ $violation->id }}" class="item-checkbox"></td>
                                    <td>{{ $violations->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($violation->tanggal_waktu)->format('d M Y H:i') }}</td>
                                    <td>{{ $violation->student->nama ?? 'Siswa Dihapus' }}</td>
                                    <td>{{ $violation->student->kelas ?? 'N/A' }}</td>
                                    <td>{{ $violation->pelanggaran }}</td>
                                    <td><span class="badge bg-danger">{{ $violation->point }}</span></td>
                                    <td>
                                        <a href="{{ route('violations.show', $violation->id) }}"
                                            class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('violations.edit', $violation->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                        <button type="submit" form="delete-form-violation-{{ $violation->id }}"
                                            class="btn btn-sm btn-danger" title="Hapus"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4">Tidak ada data pelanggaran untuk filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($violations->hasPages())
                <div class="card-footer">{{ $violations->links() }}</div>
            @endif
        </div>
    </form>

    @foreach ($violations as $violation)
        <form action="{{ route('violations.destroy', $violation->id) }}" method="POST"
            id="delete-form-violation-{{ $violation->id }}" class="d-none"
            onsubmit="return confirm('Yakin hapus data ini?')">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@section('scripts')
    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
@endsection
