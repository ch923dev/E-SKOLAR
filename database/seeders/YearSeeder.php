<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 6; $i++) {
            $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
            Year::create(
                ['year' => (($i % 100) >= 11) && ($i % 100) <= 13 ?
                $i . 'th year' :
                $i . $ends[$i % 10] . ' year']);
        }
        Year::create([
            'year'=>'Graduate'
        ]);
    }
}
