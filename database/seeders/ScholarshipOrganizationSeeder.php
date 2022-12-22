<?php

namespace Database\Seeders;

use App\Models\ScholarshipOrganization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScholarshipOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScholarshipOrganization::insert([
            [
                'name' => 'University City Scholars',
                'abbre' => 'UCS',
            ], [
                'name' => 'University Scholars Society',
                'abbre' => 'USS',
            ],
        ]);
    }
}
