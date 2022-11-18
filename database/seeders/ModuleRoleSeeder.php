<?php

namespace Database\Seeders;

use App\Models\ModuleRole;
use App\Models\Role;
use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        foreach (Module::all() as $module) {
            foreach (Role::all() as $role) {
                $value = ['role_id' => $role->id, 'module_id' => $module->id, 'level' => 0];
                if ($role->role == 'Admin') {
                    $value['level'] = 2;
                }
                $data[] = $value;
            }
        }
        ModuleRole::insert($data);
    }
}
