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
            ['phone' => '777111222'],  // ✅ تحقق من الهاتف
            [
                'name' => 'Admin1',
                'email' => 'admin1@admin.com',
                'password' => bcrypt('12345678'),
                'role' => 1,
                'is_active' => true,
            ]
        );

        // 👤 User1
        User::updateOrCreate(
            ['phone' => '777333444'],  // ✅ تحقق من الهاتف
            [
                'name' => 'User1',
                'email' => 'user1@user.com',
                'password' => bcrypt('12345678'),
                'role' => 0,
                'is_active' => true,
            ]
        );
    }
}