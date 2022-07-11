<?php

namespace Database\Seeders;

use App\Models\User\Permission;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.

     * @return void
     */
    public function run()
    {
        foreach (Role::$customRoles as $customRole) {
            Role::firstOrCreate([Role::TITLE => $customRole]);
        }

        $role = Role::getRoleByTitle(Role::ADMIN_ROLE);
        $role->permissions()->sync(Permission::all());
    }
}
