<?php

namespace App\Services;

use App\Models\WorkloadEntry;
use App\Models\User;
use Carbon\Carbon;

class WorkloadAnalysisService
{
    /**
     * Hitung total menit berdasarkan satuan waktu
     */
    public function calculateTotalMinutes(int $timePerUnit, int $quantity, string $timeUnit): int
    {
        $baseMinutes = $timePerUnit * $quantity;
        
        $conversions = config('workload.time_conversions');
        
        return $baseMinutes * $conversions[$timeUnit];
    }

    /**
     * Tentukan status beban kerja
     */
    public function getWorkloadStatus(int $totalMinutes): array
    {
        $effectiveWorkMinutes = config('workload.effective_work_minutes');
        $underloadThreshold = $effectiveWorkMinutes * (config('workload.status_thresholds.underload_percentage') / 100);
        
        if ($totalMinutes > $effectiveWorkMinutes) {
            return [
                'status' => 'overload',
                'message' => 'Beban Kerja Berlebih',
                'color' => 'danger',
                'icon' => 'fas fa-exclamation-triangle',
                'percentage' => round(($totalMinutes / $effectiveWorkMinutes) * 100, 1)
            ];
        } elseif ($totalMinutes < $underloadThreshold) {
            return [
                'status' => 'underload',
                'message' => 'Beban Kerja Kurang',
                'color' => 'warning',
                'icon' => 'fas fa-info-circle',
                'percentage' => round(($totalMinutes / $effectiveWorkMinutes) * 100, 1)
            ];
        } else {
            return [
                'status' => 'optimal',
                'message' => 'Beban Kerja Optimal',
                'color' => 'success',
                'icon' => 'fas fa-check-circle',
                'percentage' => round(($totalMinutes / $effectiveWorkMinutes) * 100, 1)
            ];
        }
    }

    /**
     * Hitung statistik beban kerja untuk user
     */
    public function getUserWorkloadStats(User $user, Carbon $startDate = null, Carbon $endDate = null): array
    {
        $query = $user->workloadEntries();
        
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
        
        $entries = $query->get();
        
        $totalMinutes = $entries->sum('total_minutes');
        $totalEntries = $entries->count();
        
        $byTimeUnit = [
            'daily' => $entries->where('time_unit', 'daily')->count(),
            'weekly' => $entries->where('time_unit', 'weekly')->count(),
            'monthly' => $entries->where('time_unit', 'monthly')->count(),
            'yearly' => $entries->where('time_unit', 'yearly')->count(),
        ];
        
        $status = $this->getWorkloadStatus($totalMinutes);
        
        return [
            'total_entries' => $totalEntries,
            'total_minutes' => $totalMinutes,
            'by_time_unit' => $byTimeUnit,
            'status' => $status,
            'entries' => $entries
        ];
    }

    /**
     * Hitung statistik sistem secara keseluruhan
     */
    public function getSystemStats(): array
    {
        $totalUsers = User::where('role', 'employee')->count();
        $totalEntries = WorkloadEntry::count();
        $todayEntries = WorkloadEntry::whereDate('created_at', Carbon::today())->count();
        
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'entries' => WorkloadEntry::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'users' => User::where('role', 'employee')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        
        return [
            'total_users' => $totalUsers,
            'total_entries' => $totalEntries,
            'today_entries' => $todayEntries,
            'monthly_stats' => $monthlyStats
        ];
    }

    /**
     * Validasi input beban kerja
     */
    public function validateWorkloadInput(array $data): array
    {
        $errors = [];
        
        if (!isset($data['quantity']) || $data['quantity'] < 1) {
            $errors['quantity'] = 'Jumlah minimal 1';
        }
        
        if (!isset($data['time_unit']) || !in_array($data['time_unit'], ['daily', 'weekly', 'monthly', 'yearly'])) {
            $errors['time_unit'] = 'Satuan waktu tidak valid';
        }
        
        if (!isset($data['task_id'])) {
            $errors['task_id'] = 'Tugas wajib dipilih';
        }
        
        return $errors;
    }

    /**
     * Format waktu dari menit ke format yang lebih mudah dibaca
     */
    public function formatMinutes(int $minutes): string
    {
        if ($minutes < 60) {
            return $minutes . ' menit';
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($remainingMinutes == 0) {
            return $hours . ' jam';
        }
        
        return $hours . ' jam ' . $remainingMinutes . ' menit';
    }

    /**
     * Hitung rata-rata beban kerja per hari
     */
    public function getAverageDailyWorkload(User $user, int $days = 30): float
    {
        $startDate = Carbon::now()->subDays($days);
        $entries = $user->workloadEntries()
            ->where('created_at', '>=', $startDate)
            ->get();
        
        $totalMinutes = $entries->sum('total_minutes');
        
        return $totalMinutes / $days;
    }
}
