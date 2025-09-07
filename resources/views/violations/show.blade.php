@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Pelanggaran</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-user-check me-2"></i>Data Pelanggaran Siswa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Siswa:</strong><br> {{ $violation->student->nama ?? 'N/A' }}</p>
                    <p><strong>Kelas:</strong><br> {{ $violation->student->kelas ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Kejadian:</strong><br> {{ $violation->created_at->format('d F Y, H:i') }}</p>
                    <p><strong>Diinput oleh:</strong><br> {{ $violation->input_by ?? 'Admin' }}</p>
                </div>
            </div>
            <hr>
            <p><strong>Jenis Pelanggaran:</strong><br> {{ $violation->pelanggaran }}</p>
            {{-- BAGIAN INI DIPASTIKAN BENAR --}}
            <p><strong>Poin Pelanggaran:</strong><br> <span class="badge bg-danger fs-6">{{ $violation->point }}</span></p>
            <hr>
            <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali
                ke Rekap</a>
        </div>
    </div>
@endsection
