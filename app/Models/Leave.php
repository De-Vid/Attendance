<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'approved_by',
        'leader_note',
        'approved_at',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'approved_at' => 'datetime',
    ];

    // ---- Relations ----

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ---- Helpers ----

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'badge-approved',
            'rejected' => 'badge-rejected',
            default    => 'badge-pending',
        };
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'annual'   => 'ច្បាប់ប្រចាំឆ្នាំ',
            'sick'     => 'ច្បាប់ឈឺ',
            'personal' => 'ច្បាប់ផ្ទាល់ខ្លួន',
            'unpaid'   => 'ច្បាប់គ្មានប្រាក់ខែ',
            default    => $this->type,
        };
    }
}
