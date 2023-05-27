<?php

namespace Database\Seeders;

use App\Models\BackendMenu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            BackendMenuSeeder::class,
            ModuleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            GroupSeeder::class,
            FeeTypeSeeder::class,
            SubjectSeeder::class,
            FeeSeeder::class,
            ClassTimeSeeder::class,
            GroupSubjectSeeder::class,
        ]);
    }
}
