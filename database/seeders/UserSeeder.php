<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 👤 Admin1
        User::updateOrCreate(
            ['phone' => '777111222'],
            [
                'name' => 'Admin1',
                'email' => 'admin1@admin.com',
                'password' => bcrypt('12345678'),
                'role' => User::ROLE_ADMIN,  // ✅ استخدام Constant
                'is_active' => true,
            ]
        );

        // 👤 User1
        User::updateOrCreate(
            ['phone' => '777333444'],
            [
                'name' => 'User1',
                'email' => 'user1@user.com',
                'password' => bcrypt('12345678'),
                'role' => User::ROLE_USER,   // ✅ استخدام Constant
                'is_active' => true,
            ]
        );

        // 👤 User موقوف (للاختبار)
        User::updateOrCreate(
            ['phone' => '777555666'],
            [
                'name' => 'BlockedUser',
                'email' => 'blocked@user.com',
                'password' => bcrypt('12345678'),
                'role' => User::ROLE_USER,
                'is_active' => false,        // ❌ حساب موقوف
            ]
        );
    }
}