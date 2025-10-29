<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboard;
use App\Http\Controllers\Employee\WorkloadController as EmployeeWorkload;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\TaskController as AdminTask;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\NotificationController as AdminNotification;
use App\Http\Controllers\Admin\ReportController as AdminReport;

// Halaman utama - landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes untuk autentikasi
Route::get('/login', [LoginController::class, 'showEmployeeLogin'])->name('login');
Route::get('/login-pegawai', [LoginController::class, 'showEmployeeLogin'])->name('login.pegawai');
Route::get('/login-admin', [LoginController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login-pegawai', [LoginController::class, 'employeeLogin'])->name('login.pegawai.post');
Route::post('/login-admin', [LoginController::class, 'adminLogin'])->name('login.admin.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes untuk pegawai (dengan middleware auth)
Route::middleware(['auth'])->group(function () {
    // Dashboard pegawai
    Route::get('/pegawai/dashboard', [EmployeeDashboard::class, 'index'])->name('pegawai.dashboard');
    
    // Beban kerja pegawai
    Route::get('/pegawai/beban-kerja', [EmployeeWorkload::class, 'index'])->name('pegawai.beban-kerja');
    Route::post('/pegawai/beban-kerja', [EmployeeWorkload::class, 'store']);
    Route::get('/pegawai/beban-kerja/{workloadEntry}/edit', [EmployeeWorkload::class, 'edit'])->name('pegawai.edit-beban-kerja');
    Route::put('/pegawai/beban-kerja/{id}', [EmployeeWorkload::class, 'update'])->name('pegawai.update-beban-kerja');
    Route::delete('/pegawai/beban-kerja/{workloadEntry}', [EmployeeWorkload::class, 'destroy']);
});

// Routes untuk admin (dengan middleware auth dan admin)
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    
    // Kelola tugas
    Route::get('/admin/kelola-tugas', [AdminTask::class, 'index'])->name('admin.kelola-tugas');
    Route::get('/admin/kelola-tugas/tambah', [AdminTask::class, 'create'])->name('admin.tambah-tugas');
    Route::post('/admin/kelola-tugas', [AdminTask::class, 'store']);
    Route::get('/admin/kelola-tugas/{task}/edit', [AdminTask::class, 'edit'])->name('admin.edit-tugas');
    Route::put('/admin/kelola-tugas/{task}', [AdminTask::class, 'update']);
    Route::delete('/admin/kelola-tugas/{task}', [AdminTask::class, 'destroy']);
    Route::patch('/admin/kelola-tugas/{task}/toggle-status', [AdminTask::class, 'toggleStatus'])->name('admin.toggle-status-tugas');
    
    // Kelola akun
    Route::get('/admin/kelola-akun', [AdminUser::class, 'index'])->name('admin.kelola-akun');
    Route::get('/admin/kelola-akun/tambah', [AdminUser::class, 'create'])->name('admin.tambah-akun');
    Route::post('/admin/kelola-akun', [AdminUser::class, 'store']);
    Route::get('/admin/kelola-akun/{user}/edit', [AdminUser::class, 'edit'])->name('admin.edit-akun');
    Route::put('/admin/kelola-akun/{user}', [AdminUser::class, 'update'])->name('admin.update-akun');
    Route::delete('/admin/kelola-akun/{user}', [AdminUser::class, 'destroy']);
    Route::get('/admin/kelola-akun/{user}', [AdminUser::class, 'show'])->name('admin.detail-akun');
    Route::get('/admin/kelola-akun/{user}/password', [AdminUser::class, 'getPassword'])->name('admin.get-password');
    
    // Notifikasi perubahan
    Route::get('/admin/notifikasi-perubahan', [AdminNotification::class, 'index'])->name('admin.notifikasi-perubahan');
    Route::patch('/admin/notifikasi-perubahan/{editLog}/mark-read', [AdminNotification::class, 'markAsRead'])->name('admin.mark-notification-read');
    Route::patch('/admin/notifikasi-perubahan/mark-all-read', [AdminNotification::class, 'markAllAsRead'])->name('admin.mark-all-notifications-read');
    Route::get('/admin/notifikasi-perubahan/{editLog}', [AdminNotification::class, 'show'])->name('admin.detail-perubahan');
    Route::delete('/admin/notifikasi-perubahan/{editLog}', [AdminNotification::class, 'destroy']);
    
    // Sistem & Laporan
        Route::get('/admin/laporan', [AdminReport::class, 'index'])->name('admin.laporan');
        Route::get('/admin/laporan/data-pegawai', [AdminReport::class, 'employees'])->name('admin.laporan.pegawai');
        Route::get('/admin/laporan/data-unit', [AdminReport::class, 'units'])->name('admin.laporan.unit');
        Route::get('/admin/laporan/unit/{unit}/pegawai', [AdminReport::class, 'unitEmployees'])->name('admin.laporan.unit.pegawai');
        Route::get('/admin/laporan/pegawai/{nip}/detail', [AdminReport::class, 'employeeWorkloadDetail'])->name('admin.laporan.pegawai.detail');
        Route::get('/admin/laporan/pegawai/{nip}/pdf', [AdminReport::class, 'downloadEmployeePDF'])->name('admin.laporan.pegawai.pdf');
        Route::get('/admin/laporan/unit/{unit}/pdf', [AdminReport::class, 'downloadUnitPDF'])->name('admin.laporan.unit.pdf');
        Route::get('/admin/laporan/status/{status}/pdf', [AdminReport::class, 'downloadStatusPDF'])->name('admin.laporan.status.pdf');
});