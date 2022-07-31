<?php

namespace Database\Seeders;

use App\Models\Academic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Academic::insert([
            ['year'=>'2019-2020','semester'=>1],
            ['year'=>'2019-2020','semester'=>2],
            ['year'=>'2020-2021','semester'=>1],
            ['year'=>'2020-2021','semester'=>2],
            ['year'=>'2021-2022','semester'=>1],
            ['year'=>'2021-2022','semester'=>2],
        ]);
    }
}
