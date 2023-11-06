<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['id' => '9a8c95e2-fc9c-4b75-b7bf-236adfsd6731', 'name' => 'can_comment', 'is_active' => true]);
    }
}
