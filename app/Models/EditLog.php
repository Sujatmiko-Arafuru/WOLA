<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EditLog extends Model
{
    protected $fillable = [
        'workload_entry_id',
        'user_id',
        'old_quantity',
        'new_quantity',
        'old_time_unit',
        'new_time_unit',
        'old_total_minutes',
        'new_total_minutes',
        'reason',
        'edit_number',
        'admin_notified',
    ];

    /**
     * Get the reason attribute with fallback.
     */
    public function getReasonAttribute($value)
    {
        return $value ?: 'Tidak ada alasan yang diberikan';
    }

    protected function casts(): array
    {
        return [
            'old_quantity' => 'integer',
            'new_quantity' => 'integer',
            'old_total_minutes' => 'integer',
            'new_total_minutes' => 'integer',
            'edit_number' => 'integer',
            'admin_notified' => 'boolean',
        ];
    }

    /**
     * Get the workload entry that owns the edit log.
     */
    public function workloadEntry(): BelongsTo
    {
        return $this->belongsTo(WorkloadEntry::class);
    }

    /**
     * Get the user that made the edit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('admin_notified', false);
    }
}
