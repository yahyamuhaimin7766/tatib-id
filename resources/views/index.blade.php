@extends('layouts.app')

@section('title', 'Rekap - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Rekap Data</h1>
        <a href="{{ route('reports.export.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf me-2"></i>Export PDF
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5>Total Pelanggaran</h5>
                    <h2>{{ $totalViolations }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Total Keterlambatan</h5>
                    <h2>{{ $totalLateArrivals }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Violations by Class Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h5><i class="fas fa-table me-2"></i>Pelanggaran Per Kelas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($violationsByClass as $violation)
                            <tr>
                                <td>{{ $violation->kelas }}</td>
                                <td>{{ $violation->pelanggaran }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $violation->jumlah }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Late Arrivals Table -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-clock me-2"></i>Data Keterlambatan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Kelas</th>
                            <th>Nama Siswa</th>
                            <th>Jumlah Terlambat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lateArrivalsByClass as $late)
                            <tr>
                                <td>{{ $late->kelas }}</td>
                                <td>{{ $late->nama }}</td>
                                <td>
                                    <span class="badge bg-warning">{{ $late->jumlah_terlambat }}x</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
