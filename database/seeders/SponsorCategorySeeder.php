<?php

namespace Database\Seeders;

use App\Models\SponsorCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SponsorCategory::insert([
            ['name' => 'Institutionally Funded Scholarships and Grants for USTP-CDO'],
            ['name' => 'Scholarship Grants'],
            ['name' => 'Merit Scholarships'],
        ]);
    }
}
