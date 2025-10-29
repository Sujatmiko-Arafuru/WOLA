<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\WorkloadEntry;
use App\Models\EditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function index()
    {
        // Statistik umum
        $totalEmployees = User::where('role', 'employee')->count();
        $totalTasks = Task::count();
        $activeTasks = Task::where('is_active', true)->count();
        $totalWorkloadEntries = WorkloadEntry::count();
        
        // Entri beban kerja hari ini
        $todayEntries = WorkloadEntry::whereDate('created_at', Carbon::today())->count();
        
        // Notifikasi perubahan yang belum dibaca
        $unreadNotifications = EditLog::where('admin_notified', false)->count();
        
        // Grafik statistik bulanan
        $monthlyStats = $this->getMonthlyStats();
        
        // Entri beban kerja terbaru
        $recentEntries = WorkloadEntry::with(['user', 'task'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalTasks',
            'activeTasks',
            'totalWorkloadEntries',
            'todayEntries',
            'unreadNotifications',
            'monthlyStats',
            'recentEntries'
        ));
    }

    /**
     * Ambil statistik bulanan
     */
    private function getMonthlyStats()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'entries' => WorkloadEntry::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'employees' => User::where('role', 'employee')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        
        return $months;
    }
}