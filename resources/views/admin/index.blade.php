@extends('layouts.app')

@section('title', 'Admin - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Panel Admin</h1>
    </div>

    {{-- ======================================================= --}}
    {{-- CARD PERTAMA: UPLOAD DATABASE SISWA (YANG SUDAH ADA) --}}
    {{-- ======================================================= --}}
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-users-cog me-2"></i>Upload Database Siswa</h5>
        </div>
        <div class="card-body">
            <p>Gunakan form di bawah untuk mengupload daftar siswa dari file Excel (.xlsx).</p>
            <p><strong>Penting:</strong> Pastikan baris pertama file Anda adalah header dengan nama kolom persis:
                <strong>nama</strong> dan <strong>kelas</strong> (kolom <strong>nis</strong> opsional).
            </p>

            <form action="{{ route('admin.upload.students') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file_siswa" class="form-label">Pilih File Siswa</label>
                    <input class="form-control @error('file_siswa') is-invalid @enderror" type="file" id="file_siswa"
                        name="file_siswa" required>
                    @error('file_siswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload me-2"></i>Upload dan Proses
                </button>
            </form>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- CARD KEDUA: MANAJEMEN SISWA MANUAL (YANG BARU) --}}
    {{-- ======================================================= --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5><i class="fas fa-tasks me-2"></i>Manajemen Siswa Manual</h5>
        </div>
        <div class="card-body">
            <p>Lihat, tambah, atau edit data siswa satu per satu. Ini adalah cara alternatif jika Anda tidak ingin
                menggunakan Excel.</p>
            <a href="{{ route('admin.students.index') }}" class="btn btn-info">
                <i class="fas fa-users me-2"></i>Buka Manajemen Siswa
            </a>
        </div>
    </div>
@endsection
