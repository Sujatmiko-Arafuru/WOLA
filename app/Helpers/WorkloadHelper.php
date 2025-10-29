<?php

namespace App\Helpers;

class WorkloadHelper
{
    /**
     * Format waktu dari menit ke format yang lebih mudah dibaca
     */
    public static function formatMinutes(int $minutes): string
    {
        if ($minutes < 60) {
            return number_format($minutes) . ' menit';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($remainingMinutes == 0) {
            return $hours . ' jam';
        }
        
        return $hours . ' jam ' . number_format($remainingMinutes) . ' menit';
    }

    /**
     * Format waktu dari menit ke format singkat
     */
    public static function formatMinutesShort(int $minutes): string
    {
        if ($minutes < 60) {
            return $minutes . 'm';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($remainingMinutes == 0) {
            return $hours . 'j';
        }
        
        return $hours . 'j ' . $remainingMinutes . 'm';
    }

    /**
     * Dapatkan label untuk satuan waktu
     */
    public static function getTimeUnitLabel(string $timeUnit): string
    {
        $labels = [
            'daily' => 'Harian',
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
            'yearly' => 'Tahunan',
        ];
        
        return $labels[$timeUnit] ?? $timeUnit;
    }

    /**
     * Dapatkan badge color untuk satuan waktu
     */
    public static function getTimeUnitBadgeColor(string $timeUnit): string
    {
        $colors = [
            'daily' => 'info',
            'weekly' => 'warning',
            'monthly' => 'success',
            'yearly' => 'primary',
        ];
        
        return $colors[$timeUnit] ?? 'secondary';
    }

    /**
     * Dapatkan icon untuk satuan waktu
     */
    public static function getTimeUnitIcon(string $timeUnit): string
    {
        $icons = [
            'daily' => 'fas fa-calendar-day',
            'weekly' => 'fas fa-calendar-week',
            'monthly' => 'fas fa-calendar-alt',
            'yearly' => 'fas fa-calendar',
        ];
        
        return $icons[$timeUnit] ?? 'fas fa-clock';
    }

    /**
     * Dapatkan status badge untuk beban kerja
     */
    public static function getWorkloadStatusBadge(string $status): array
    {
        $badges = [
            'optimal' => ['class' => 'bg-success', 'text' => 'Optimal'],
            'overload' => ['class' => 'bg-danger', 'text' => 'Berlebih'],
            'underload' => ['class' => 'bg-warning', 'text' => 'Kurang'],
        ];
        
        return $badges[$status] ?? ['class' => 'bg-secondary', 'text' => 'Unknown'];
    }

    /**
     * Hitung persentase beban kerja
     */
    public static function calculateWorkloadPercentage(int $totalMinutes): float
    {
        $effectiveWorkMinutes = config('workload.effective_work_minutes', 300);
        return round(($totalMinutes / $effectiveWorkMinutes) * 100, 1);
    }

    /**
     * Format persentase dengan warna
     */
    public static function formatPercentage(float $percentage): array
    {
        if ($percentage > 100) {
            return ['color' => 'text-danger', 'value' => $percentage . '%'];
        } elseif ($percentage < 80) {
            return ['color' => 'text-warning', 'value' => $percentage . '%'];
        } else {
            return ['color' => 'text-success', 'value' => $percentage . '%'];
        }
    }

    /**
     * Dapatkan warna untuk chart berdasarkan status
     */
    public static function getChartColor(string $status): string
    {
        $colors = [
            'optimal' => '#27ae60',
            'overload' => '#e74c3c',
            'underload' => '#f39c12',
        ];
        
        return $colors[$status] ?? '#95a5a6';
    }

    /**
     * Validasi NIP format
     */
    public static function validateNIP(string $nip): bool
    {
        // Format NIP: YYYYMMDDYYYYMMDDXXX (18 karakter)
        return preg_match('/^\d{18}$/', $nip);
    }

    /**
     * Format NIP dengan separator
     */
    public static function formatNIP(string $nip): string
    {
        if (strlen($nip) === 18) {
            return substr($nip, 0, 8) . ' ' . substr($nip, 8, 6) . ' ' . substr($nip, 14, 4);
        }
        
        return $nip;
    }

    /**
     * Dapatkan nama bulan dalam bahasa Indonesia
     */
    public static function getIndonesianMonth(int $month): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $months[$month] ?? 'Unknown';
    }

    /**
     * Dapatkan nama hari dalam bahasa Indonesia
     */
    public static function getIndonesianDay(int $dayOfWeek): string
    {
        $days = [
            0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
            4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'
        ];
        
        return $days[$dayOfWeek] ?? 'Unknown';
    }

    /**
     * Generate random password
     */
    public static function generatePassword(int $length = 8): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
    }

    /**
     * Mask password untuk display
     */
    public static function maskPassword(string $password): string
    {
        return str_repeat('*', strlen($password));
    }

    /**
     * Dapatkan avatar berdasarkan nama
     */
    public static function getAvatar(string $name): string
    {
        $initials = '';
        $words = explode(' ', $name);
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Dapatkan warna avatar berdasarkan nama
     */
    public static function getAvatarColor(string $name): string
    {
        $colors = [
            '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
            '#9b59b6', '#1abc9c', '#34495e', '#e67e22',
            '#8e44ad', '#16a085', '#27ae60', '#f1c40f'
        ];
        
        $hash = crc32($name);
        return $colors[abs($hash) % count($colors)];
    }
}
