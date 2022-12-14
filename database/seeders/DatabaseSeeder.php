<?php

namespace Database\Seeders;

use App\Models\ScholarshipProgram;
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
            RoleSeeder::class,
            ModuleSeeder::class,
            ModuleRoleSeeder::class,
            UserSeeder::class,
            SponsorSeeder::class,
            ScholarshipProgramSeeder::class,
            BaranggaySeeder::class,
            CollegeSeeder::class,
            ProgramSeeder::class,
            ScholarSeeder::class,
            ScholarshipOrganizationSeeder::class,
            ScholarshipOrganizationScholarshipProgramSeeder::class
        ]);
    }
}
