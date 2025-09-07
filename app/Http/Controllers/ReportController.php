<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Violation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $violationsQuery = Violation::with('student')->latest('tanggal_waktu');

        if ($request->filled('kelas') && $request->kelas != 'all') {
            $violationsQuery->whereHas('student', function ($query) use ($request) {
                $query->where('kelas', $request->kelas);
            });
        }

        $violations = $violationsQuery->paginate(15)->appends($request->query());
        $classes = Student::select('kelas')->distinct()->orderBy('kelas')->get();

        return view('reports.index', compact('violations', 'classes'));
    }

    public function exportPdf(Request $request)
    {
        // Logika filter sama seperti di index, tapi tanpa pagination
        $violationsQuery = Violation::with('student')->latest('tanggal_waktu');
        $selectedClass = $request->input('kelas');

        if ($selectedClass && $selectedClass != 'all') {
            $violationsQuery->whereHas('student', function ($query) use ($selectedClass) {
                $query->where('kelas', $selectedClass);
            });
        }
        $violations = $violationsQuery->get();

        $data = [
            'violations' => $violations,
            'selectedClass' => ($selectedClass && $selectedClass != 'all') ? $selectedClass : 'Semua Kelas',
            'reportDate' => now()->format('d F Y')
        ];

        $pdf = Pdf::loadView('reports.pdf', $data);
        $fileName = 'rekap-pelanggaran-' . str_replace(' ', '-', strtolower($data['selectedClass'])) . '-' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }
}