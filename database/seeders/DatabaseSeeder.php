<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            CollegeSeeder::class,
            ProgramSeeder::class,
            SponsorCategorySeeder::class,
            SponsorSeeder::class,
            YearSeeder::class,
            AcademicSeeder::class,
            ScholarStatusSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            ModuleSeeder::class,
            ModuleRoleSeeder::class
            // ScholarSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1
        ]);
        \App\Models\User::factory(10)->create();
        \App\Models\User::factory(10)->create([
            'role_id' => null
        ]);

    }
}
