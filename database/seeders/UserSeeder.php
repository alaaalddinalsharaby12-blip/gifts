<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 👤 Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '777111222',
            'password' => 'password123',
            'role' => 1, // admin
            'is_active' => true,
        ]);

        // 👤 User
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'phone' => '777333444',
            'password' => '12345678',
            'role' => 0, // user
            'is_active' => true,
        ]);
    }
}