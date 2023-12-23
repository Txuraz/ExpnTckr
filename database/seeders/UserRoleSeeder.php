<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator Role'],
            ['name' => 'user', 'description' => 'Regular user Role'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
