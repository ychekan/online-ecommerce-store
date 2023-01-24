<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create([
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);
    }
}
