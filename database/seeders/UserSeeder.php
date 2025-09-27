<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Hypervel\Database\Seeder;
use Hypervel\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super.admin@jinahfinance.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Rahasia@2025'),
        ]);

        $superAdmin->assignRole('super-admin');

        $admin = User::create([
            'name' => 'Regular Admin',
            'email' => 'admin@jinahfinance.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Rahasia@2025'),
        ]);

        $admin->assignRole('admin');
    }
}

