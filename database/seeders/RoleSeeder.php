<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(
            ['name' => 'Super Admin'],
            [ 'guard_name' => 'admin']
        );

        Role::updateOrCreate(
            ['name' => 'Regular'],
            [ 'guard_name' => 'web']
        );

    }
}
