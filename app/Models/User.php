<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ ثوابت الأدوار
    public const ROLE_USER = 0;
    public const ROLE_ADMIN = 1;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // =========================
    // 📌 الطلبات
    // =========================
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // =========================
    // 📌 هل المستخدم أدمن؟
    // =========================
    public function isAdmin(): bool
    {
        return (int) $this->role === self::ROLE_ADMIN;
    }

    // =========================
    // 📌 هل الحساب مفعل؟
    // =========================
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}