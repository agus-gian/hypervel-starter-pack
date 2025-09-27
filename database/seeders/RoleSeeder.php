<?php

declare(strict_types=1);

namespace Database\Seeders;

use Hypervel\Database\Seeder;
use Hypervel\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles for member Admin
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'super-admin', 'guard_name' => 'web']);

        // Create roles for member PWA
        Role::create(['name' => 'member', 'guard_name' => 'sanctum']);
    }
}

