<?php

namespace Database\Factories;

use App\Models\Baranggay;
use App\Models\Program;
use App\Models\Role;
use App\Models\ScholarshipProgram;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $lname = fake()->lastName();
        $name = $fname.' '.$lname;
        return [
            'fname'=> $fname,
            'lname'=> $lname,
            'user_id' => User::factory()->create(['role_id' => Role::where('role', 'Scholar')->first()->id,'name'=>$name]),
            'baranggay_id' => Baranggay::inRandomOrder()->first(),
            'status' => fake()->numberBetween(1, 4),
            'scholarship_program_id'=> ScholarshipProgram::inRandomOrder()->first(),
            'program_id'=> Program::inRandomOrder()->first()
        ];
    }
}
