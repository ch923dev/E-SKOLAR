<?php

namespace Database\Seeders;

use App\Models\ScholarshipProgram;
use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScholarshipProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScholarshipProgram::insert([
            ['name' => 'City Scholars', 'sponsor_id' => Sponsor::where('sponsor', 'City Scholarship Office')->first()->id]
        ]);
    }
}
