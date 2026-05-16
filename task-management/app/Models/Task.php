<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    const STATUSES = [
        'pending'     => 'Pending',
        'in_progress' => 'In Progress',
        'completed'   => 'Completed',
    ];

    const PRIORITIES = [
        'low'    => 'Low',
        'medium' => 'Medium',
        'high'   => 'High',
    ];

    const STATUS_COLORS = [
        'pending'     => 'warning',
        'in_progress' => 'info',
        'completed'   => 'success',
    ];

    const PRIORITY_COLORS = [
        'low'    => 'secondary',
        'medium' => 'primary',
        'high'   => 'danger',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::PRIORITIES[$this->priority] ?? $this->priority;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    public function getPriorityColorAttribute(): string
    {
        return self::PRIORITY_COLORS[$this->priority] ?? 'secondary';
    }

    public function isOverdue(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== 'completed';
    }
}
