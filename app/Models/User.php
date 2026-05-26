<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    const ROLE_ADMIN  = 'admin';
    const ROLE_LEADER = 'leader';
    const ROLE_STAFF  = 'staff';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'image',
        'position_id',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ---- helpers ----

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isLeader(): bool
    {
        return $this->role === self::ROLE_LEADER;
    }

    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getDashboardRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN  => 'admin.dashboard',
            self::ROLE_LEADER => 'leader.dashboard',
            default           => 'staff.dashboard',
        };
    }
}