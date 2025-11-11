<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الدور admin إذا لم يكن موجود
        Role::firstOrCreate(['name' => 'admin']);

        // إنشاء أدوار إضافية كمثال
        Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'user']);

        $this->command->info('Roles have been created successfully!');
    }
}
