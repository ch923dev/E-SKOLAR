<?php

namespace Database\Seeders;

use App\Models\ScholarshipOrganizationScholarshipProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScholarshipOrganizationScholarshipProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScholarshipOrganizationScholarshipProgram::insert([
            [
                'scholarship_program_id' => 1,
                'scholarship_organization_id' => 1,
            ],
            [
                'scholarship_program_id' => 1,
                'scholarship_organization_id' => 2,
            ]
        ]);
    }
}
