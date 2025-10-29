<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Workload Analysis Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk sistem analisis beban kerja pegawai
    |
    */

    'effective_work_minutes' => env('WORKLOAD_EFFECTIVE_MINUTES', 300), // 5 jam = 300 menit
    'work_days_per_week' => env('WORKLOAD_DAYS_PER_WEEK', 5), // Senin - Jumat
    'weeks_per_month' => env('WORKLOAD_WEEKS_PER_MONTH', 4), // 4 minggu per bulan
    'months_per_year' => env('WORKLOAD_MONTHS_PER_YEAR', 12), // 12 bulan per tahun

    /*
    |--------------------------------------------------------------------------
    | Time Unit Conversions
    |--------------------------------------------------------------------------
    |
    | Konversi satuan waktu untuk perhitungan beban kerja
    |
    */

    'time_conversions' => [
        'daily' => 1, // 1 hari = 1 hari
        'weekly' => 5, // 1 minggu = 5 hari
        'monthly' => 20, // 1 bulan = 5 hari * 4 minggu = 20 hari
        'yearly' => 240, // 1 tahun = 5 hari * 4 minggu * 12 bulan = 240 hari
    ],

    /*
    |--------------------------------------------------------------------------
    | Workload Status Thresholds
    |--------------------------------------------------------------------------
    |
    | Threshold untuk menentukan status beban kerja
    |
    */

    'status_thresholds' => [
        'underload_percentage' => 80, // < 80% dari waktu efektif = underload
        'overload_percentage' => 100, // > 100% dari waktu efektif = overload
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Pengaturan notifikasi untuk admin
    |
    */

    'notifications' => [
        'email_enabled' => env('WORKLOAD_EMAIL_NOTIFICATIONS', false),
        'admin_email' => env('WORKLOAD_ADMIN_EMAIL', 'admin@poltekkes-denpasar.ac.id'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | Pengaturan pagination untuk berbagai halaman
    |
    */

    'pagination' => [
        'edit_logs_per_page' => 20,
        'workload_entries_per_page' => 15,
        'users_per_page' => 10,
        'tasks_per_page' => 15,
    ],
];
