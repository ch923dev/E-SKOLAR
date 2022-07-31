<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::insert([
            ['name' => 'Bachelor of Science in Architecture', 'abbre' => 'bsa', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Civil Engineering', 'abbre' => 'bsce', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Electical Engineering', 'abbre' => 'bselectrical', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Electronics Engineering', 'abbre' => 'bselectronics', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Mechanical Engineering', 'abbre' => 'bsme', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Computer Engineering', 'abbre' => 'bscpe', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Geodetic Engineering', 'abbre' => 'bsge', 'college_id' => 1],
            ['name' => 'Bachelor of Science in Information Technology', 'abbre' => 'bsit', 'college_id' => 2],
            ['name' => 'Bachelor of Science in Technology Communication Management', 'abbre' => 'bstcm', 'college_id' => 2],
            ['name' => 'Bachelor of Science in Data Science', 'abbre' => 'bsds', 'college_id' => 2],
            ['name' => 'Bachelor of Science in Computer Science', 'abbre' => 'bscs', 'college_id' => 2],
            ['name' => 'Bachelor of Science in Applied Mathematics', 'abbre' => 'bsappliedmath', 'college_id' => 3],
            ['name' => 'Bachelor of Science in Applied Physics', 'abbre' => 'bsappliedphysics', 'college_id' => 3],
            ['name' => 'Bachelor of Science in Chemistry', 'abbre' => 'bschem', 'college_id' => 3],
            ['name' => 'Bachelor of Science in Environmental Science', 'abbre' => 'bsenvisci', 'college_id' => 3],
            ['name' => 'Bachelor of Science in Food Technology', 'abbre' => 'bsfoodtech', 'college_id' => 3],
            ['name' => 'Bachelor in Secondary Education Major in Science', 'abbre' => 'bsedms', 'college_id' => 4],
            ['name' => 'Bachelor in Secondary Education Major in Math', 'abbre' => 'bsems', 'college_id' => 4],
            ['name' => 'Bachelor in Technology and Livelihood Education', 'abbre' => 'btled', 'college_id' => 4],
            ['name' => 'Bachelor in Technical-Vocational Teacher Education', 'abbre' => 'btvted', 'college_id' => 4],
            ['name' => 'Bachelor of Science in Electronics Technology', 'abbre' => 'bset', 'college_id' => 5],
            ['name' => 'Bachelor of Science in Autotronics', 'abbre' => 'bsautotronics', 'college_id' => 5],
            ['name' => 'Bachelor of Science in Energy Systems and Management', 'abbre' => 'bsesm', 'college_id' => 5],
            ['name' => 'Bachelor of Science in Electro-Mechanical Technology', 'abbre' => 'bsemt', 'college_id' => 5],
            ['name' => 'Bachelor of Science in Manufacturing Engineering Technology', 'abbre' => 'bsmet', 'college_id' => 5],
        ]);
    }
}
