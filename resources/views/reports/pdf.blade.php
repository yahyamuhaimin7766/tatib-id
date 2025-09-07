<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Pelanggaran</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h2,
        .header h3 {
            margin: 0;
            padding: 0;
        }

        .header h2 {
            font-size: 18px;
        }

        .header h3 {
            font-size: 14px;
            font-weight: normal;
        }

        .info-table {
            border: none;
            margin-bottom: 20px;
            width: auto;
        }

        .info-table td {
            border: none;
            padding: 2px 8px 2px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>REKAP LAPORAN PELANGGARAN SISWA</h2>
        <h3>SISTEM TATA TERTIB (SITATIB)</h3>
    </div>

    <table class="info-table">
        <tr>
            <td><strong>Tanggal Laporan</strong></td>
            <td>: {{ $reportDate }}</td>
        </tr>
        <tr>
            <td><strong>Filter Kelas</strong></td>
            <td>: {{ $selectedClass }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 20%;">Tanggal & Waktu</th>
                <th>Nama Siswa</th>
                <th class="text-center" style="width: 10%;">Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th class="text-center" style="width: 8%;">Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($violations as $index => $violation)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($violation->tanggal_waktu)->format('d/m/Y H:i') }}</td>
                    <td>{{ $violation->student->nama ?? 'N/A' }}</td>
                    <td class="text-center">{{ $violation->student->kelas ?? 'N/A' }}</td>
                    <td>{{ $violation->pelanggaran }}</td>
                    <td class="text-center">{{ $violation->point }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data pelanggaran untuk
                        filter yang dipilih.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
