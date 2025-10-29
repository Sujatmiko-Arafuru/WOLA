<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'task_description',
        'time_per_unit',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the workload entries for the task.
     */
    public function workloadEntries(): HasMany
    {
        return $this->hasMany(WorkloadEntry::class);
    }

    /**
     * Scope for active tasks.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
