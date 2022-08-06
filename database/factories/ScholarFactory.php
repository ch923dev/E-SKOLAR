<?php

namespace Database\Factories;

use App\Models\Academic;
use App\Models\Program;
use App\Models\ScholarStatus;
use App\Models\Sponsor;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scholar>
 */
class ScholarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fname = fake()->firstName();
        $mname = fake()->lastName();
        $lname = fake()->lastName();
        return [
            'id' => fake()->numberBetween(2016, 2022) . fake()->numerify('######'),
            'fname' => $fname,
            'mname' => $mname,
            'lname' => $lname,
            'program_id' => Program::inRandomOrder()->first()->id,
            'sponsor_id' => Sponsor::inRandomOrder()->first()->id,
            'last_allowance_receive' => Academic::inRandomOrder()->first()->id,
            'year_id' => Year::inRandomOrder()->first()->id,
            'scholar_status_id' => ScholarStatus::inRandomOrder()->first()->id,
            'user_id' => User::factory(1)->create([
                'name' => $fname.' '.$mname[0].'. '. $lname,
                'role_id' => 3,
                'email' => Str::lower($fname).'.'.Str::lower($lname).'@gmail.com',
            ])->first()->id
        ];
    }
}
