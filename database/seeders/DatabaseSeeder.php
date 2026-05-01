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

        // استدعاء Seeder القطاعات
        $this->call(SectorSeeder::class);

        // استدعاء Seeder تفاصيل القطاعات (فروع وأقسام)
        $this->call(SectorDetailSeeder::class);

        // حالات الطلب
        $this->call(OrderStatusSeeder::class);

        // مثال: يمكن إضافة Seeders أخرى لاحقاً
        // $this->call(PermissionSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
