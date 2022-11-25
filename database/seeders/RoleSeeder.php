<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            ['role' => 'Deactivated', 'default' => true],
            ['role' => 'Admin', 'default' => true],
            ['role' => 'Staff', 'default' => true],
            ['role' => 'Scholar', 'default' => true],
            ['role' => 'Organization', 'default' => true],
        ]);
    }
}
