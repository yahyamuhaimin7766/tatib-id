@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Hasil Razia</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-search-plus me-2"></i>Data Lengkap Sitaan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <p><strong>Tanggal & Waktu
                            Kejadian:</strong><br>{{ \Carbon\Carbon::parse($raid->tanggal_waktu)->format('d F Y, H:i') }}
                    </p>
                    <p><strong>Nama Siswa:</strong><br>{{ $raid->nama_siswa }}</p>
                    <p><strong>Kelas:</strong><br>{{ $raid->kelas }}</p>
                    <p><strong>Penanggung Jawab (Guru/Staf):</strong><br>{{ $raid->penanggung_jawab }}</p>
                    <p><strong>Keterangan:</strong><br>{{ $raid->keterangan ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Foto Barang Sitaan:</strong></p>
                    @if ($raid->foto_barang)
                        <a href="{{ asset('storage/' . $raid->foto_barang) }}" target="_blank">
                            <img src="{{ asset('storage/' . $raid->foto_barang) }}" class="img-fluid rounded img-thumbnail"
                                alt="Foto Barang">
                        </a>
                    @else
                        <p class="text-muted">Tidak ada foto yang diupload.</p>
                    @endif
                </div>
            </div>
            <hr>
            <a href="{{ route('raids.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali ke
                Rekap</a>
            <a href="{{ route('raids.edit', $raid->id) }}" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Edit Data
                Ini</a>
        </div>
    </div>
@endsection
