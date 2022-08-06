<?php

namespace Database\Seeders;

use App\Models\Permission;
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
        $data = [];
        foreach (Permission::all() as $value) {
            $data[] = ['role_id' => 1, 'permission_id' => $value->id];
        }
        PermissionRole::insert($data);
    }
}
