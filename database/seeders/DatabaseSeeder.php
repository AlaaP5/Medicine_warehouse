<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompaniesSeeder::class,
            ManufacturesSeeder::class,
            RolesSeeder::class,
            AdminSeeder::class,
            CasesSeeder::class
        ]);
    }
}
