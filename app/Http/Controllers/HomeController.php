<?php

namespace App\Http\Controllers;

use App\Models\Raid;
use App\Models\Student;
use App\Models\Violation;
use App\Models\LateArrival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Data untuk Summary Cards
        $totalViolations = Violation::count();
        $totalLateArrivals = Violation::where('pelanggaran', 'Terlambat')->count();
        
        // Data untuk Grafik Poin Pelanggaran Per Kelas
        $classPoints = Student::select('kelas', DB::raw('SUM(total_point) as total_points'))
            ->groupBy('kelas')
            ->orderBy('total_points', 'desc')
            ->get();
        
        // Data untuk Ranking Siswa Sering Melanggar
        $frequentViolators = Student::withCount('violations')
            ->orderBy('total_point', 'desc')
            ->limit(10)
            ->get();
            
        // Data untuk Hasil Razia Terbaru
        $recentRaids = Raid::latest('tanggal_waktu')->take(5)->get();

        // =======================================================
        // LOGIKA BARU UNTUK KELAS TERBERSIH (PALING DISIPLIN)
        // Dihitung berdasarkan jumlah pelanggaran paling sedikit
        // =======================================================
        $cleanestClasses = DB::table('students')
            ->select('students.kelas', DB::raw('COUNT(violations.id) as total_violations'))
            ->leftJoin('violations', 'students.id', '=', 'violations.student_id')
            ->groupBy('students.kelas')
            ->orderBy('total_violations', 'asc') // Urutkan dari yang terkecil
            //->take(5) // Ambil 5 kelas teratas
            ->get();
        
        return view('home', compact(
            'totalViolations', 
            'totalLateArrivals', 
            'classPoints', 
            'frequentViolators',
            'recentRaids',
            'cleanestClasses' // Variabel ini sekarang berisi data ranking
        ));
    }
}