<?php

declare(strict_types=1);

namespace Database\Seeders;

//use App\Models\User;
use Hypervel\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
