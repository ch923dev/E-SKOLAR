<?php

namespace Database\Seeders;

use App\Models\PermissionRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionRole::insert([
            ['role_id' => 1,'permission_id' => 1],
            ['role_id' => 1,'permission_id' => 2],
            ['role_id' => 2,'permission_id' => 1],
        ]);
    }
}
