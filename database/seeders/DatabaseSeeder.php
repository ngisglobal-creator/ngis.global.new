<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // استدعاء Seeder الأدوار أولاً
        $this->call(RoleSeeder::class);

        // استدعاء Seeder المسؤول
        $this->call(AdminSeeder::class);

        // مثال: يمكن إضافة Seeders أخرى لاحقاً
        // $this->call(PermissionSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
