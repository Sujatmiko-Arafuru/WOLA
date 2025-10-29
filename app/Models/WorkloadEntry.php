<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkloadEntry extends Model
{
    protected $fillable = [
        'user_id',
        'task_id',
        'quantity',
        'time_unit',
        'total_minutes',
        'edit_count',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'total_minutes' => 'integer',
            'edit_count' => 'integer',
        ];
    }

    /**
     * Get the user that owns the workload entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task that owns the workload entry.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the edit logs for the workload entry.
     */
    public function editLogs(): HasMany
    {
        return $this->hasMany(EditLog::class);
    }

    /**
     * Calculate total minutes based on time unit conversion.
     * Rumus baru sesuai spreadsheet:
     * - Harian: time_per_unit * quantity
     * - Mingguan: (time_per_unit * quantity) / 5 (dibagi 5 hari kerja per minggu)
     * - Bulanan: (time_per_unit * quantity) / 20 (dibagi 20 hari kerja per bulan)
     * - Tahunan: (time_per_unit * quantity) / 240 (dibagi 240 hari kerja per tahun)
     */
    public function calculateTotalMinutes(): int
    {
        $task = $this->task;
        $baseMinutes = $task->time_per_unit * $this->quantity;

        // Time unit conversions based on new requirements:
        // 1 minggu = 5 hari kerja
        // 1 bulan = 20 hari kerja (5 hari/minggu * 4 minggu)
        // 1 tahun = 240 hari kerja (5 hari/minggu * 4 minggu * 12 bulan)
        switch ($this->time_unit) {
            case 'daily':
                return $baseMinutes; // Langsung menit per hari
            case 'weekly':
                return round($baseMinutes / 5); // Dibagi 5 hari kerja per minggu
            case 'monthly':
                return round($baseMinutes / 20); // Dibagi 20 hari kerja per bulan
            case 'yearly':
                return round($baseMinutes / 240); // Dibagi 240 hari kerja per tahun
            default:
                return $baseMinutes;
        }
    }

    /**
     * Calculate minutes per day for display purposes.
     */
    public function calculateMinutesPerDay(): float
    {
        $task = $this->task;
        $baseMinutes = $task->time_per_unit * $this->quantity;

        switch ($this->time_unit) {
            case 'daily':
                return $baseMinutes;
            case 'weekly':
                return $baseMinutes / 5;
            case 'monthly':
                return $baseMinutes / 20;
            case 'yearly':
                return $baseMinutes / 240;
            default:
                return $baseMinutes;
        }
    }

    /**
     * Get workload status (optimal, overload, underload).
     * Optimal range: 290-300 menit per hari
     */
    public function getWorkloadStatus(): string
    {
        $minOptimal = 290; // Minimum optimal
        $maxOptimal = 300; // Maximum optimal
        
        if ($this->total_minutes >= $minOptimal && $this->total_minutes <= $maxOptimal) {
            return 'optimal';
        } elseif ($this->total_minutes > $maxOptimal) {
            return 'overload';
        } else {
            return 'underload';
        }
    }
}
