@extends('layouts.app')

@section('title', 'Dashboard - SITATIB')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="text-muted">{{ now()->format('d F Y') }}</div>
    </div>

    {{-- ======================================================= --}}
    {{-- BARIS 1: GRAFIK DI KIRI, STATS DI KANAN --}}
    {{-- ======================================================= --}}
    <div class="row">

        {{-- KOLOM KIRI (LEBIH LEBAR) UNTUK GRAFIK UTAMA --}}
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar me-2"></i>Point Pelanggaran Per Kelas</h5>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="classPointsChart"></canvas>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN (LEBIH SEMPIT) UNTUK SUMMARY & RANKING --}}
        <div class="col-lg-4 mb-4">
            {{-- Card Total Pelanggaran --}}
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title mb-1">Total Pelanggaran</h6>
                            <h3 class="card-text fw-bold">{{ $totalViolations }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Siswa Terlambat --}}
            <div class="card text-white bg-warning mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="card-title mb-1">Siswa Terlambat</h6>
                            <h3 class="card-text fw-bold">{{ $totalLateArrivals }}</h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Kelas Paling Disiplin --}}
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-trophy me-2"></i>Kelas Paling Disiplin</h5>
                </div>
                <div class="card-body p-2" style="max-height: 250px; overflow-y: auto;">
                    <ul class="list-group list-group-flush">
                        @forelse ($cleanestClasses as $class)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>{{ $loop->iteration }}. {{ $class->kelas }}</strong>
                                <span
                                    class="badge {{ $class->total_violations == 0 ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                    {{ $class->total_violations }} Pelanggaran
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Belum ada data untuk di-ranking.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris 2: Tabel Bawah (Razia & Ranking Siswa) -->
    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5><i class="fas fa-search me-2"></i>Hasil Razia Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentRaids as $raid)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($raid->tanggal_waktu)->format('d/m/y') }}</td>
                                    <td>{{ Str::limit($raid->nama_siswa, 15) }}</td>
                                    <td>{{ $raid->kelas }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center p-3">Belum ada data razia terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('raids.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Data Razia</a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5><i class="fas fa-list-ol me-2"></i>Ranking Siswa Sering Melanggar</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Total Point</th>
                                <th>Jumlah Pelanggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($frequentViolators as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->nama }}</td>
                                    <td>{{ $student->kelas }}</td>
                                    <td><span class="badge bg-danger">{{ $student->total_point }}</span></td>
                                    <td class="text-center">{{ $student->violations_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-3">Belum ada data pelanggaran siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Chart untuk Point Pelanggaran Per Kelas
        const classPointsCtx = document.getElementById('classPointsChart').getContext('2d');
        const classPointsData = @json($classPoints);
        const classPointsChart = new Chart(classPointsCtx, {
            type: 'bar',
            data: {
                labels: classPointsData.map(item => item.kelas),
                datasets: [{
                    label: 'Total Point',
                    data: classPointsData.map(item => item.total_points),
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
