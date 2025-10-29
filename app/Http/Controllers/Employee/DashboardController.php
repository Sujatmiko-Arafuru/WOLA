<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\WorkloadEntry;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard pegawai
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistik kinerja pegawai
        $totalEntries = WorkloadEntry::where('user_id', $user->id)->count();
        $thisMonthEntries = WorkloadEntry::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        
        // Hitung total beban kerja hari ini
        $todayWorkload = WorkloadEntry::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('total_minutes');
        
        // Status beban kerja
        $workloadStatus = $this->getWorkloadStatus($todayWorkload);
        
        // Entri beban kerja terbaru
        $recentEntries = WorkloadEntry::where('user_id', $user->id)
            ->with('task')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'user',
            'totalEntries',
            'thisMonthEntries',
            'todayWorkload',
            'workloadStatus',
            'recentEntries'
        ));
    }

    /**
     * Tentukan status beban kerja
     */
    private function getWorkloadStatus($totalMinutes)
    {
        $effectiveWorkMinutes = 300; // 5 jam = 300 menit
        
        if ($totalMinutes > $effectiveWorkMinutes) {
            return [
                'status' => 'overload',
                'message' => 'Beban Kerja Berlebih',
                'color' => 'danger',
                'icon' => 'fas fa-exclamation-triangle'
            ];
        } elseif ($totalMinutes < $effectiveWorkMinutes * 0.8) {
            return [
                'status' => 'underload',
                'message' => 'Beban Kerja Kurang',
                'color' => 'warning',
                'icon' => 'fas fa-info-circle'
            ];
        } else {
            return [
                'status' => 'optimal',
                'message' => 'Beban Kerja Optimal',
                'color' => 'success',
                'icon' => 'fas fa-check-circle'
            ];
        }
    }
}