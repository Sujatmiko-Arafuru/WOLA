<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\WorkloadEntry;
use Illuminate\Support\Facades\DB;

class BalancedWorkloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Clearing existing workload entries...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        WorkloadEntry::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Creating balanced workload data...');

        $units = User::where('role', 'employee')
            ->whereNotNull('unit')
            ->get()
            ->groupBy('unit');

        $tasks = Task::where('is_active', true)->get();

        if ($tasks->isEmpty()) {
            $this->command->error('No tasks found!');
            return;
        }

        $totalWorkloadCount = 0;

        $unitStrategies = [
            'Unit IT' => 'optimal',
            'Akademik' => 'optimal',
            'Jurusan Keperawatan' => 'optimal',
            'Keuangan dan BMN' => 'optimal',
            'Jurusan Teknologi Laboratorium Medis' => 'optimal',
            
            'Unit Pengelola Usaha' => 'underload',
            'Unit Pengembangan Bahasa' => 'underload',
            'Kemahasiswaan' => 'underload',
            'Jurusan Kesehatan Gigi' => 'underload',
            'Satuan Pengawas Internal' => 'underload',
            
            'Unit Laboratorium Terpadu' => 'overload',
            'Unit Perpustakaan Terpadu' => 'overload',
            'Kepegawaian' => 'overload',
            'Jurusan Kebidanan' => 'overload',
            
            'Umum' => 'mixed',
            'Jurusan Gizi' => 'mixed',
            'Jurusan Kesehatan Lingkungan' => 'mixed',
            'Unit Pengembangan Kompetensi' => 'mixed',
        ];

        foreach ($units as $unitName => $employees) {
            $strategy = $unitStrategies[$unitName] ?? 'mixed';
            $employeeCount = $employees->count();
            
            $this->command->info("Processing unit: $unitName ($employeeCount employees) - Strategy: $strategy");

            foreach ($employees as $index => $employee) {
                $targetMinutes = $this->getTargetMinutes($strategy, $index, $employeeCount);
                
                $workloadCount = $this->createAccurateWorkload($employee, $tasks, $targetMinutes);
                $totalWorkloadCount += $workloadCount;
                
                $actualMinutes = $employee->fresh()->workloadEntries->sum(function($entry) {
                    return $entry->calculateMinutesPerDay();
                });
                
                $status = $actualMinutes >= 290 && $actualMinutes <= 310 ? 'OPTIMAL' : 
                         ($actualMinutes > 310 ? 'OVERLOAD' : 'UNDERLOAD');
                $this->command->info("  {$employee->name}: {$status} (Target={$targetMinutes}, Actual=" . round($actualMinutes, 1) . ")");
            }
        }

        $this->command->info('');
        $this->command->info('=================================');
        $this->command->info('Balanced workload data created!');
        $this->command->info('=================================');
        $this->command->info('Total Workload Entries: ' . $totalWorkloadCount);
    }

    private function getTargetMinutes($strategy, $employeeIndex, $totalEmployees)
    {
        switch ($strategy) {
            case 'optimal':
                if ($employeeIndex < $totalEmployees * 0.95) {
                    return rand(295, 305);
                } else {
                    return rand(260, 285);
                }

            case 'underload':
                if ($employeeIndex < $totalEmployees * 0.7) {
                    return rand(230, 280);
                } else {
                    return rand(295, 305);
                }

            case 'overload':
                // All employees should be ≥ optimal, with some overload
                if ($employeeIndex < $totalEmployees * 0.6) {
                    return rand(295, 310); // Optimal
                } else {
                    return rand(315, 360); // Overload
                }

            case 'mixed':
            default:
                $rand = rand(1, 10);
                if ($rand <= 6) {
                    return rand(295, 305);
                } elseif ($rand <= 8) {
                    return rand(245, 285);
                } else {
                    return rand(315, 350);
                }
        }
    }

    /**
     * Create workload entries with accurate targeting
     */
    private function createAccurateWorkload($employee, $tasks, $targetMinutes)
    {
        $workloadCount = 0;
        $currentMinutes = 0.0;
        $remainingMinutes = $targetMinutes;
        
        // Pick 3-5 random tasks
        $numTasks = rand(3, 5);
        $selectedTasks = $tasks->random(min($numTasks, $tasks->count()));
        
        foreach ($selectedTasks as $taskIndex => $task) {
            if ($remainingMinutes <= 0) break;
            
            $timePerUnit = $task->time_per_unit;
            if ($timePerUnit <= 0) continue;
            
            // Determine contribution of this task
            // Last task gets remaining minutes, others get proportional share
            $isLastTask = ($taskIndex == count($selectedTasks) - 1);
            
            if ($isLastTask) {
                $targetForThisTask = $remainingMinutes;
            } else {
                // Allocate roughly equal portions
                $tasksRemaining = count($selectedTasks) - $taskIndex;
                $targetForThisTask = $remainingMinutes / $tasksRemaining;
            }
            
            // Choose time_unit and quantity to match target
            $bestOption = $this->findBestTimeUnitAndQuantity($timePerUnit, $targetForThisTask);
            
            if ($bestOption) {
                WorkloadEntry::create([
                    'user_id' => $employee->id,
                    'task_id' => $task->id,
                    'quantity' => $bestOption['quantity'],
                    'time_unit' => $bestOption['time_unit'],
                    'total_minutes' => $bestOption['quantity'] * $timePerUnit,
                    'edit_count' => 0,
                ]);
                
                $addedMinutes = $bestOption['minutes_per_day'];
                $currentMinutes += $addedMinutes;
                $remainingMinutes -= $addedMinutes;
                $workloadCount++;
            }
        }
        
        return $workloadCount;
    }

    /**
     * Find best time_unit and quantity combination to match target
     */
    private function findBestTimeUnitAndQuantity($timePerUnit, $targetMinutes)
    {
        $options = [];
        $timeUnits = [
            'daily' => 1,
            'weekly' => 5,
            'monthly' => 20,
            'yearly' => 240,
        ];
        
        foreach ($timeUnits as $timeUnit => $divisor) {
            // Try quantities from 1 to 10
            for ($qty = 1; $qty <= 10; $qty++) {
                $minutesPerDay = ($qty * $timePerUnit) / $divisor;
                
                // Calculate how close this is to target
                $diff = abs($minutesPerDay - $targetMinutes);
                
                // Don't go too much over target (max 20% over)
                if ($minutesPerDay > $targetMinutes * 1.2) {
                    continue;
                }
                
                $options[] = [
                    'time_unit' => $timeUnit,
                    'quantity' => $qty,
                    'minutes_per_day' => $minutesPerDay,
                    'diff' => $diff,
                ];
            }
        }
        
        if (empty($options)) {
            return null;
        }
        
        // Sort by smallest difference
        usort($options, function($a, $b) {
            return $a['diff'] <=> $b['diff'];
        });
        
        // Return the best option
        return $options[0];
    }
}
