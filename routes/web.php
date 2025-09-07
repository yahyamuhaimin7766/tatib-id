<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RaidController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassCleanlinessController;

    // Auth Routes
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Routes
    Route::middleware(\App\Http\Middleware\CheckAuth::class)->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');

    // Pelanggaran
    Route::delete('violations/bulk-destroy', [ViolationController::class, 'bulkDestroy'])->name('violations.bulk.destroy');
    Route::resource('violations', ViolationController::class);

    // Rekap Pelanggaran
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    
    // Admin & Manajemen Siswa
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/upload-students', [AdminController::class, 'uploadStudents'])->name('admin.upload.students');
    Route::delete('admin/students/bulk-destroy', [StudentController::class, 'bulkDestroy'])->name('admin.students.bulk.destroy');
    Route::resource('admin/students', StudentController::class)->names('admin.students');
    
    // Razia
    Route::delete('raids/bulk-destroy', [RaidController::class, 'bulkDestroy'])->name('raids.bulk.destroy');
    Route::resource('raids', RaidController::class);
    
});