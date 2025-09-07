@extends('layouts.app')

@section('title', 'Razia - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rekap Hasil Razia</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('raids.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-2"></i>Input Data Baru
            </a>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('raids.index') }}" method="GET" class="row g-3 align-items-center">
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

    {{-- FORM UNTUK HAPUS MASSAL --}}
    <form action="{{ route('raids.bulk.destroy') }}" method="POST" id="bulk-delete-form-raids"
        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua data razia yang dipilih?');">
        @csrf
        @method('DELETE')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-list-ul me-2"></i>Data Tercatat</h5>
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
                                <th>Tanggal & Waktu</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Foto Barang</th>
                                <th>Penanggung Jawab</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($raids as $index => $raid)
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="ids[]"
                                            value="{{ $raid->id }}" class="item-checkbox"></td>
                                    <td>{{ $raids->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($raid->tanggal_waktu)->format('d M Y, H:i') }}</td>
                                    <td>{{ $raid->nama_siswa }}</td>
                                    <td>{{ $raid->kelas }}</td>
                                    <td>
                                        @if ($raid->foto_barang)
                                            <a href="{{ asset('storage/' . $raid->foto_barang) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $raid->foto_barang) }}" alt="Foto Barang"
                                                    width="100">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $raid->penanggung_jawab }}</td>
                                    <td>
                                        <a href="{{ route('raids.show', $raid->id) }}" class="btn btn-sm btn-info"
                                            title="Detail"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('raids.edit', $raid->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit"><i class="fas fa-edit"></i></a>
                                        <button type="submit" form="delete-form-raid-{{ $raid->id }}"
                                            class="btn btn-sm btn-danger" title="Hapus"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4">Tidak ada data hasil razia untuk filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($raids->hasPages())
                <div class="card-footer">{{ $raids->links() }}</div>
            @endif
        </div>
    </form>

    {{-- FORM-FORM TERSEMBUNYI UNTUK HAPUS INDIVIDUAL --}}
    @foreach ($raids as $raid)
        <form action="{{ route('raids.destroy', $raid->id) }}" method="POST" id="delete-form-raid-{{ $raid->id }}"
            class="d-none" onsubmit="return confirm('Yakin hapus data ini?')">
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
