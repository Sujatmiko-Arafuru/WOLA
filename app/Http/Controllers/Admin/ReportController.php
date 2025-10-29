<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display the report dashboard (redirect to employees)
     */
    public function index()
    {
        return redirect()->route('admin.laporan.pegawai');
    }

    /**
     * Display data pegawai report
     */
    public function employees(Request $request)
    {
        $query = User::where('role', 'employee')
            ->with('workloadEntries.task');

        // Search by name or NIP
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $employees = $query->get();

        // Calculate workload for each employee
        $employeesData = $employees->map(function($user) {
            $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
                return $entry->calculateMinutesPerDay();
            });

            return [
                'user' => $user,
                'total_minutes' => $totalMinutesPerDay,
                'status' => $this->getEmployeeStatus($user),
            ];
        });

        // Filter by status
        if ($request->filled('status')) {
            $employeesData = $employeesData->filter(function($data) use ($request) {
                return $data['status'] === $request->status;
            })->values();
        }

        // Sort by workload
        if ($request->filled('sort')) {
            if ($request->sort === 'asc') {
                $employeesData = $employeesData->sortBy('total_minutes')->values();
            } elseif ($request->sort === 'desc') {
                $employeesData = $employeesData->sortByDesc('total_minutes')->values();
            }
        } else {
            // Default sort by name
            $employeesData = $employeesData->sortBy('user.name')->values();
        }

        // Paginate the results (10 per page)
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedData = $employeesData->slice($offset, $perPage)->values();
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedData,
            $employeesData->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.reports.employees', [
            'employeesData' => $paginatedData,
            'paginator' => $paginator,
            'allEmployeesData' => $employeesData, // Data semua pegawai untuk counting dan download
        ]);
    }

    /**
     * Display unit report
     */
    public function units(Request $request)
    {
        // Get all units
        $units = User::where('role', 'employee')
            ->whereNotNull('unit')
            ->distinct()
            ->pluck('unit')
            ->sort();

        // Calculate unit optimization
        $unitOptimization = $this->calculateUnitOptimization();

        // Filter by unit status if selected
        $selectedUnitStatus = $request->input('unit_status');
        if ($selectedUnitStatus) {
            $unitOptimization = collect($unitOptimization)->filter(function($stats) use ($selectedUnitStatus) {
                return $stats['status'] === $selectedUnitStatus;
            })->toArray();
        }

        return view('admin.reports.units', compact('units', 'unitOptimization', 'selectedUnitStatus'));
    }

    /**
     * Display employees for a specific unit (separate page)
     */
    public function unitEmployees(Request $request, $unit)
    {
        // Decode unit name from URL
        $unitName = urldecode($unit);
        
        // Get all employees from this unit
        $employees = User::where('role', 'employee')
            ->where('unit', $unitName)
            ->with('workloadEntries.task')
            ->get();

        if ($employees->isEmpty()) {
            return redirect()->route('admin.laporan.unit')
                ->with('error', 'Unit tidak ditemukan');
        }

        // Map employee data with workload
        $employeesData = $employees->map(function($user) {
            $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
                return $entry->calculateMinutesPerDay();
            });

            return [
                'user' => $user,
                'total_minutes' => $totalMinutesPerDay,
                'status' => $this->getEmployeeStatus($user),
            ];
        });

        // Filter by employee status if selected
        $selectedEmployeeStatus = $request->input('status');
        if ($selectedEmployeeStatus) {
            $employeesData = $employeesData->filter(function($data) use ($selectedEmployeeStatus) {
                return $data['status'] === $selectedEmployeeStatus;
            })->values();
        }

        // Sort by workload
        if ($request->filled('sort')) {
            if ($request->sort === 'asc') {
                $employeesData = $employeesData->sortBy('total_minutes')->values();
            } elseif ($request->sort === 'desc') {
                $employeesData = $employeesData->sortByDesc('total_minutes')->values();
            }
        } else {
            // Default sort by name
            $employeesData = $employeesData->sortBy('user.name')->values();
        }

        // Paginate the results (10 per page)
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedData = $employeesData->slice($offset, $perPage)->values();
        
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedData,
            $employeesData->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.reports.unit-employees', [
            'unitName' => $unitName,
            'employeesData' => $paginatedData,
            'selectedEmployeeStatus' => $selectedEmployeeStatus,
            'paginator' => $paginator
        ]);
    }

    /**
     * Display employee workload detail (separate page)
     */
    public function employeeWorkloadDetail($nip)
    {
        $user = User::where('nip', $nip)
            ->where('role', 'employee')
            ->with(['workloadEntries.task', 'workloadEntries.editLogs'])
            ->firstOrFail();

        $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
            return $entry->calculateMinutesPerDay();
        });

        $status = $this->getEmployeeStatus($user);

        return view('admin.reports.employee-workload-detail', compact('user', 'totalMinutesPerDay', 'status'));
    }

    /**
     * Get employee workload status
     */
    private function getEmployeeStatus($user)
    {
        $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
            return $entry->calculateMinutesPerDay();
        });

        $effectiveWorkTime = 300; // 5 jam = 300 menit

        if ($totalMinutesPerDay >= $effectiveWorkTime - 10 && $totalMinutesPerDay <= $effectiveWorkTime + 10) {
            return 'optimal';
        } elseif ($totalMinutesPerDay > $effectiveWorkTime + 10) {
            return 'overload';
        } else {
            return 'underload';
        }
    }

    /**
     * Calculate unit optimization based on 90% rule
     */
    private function calculateUnitOptimization()
    {
        $units = User::where('role', 'employee')
            ->whereNotNull('unit')
            ->distinct()
            ->pluck('unit');

        $unitStats = [];

        foreach ($units as $unit) {
            $unitEmployees = User::where('role', 'employee')
                ->where('unit', $unit)
                ->with('workloadEntries.task')
                ->get();

            $total = $unitEmployees->count();
            $optimal = 0;
            $overload = 0;
            $underload = 0;

            foreach ($unitEmployees as $employee) {
                $status = $this->getEmployeeStatus($employee);
                if ($status === 'optimal') {
                    $optimal++;
                } elseif ($status === 'overload') {
                    $overload++;
                } else {
                    $underload++;
                }
            }

            $optimalPercentage = $total > 0 ? ($optimal / $total) * 100 : 0;

            // Determine unit status based on new logic:
            // 1. Optimal: Semua pegawai optimal
            // 2. Kekurangan: Ada yang kurang (dengan/tanpa optimal, tapi tidak ada yang lebih)
            // 3. Kelebihan: Ada yang lebih (dengan/tanpa optimal, tapi tidak ada yang kurang)
            // 4. Campuran: Ada yang kurang DAN ada yang lebih
            
            if ($underload > 0 && $overload > 0) {
                // Ada kurang DAN lebih = Campuran
                $unitStatus = 'mixed';
                $statusLabel = 'Kekurangan dan Kelebihan Beban Kerja';
            } elseif ($underload > 0 && $overload == 0) {
                // Ada yang kurang, tidak ada yang lebih
                $unitStatus = 'underload';
                $statusLabel = 'Kekurangan Beban Kerja';
            } elseif ($overload > 0 && $underload == 0) {
                // Ada yang lebih, tidak ada yang kurang
                $unitStatus = 'overload';
                $statusLabel = 'Kelebihan Beban Kerja';
            } else {
                // Semua optimal
                $unitStatus = 'optimal';
                $statusLabel = 'Optimal';
            }

            $unitStats[$unit] = [
                'total' => $total,
                'optimal' => $optimal,
                'overload' => $overload,
                'underload' => $underload,
                'optimal_percentage' => round($optimalPercentage, 1),
                'status' => $unitStatus,
                'status_label' => $statusLabel,
            ];
        }

        return $unitStats;
    }

    /**
     * Download PDF for individual employee by NIP
     */
    public function downloadEmployeePDF($nip)
    {
        $user = User::where('nip', $nip)
            ->where('role', 'employee')
            ->with('workloadEntries.task')
            ->firstOrFail();

        $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
            return $entry->calculateMinutesPerDay();
        });

        $status = $this->getEmployeeStatus($user);

        $data = [
            'user' => $user,
            'total_minutes' => $totalMinutesPerDay,
            'status' => $status,
            'workload_entries' => $user->workloadEntries,
        ];

        $pdf = PDF::loadView('admin.reports.pdf.employee', $data);
        return $pdf->download('Laporan_Pegawai_' . $nip . '.pdf');
    }

    /**
     * Download PDF for unit report
     */
    public function downloadUnitPDF($unit)
    {
        $employees = User::where('role', 'employee')
            ->where('unit', $unit)
            ->with('workloadEntries.task')
            ->orderBy('name')
            ->get();

        $employeesData = $employees->map(function($user) {
            $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
                return $entry->calculateMinutesPerDay();
            });

            return [
                'user' => $user,
                'total_minutes' => $totalMinutesPerDay,
                'status' => $this->getEmployeeStatus($user),
            ];
        });

        $data = [
            'unit' => $unit,
            'employees' => $employeesData,
        ];

        $pdf = PDF::loadView('admin.reports.pdf.unit', $data);
        return $pdf->download('Laporan_Unit_' . str_replace(' ', '_', $unit) . '.pdf');
    }

    /**
     * Download PDF for status report (all employees with specific status)
     */
    public function downloadStatusPDF($status)
    {
        $employees = User::where('role', 'employee')
            ->with('workloadEntries.task')
            ->orderBy('name')
            ->get();

        $employeesData = $employees->map(function($user) {
            $totalMinutesPerDay = $user->workloadEntries->sum(function($entry) {
                return $entry->calculateMinutesPerDay();
            });

            return [
                'user' => $user,
                'total_minutes' => $totalMinutesPerDay,
                'status' => $this->getEmployeeStatus($user),
            ];
        })->filter(function($data) use ($status) {
            return $data['status'] === $status;
        });

        $statusLabels = [
            'optimal' => 'Optimal',
            'overload' => 'Kelebihan Beban Kerja',
            'underload' => 'Kekurangan Beban Kerja',
        ];

        $data = [
            'status' => $status,
            'status_label' => $statusLabels[$status] ?? $status,
            'employees' => $employeesData,
        ];

        $pdf = PDF::loadView('admin.reports.pdf.status', $data);
        return $pdf->download('Laporan_Status_' . ucfirst($status) . '.pdf');
    }
}
