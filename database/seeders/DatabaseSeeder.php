<?php

namespace Database\Seeders;

use App\Helpers\RoleHelper;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin_user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '123456',
        ]);

        $this->call(RolesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);

        $admin_role = RoleHelper::getRoleByName('Admin');

        if ($admin_role) {
            $admin_user->roles()->attach($admin_role->id);
        }
    }
}
