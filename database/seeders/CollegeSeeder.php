<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        College::insert([
            [
                "name" => 'College of Engineering and Architecture',
                "abbre" => 'CEA',
            ],
            [
                "name" => 'College of Information Techonology and Computing',
                "abbre" => 'CITC',
            ],
            [
                "name" => 'College of Science and Mathematics',
                "abbre" => 'CSM',
            ],
            [
                "name" => 'College of Science and Technology Education',
                "abbre" => 'CSTE',
            ],
            [
                "name" => 'College of Technology',
                "abbre" => 'COT',
            ]
        ]);
    }
}
