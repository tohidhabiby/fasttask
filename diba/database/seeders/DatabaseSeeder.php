<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                PermissionSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
            ]
        );
        Artisan::call("passport:install");
    }
}
