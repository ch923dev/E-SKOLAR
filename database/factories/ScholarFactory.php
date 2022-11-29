<?php

namespace Database\Factories;

use App\Models\Baranggay;
use App\Models\Role;
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
        return [
            'user_id' => User::factory()->create(['role_id' => Role::where('role', 'Scholar')->first()->id]),
            'baranggay_id' => Baranggay::inRandomOrder()->first()->id,
            'status' => 3
        ];
    }
}
