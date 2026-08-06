<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // dashboard
            'dashboard.view',

            // users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // roles
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // permissions
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // malls
            'malls.view',
            'malls.create',
            'malls.edit',
            'malls.delete',

            // audit
            'audit.view',

            // profile
            'profile.view',
            'profile.update',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }
    }
}
