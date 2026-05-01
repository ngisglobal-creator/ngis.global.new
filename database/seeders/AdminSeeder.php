<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // جلب الدور admin
        $role = Role::where('name', 'admin')->first();

        // إنشاء مستخدم Admin إذا لم يكن موجود
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // ضع إيميلك هنا
            [
                'name' => 'Admin',
                'password' => bcrypt('admin@admin.com'), // ضع كلمة المرور هنا
            ]
        );

        // ربط الدور بالمستخدم
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($role);
        }

        $this->command->info('Admin user created successfully!');
    }
}
