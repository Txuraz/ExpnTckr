<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $createExpensePermission = Permission::create(['name' => 'create-expense', 'slug' => 'create-expense']);
        $editExpensePermission = Permission::create(['name' => 'edit-expense', 'slug' => 'edit-expense']);
        $deleteExpensePermission = Permission::create(['name' => 'delete-expense', 'slug' => 'delete-expense']);

        $adminRole->permissions()->attach([$createExpensePermission->id, $editExpensePermission->id, $deleteExpensePermission->id]); }
}
