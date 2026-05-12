<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 👤 Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '777111222',
            'password' => '12345678',  // ✅ Laravel يشفرها تلقائياً عبر casts
            'role' => 1,
            'is_active' => true,
        ]);

        // 👤 User
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'phone' => '777333444',
            'password' => '12345678',  // ✅ Laravel يشفرها تلقائياً عبر casts
            'role' => 0,
            'is_active' => true,
        ]);
    }
}