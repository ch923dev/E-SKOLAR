<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::insert([
            ['module' => Str::plural('Role'), 'default' => true],
            ['module' => Str::plural('Module'), 'default' => true],
            ['module' => Str::plural('Scholar'), 'default' => true],
            ['module' => Str::plural('User'), 'default' => true],
        ]);
    }
}
