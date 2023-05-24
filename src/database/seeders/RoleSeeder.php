<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\Roles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $admin = Role::create(['name' => Roles::ADMIN->value]);
        $moderator = Role::create(['name' => Roles::MODERATOR->value]);
        $editor = Role::create(['name' => Roles::EDITOR->value]);
        $publisher = Role::create(['name' => Roles::PUBLISHER->value]);
        $reader = Role::create(['name' => Roles::READER->value]);
    }
}
