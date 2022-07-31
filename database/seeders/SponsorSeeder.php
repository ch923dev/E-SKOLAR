<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sponsor::insert([
            ['name' => 'Entrance Scholarships', 'sponsor_category_id' => 1],
            ['name' => 'Academic Excellence', 'sponsor_category_id' => 1],
            ['name' => 'Leadership Scholarship', 'sponsor_category_id' => 1],
            ['name' => 'Grant-in-Aid for Minority', 'sponsor_category_id' => 1],
            ['name' => 'ARCU Scholarship', 'sponsor_category_id' => 1],
            ['name' => 'Athletic Scholarship', 'sponsor_category_id' => 1],
            ['name' => 'NSTP-ROTC Scholarship', 'sponsor_category_id' => 1],
            ['name' => 'CHED Grant-in-Aids', 'sponsor_category_id' => 2],
            ['name' => 'CEPALCO Educational Assistance Program', 'sponsor_category_id' => 2],
            ['name' => 'ICTSI International Container Terminal Services', 'sponsor_category_id' => 2],
            ['name' => 'NAPOLCOM', 'sponsor_category_id' => 2],
            ['name' => 'FAST Cooperative', 'sponsor_category_id' => 2],
            ['name' => 'The National Commission on Indigenous Peoples (NCIP)', 'sponsor_category_id' => 2],
            ['name' => 'Government Service Insurance System', 'sponsor_category_id' => 2],
            ['name' => 'Private Education Student Financial Assistance (PESFA)', 'sponsor_category_id' => 2],
            ['name' => 'CEPALCO', 'sponsor_category_id' => 3],
            ['name' => 'CHED Scholarship', 'sponsor_category_id' => 3],
            ['name' => 'Del Monte Foundation, Inc.', 'sponsor_category_id' => 3],
            ['name' => 'DBP - Resources Inclusive Sustainable Education (RISE)', 'sponsor_category_id' => 3],
            ['name' => 'DOST - SEI', 'sponsor_category_id' => 3],
            ['name' => 'PLDT - SMART Foundation', 'sponsor_category_id' => 3],
            ['name' => 'City Scholars', 'sponsor_category_id' => 3],
            ['name' => 'Lifebank Foundation', 'sponsor_category_id' => 3],
            ['name' => 'National Grid Corporation of the Philippines', 'sponsor_category_id' => 3],
            ['name' => 'Yokohama Tire Phils. Inc.', 'sponsor_category_id' => 3],
            ['name' => 'Rebisco Foundation Inc.', 'sponsor_category_id' => 3],
            ['name' => 'SM Foundation, Inc.', 'sponsor_category_id' => 3],
            ['name' => 'Philippine Sinter Corporation Foundation', 'sponsor_category_id' => 3],
        ]);
    }
}
