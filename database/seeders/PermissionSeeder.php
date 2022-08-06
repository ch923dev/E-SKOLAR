<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [ 'name' => 'View Users' ],
            [ 'name' => 'Manage Users' ],
            [ 'name' => 'View Roles' ],
            [ 'name' => 'Manage Roles' ],
            [ 'name' => 'View Permissions' ],
            [ 'name' => 'Manage Permissions' ],
            [ 'name' => 'View Sponsors' ],
            [ 'name' => 'Manage Sponsors' ],
            [ 'name' => 'View Sponsor Categories' ],
            [ 'name' => 'Manage Sponsor Categories' ],
            [ 'name' => 'View Scholars' ],
            [ 'name' => 'Manage Scholars' ],
            [ 'name' => 'View Programs' ],
            [ 'name' => 'Manage Programs' ],
        ]);
    }
}
