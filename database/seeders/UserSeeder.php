<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 👤 Admin
        $admin = new User();
        $admin->name = 'Admin1';
        $admin->email = 'admin1@admin.com';
        $admin->phone = '777111222';
        $admin->password = '12345678';  // ✅ يمر عبر casts تلقائياً
        $admin->role = 1;
        $admin->is_active = true;
        $admin->save();

        // 👤 User
        $user = new User();
        $user->name = 'User1';
        $user->email = 'user1@user.com';
        $user->phone = '777333444';
        $user->password = '12345678';  // ✅ يمر عبر casts تلقائياً
        $user->role = 0;
        $user->is_active = true;
        $user->save();
    }
}