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
            'name' => 'Admin1',
            'email' => 'admin1@admin.com',
            'phone' => '777111222',
            'password' => bcrypt('12345678'),  // ✅ تشفير صريح
            'role' => 1,
            'is_active' => true,
        ]);

        // 👤 User
        User::create([
            'name' => 'User1',
            'email' => 'user1@user.com',
            'phone' => '777333444',
            'password' => bcrypt('12345678'),  // ✅ تشفير صريح
            'role' => 0,
            'is_active' => true,
        ]);
    }
}