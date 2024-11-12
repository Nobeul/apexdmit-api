<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}