<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Scholar;
use App\Models\ScholarshipOrganization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScholarshipOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ScholarshipOrganization::insert([
            [
                'name' => 'University City Scholars',
                'abbre' => 'UCS',
                'user_id' => User::factory()->create([
                    'name' => 'University City Scholars',
                    'role_id' => Role::firstWhere('role', 'Organization')->id
                ])->id
            ], [
                'name' => 'University Scholars Society',
                'abbre' => 'USS',
                'user_id' => User::factory()->create([
                    'name' => 'University City Scholars',
                    'role_id' => Role::firstWhere('role', 'Organization')->id
                ])->id
            ],
        ]);
    }
}
