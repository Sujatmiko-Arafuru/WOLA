<?php

// Helper functions untuk sistem beban kerja

if (!function_exists('workload_format_minutes')) {
    /**
     * Format waktu dari menit ke format yang lebih mudah dibaca
     */
    function workload_format_minutes(int $minutes): string
    {
        return \App\Helpers\WorkloadHelper::formatMinutes($minutes);
    }
}

if (!function_exists('workload_get_time_unit_label')) {
    /**
     * Dapatkan label untuk satuan waktu
     */
    function workload_get_time_unit_label(string $timeUnit): string
    {
        return \App\Helpers\WorkloadHelper::getTimeUnitLabel($timeUnit);
    }
}

if (!function_exists('workload_get_time_unit_badge_color')) {
    /**
     * Dapatkan badge color untuk satuan waktu
     */
    function workload_get_time_unit_badge_color(string $timeUnit): string
    {
        return \App\Helpers\WorkloadHelper::getTimeUnitBadgeColor($timeUnit);
    }
}

if (!function_exists('workload_get_status_badge')) {
    /**
     * Dapatkan status badge untuk beban kerja
     */
    function workload_get_status_badge(string $status): array
    {
        return \App\Helpers\WorkloadHelper::getWorkloadStatusBadge($status);
    }
}

if (!function_exists('workload_calculate_percentage')) {
    /**
     * Hitung persentase beban kerja
     */
    function workload_calculate_percentage(int $totalMinutes): float
    {
        return \App\Helpers\WorkloadHelper::calculateWorkloadPercentage($totalMinutes);
    }
}

if (!function_exists('workload_format_nip')) {
    /**
     * Format NIP dengan separator
     */
    function workload_format_nip(string $nip): string
    {
        return \App\Helpers\WorkloadHelper::formatNIP($nip);
    }
}

if (!function_exists('workload_get_avatar')) {
    /**
     * Dapatkan avatar berdasarkan nama
     */
    function workload_get_avatar(string $name): string
    {
        return \App\Helpers\WorkloadHelper::getAvatar($name);
    }
}

if (!function_exists('workload_get_avatar_color')) {
    /**
     * Dapatkan warna avatar berdasarkan nama
     */
    function workload_get_avatar_color(string $name): string
    {
        return \App\Helpers\WorkloadHelper::getAvatarColor($name);
    }
}
